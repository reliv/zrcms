<?php

namespace Zrcms\HttpContent\CmsResource;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\CmsResource\CmsResourceToArray;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpViewRender\Model\ResponseCodes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResource
{
    const SOURCE = 'zrcms-find-cms-resource';

    /**
     * @var \Zrcms\Content\Api\CmsResource\FindCmsResource
     */
    protected $findCmsResource;

    /**
     * @var CmsResourceToArray
     */
    protected $cmsResourceToArray;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\CmsResource\FindCmsResource $findCmsResource
     * @param CmsResourceToArray                            $cmsResourceToArray
     * @param string                                        $name
     */
    public function __construct(
        \Zrcms\Content\Api\CmsResource\FindCmsResource $findCmsResource,
        CmsResourceToArray $cmsResourceToArray,
        string $name
    ) {
        $this->findCmsResource = $findCmsResource;
        $this->cmsResourceToArray = $cmsResourceToArray;
        $this->name = $name;
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
        $cmsResourceId = (string)$request->getAttribute(
            'id'
        );

        if (empty($cmsResourceId)) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'ID not received',
                'source' => self::SOURCE,
                'code' => ResponseCodes::ID_NOT_RECEIVED,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                400
            );
        }

        $cmsResource = $this->findCmsResource->__invoke(
            $cmsResourceId
        );

        if (empty($cmsResource)) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'Find failed',
                'source' => self::SOURCE,
                'code' => ResponseCodes::FAILED,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                404
            );
        }

        $result = $this->cmsResourceToArray->__invoke(
            $cmsResource
        );

        return new ZrcmsJsonResponse(
            $result
        );
    }
}
