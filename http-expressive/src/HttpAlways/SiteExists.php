<?php

namespace Zrcms\HttpExpressive\HttpAlways;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteExists
{
    /**
     * @var GetSiteCmsResourceByRequest
     */
    protected $getSiteCmsResourceByRequest;

    /**
     * @var int
     */
    protected $notFoundStatus;

    /**
     * @var string
     */
    protected $notFoundMessage = '';

    /**
     * @var array
     */
    protected $notFoundHeaders = [];

    /**
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param int                         $notFoundStatus
     * @param string                      $notFoundMessage
     * @param array                       $notFoundHeaders
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        $notFoundStatus = 404,
        $notFoundMessage = '',
        $notFoundHeaders = []
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->notFoundStatus = $notFoundStatus;
        $this->notFoundMessage = $notFoundMessage;
        $this->notFoundHeaders = $notFoundHeaders;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return HtmlResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var SiteCmsResource $siteCmsResource */
        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke(
            $request
        );

        if (empty($siteCmsResource)) {
            return new HtmlResponse(
                $this->notFoundMessage,
                $this->notFoundStatus,
                $this->notFoundHeaders
            );
        }

        return $next($request, $response);
    }
}