<?php

namespace Zrcms\HttpViewRender\Acl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyPageVersionId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpIsAllowedViewStrategyPageVersionId implements MiddlewareInterface
{
    const DEFAULT_NOT_ALLOWED_MESSAGE = 'NOT ALLOWED';
    const DEFAULT_NOT_ALLOWED_STATUS = 401;
    const DEFAULT_NOT_ALLOWED_HEADERS = ['reason-phrase' => 'NOT ALLOWED: RENDER VERSION ID'];

    protected $determineViewStrategyPageVersionId;
    protected $notAllowedMessage;
    protected $notAllowedStatus;
    protected $notAllowedHeaders;

    /**
     * @param DetermineViewStrategyPageVersionId $determineViewStrategyPageVersionId
     * @param string                             $notAllowedMessage
     * @param int                                $notAllowedStatus
     * @param array                              $notAllowedHeaders
     */
    public function __construct(
        DetermineViewStrategyPageVersionId $determineViewStrategyPageVersionId,
        string $notAllowedMessage = self::DEFAULT_NOT_ALLOWED_MESSAGE,
        int $notAllowedStatus = self::DEFAULT_NOT_ALLOWED_STATUS,
        array $notAllowedHeaders = self::DEFAULT_NOT_ALLOWED_HEADERS
    ) {
        $this->determineViewStrategyPageVersionId = $determineViewStrategyPageVersionId;
        $this->notAllowedMessage = $notAllowedMessage;
        $this->notAllowedStatus = $notAllowedStatus;
        $this->notAllowedHeaders = $notAllowedHeaders;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $strategyResult = $this->determineViewStrategyPageVersionId->__invoke(
            $request
        );

        if ($strategyResult->getStatus() === 401) {
            return new HtmlResponse(
                $this->notAllowedMessage,
                $this->notAllowedStatus,
                $this->notAllowedHeaders
            );
        }

        return $delegate->process($request);
    }
}
