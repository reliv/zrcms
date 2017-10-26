<?php

namespace Zrcms\HttpExpressive\HttpRender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Stream;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\GetViewByRequestHtmlPage;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpExpressive\Api\IsValidContentType;
use Zrcms\HttpExpressive\Http\ZrcmsHtmlResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorThemeLayoutWrapper
{
    /**
     * @var GetViewByRequestHtmlPage
     */
    protected $getViewByRequestHtmlPage;
    /**
     * @var GetViewLayoutTags
     */
    protected $getViewLayoutTags;
    /**
     * @var RenderView
     */
    protected $renderView;
    /**
     * @var array
     */
    protected $validContentTypes;

    /**
     * @param GetViewByRequestHtmlPage $getViewByRequestHtmlPage
     * @param GetViewLayoutTags        $getViewLayoutTags
     * @param RenderView               $renderView
     * @param array                    $validContentTypes
     */
    public function __construct(
        GetViewByRequestHtmlPage $getViewByRequestHtmlPage,
        GetViewLayoutTags $getViewLayoutTags,
        RenderView $renderView,
        array $validContentTypes = ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', '']
    ) {
        $this->getViewByRequestHtmlPage = $getViewByRequestHtmlPage;
        $this->getViewLayoutTags = $getViewLayoutTags;
        $this->renderView = $renderView;
        $this->validContentTypes = $validContentTypes;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var HtmlResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        $options = $this->getProperties($response);

        try {
            /** @var View $view */
            $view = $this->getViewByRequestHtmlPage->__invoke(
                $request,
                $options
            );
        } catch (SiteNotFoundException $exception) {
            return new HtmlResponse(
                'NOT FOUND',
                404,
                ['reason-phrase', 'NOT FOUND: SITE']
            );
        } catch (PageNotFoundException $exception) {
            return new HtmlResponse(
                'NOT FOUND',
                404,
                ['reason-phrase', 'NOT FOUND: PAGE']
            );
        }

        if (empty($view)) {
            return new HtmlResponse(
                'NOT FOUND',
                404,
                ['reason-phrase', 'NOT FOUND: NO VIEW']
            );
        }

        $viewRenderTags = $this->getViewLayoutTags->__invoke(
            $view,
            $request
        );

        $html = $this->renderView->__invoke(
            $view,
            $viewRenderTags
        );

        $body = new Stream('php://temp', 'wb+');
        $body->write($html);
        $body->rewind();

        return $response->withBody($body)
            ->withAddedHeader('zrcms-response-mutator', 'ResponseMutatorThemeLayoutWrapper');
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function getProperties(ResponseInterface $response)
    {
        $properties = [];
        if ($response instanceof ZrcmsHtmlResponse) {
            $properties = $response->getProperties();
        }

        $body = $response->getBody();
        $body->rewind();

        $contents = $body->getContents();

        $properties[GetViewByRequestHtmlPage::OPTION_HTML] = $contents;

        return $properties;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ):bool
    {
        if (!IsValidContentType::invoke($response, $this->validContentTypes)) {
            return false;
        }

        $body = $response->getBody();
        $body->rewind();

        $contents = $body->getContents();

        // @todo this need to be improved, only wrap if there is not complete HTML
        if (stripos($contents, '<html') !== false) {
            return false;
        }

        return true;
    }
}