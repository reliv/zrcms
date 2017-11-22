<?php

namespace Zrcms\HttpStatusPages\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Basic\Api\Component\FindBasicComponent;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpStatusPages\Model\HttpStatusPagesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetStatusPageBasic implements GetStatusPage
{
    /**
     * @var GetSiteCmsResourceByRequest
     */
    protected $getSiteCmsResourceByRequest;

    /**
     * @var FindBasicComponent
     */
    protected $findBasicComponent;

    /**
     * @param GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest
     * @param FindBasicComponent          $findBasicComponent
     */
    public function __construct(
        GetSiteCmsResourceByRequest $getSiteCmsResourceByRequest,
        FindBasicComponent $findBasicComponent
    ) {
        $this->getSiteCmsResourceByRequest = $getSiteCmsResourceByRequest;
        $this->findBasicComponent = $findBasicComponent;
    }

    /**
     * @param ServerRequestInterface $request
     * @param int                    $status
     *
     * @return null|string
     */
    public function __invoke(
        ServerRequestInterface $request,
        int $status
    ) {
        $status = (string)$status;

        /** @var HttpStatusPagesComponent $component */
        $component = $this->findBasicComponent->__invoke(
            HttpStatusPagesComponent::NAME
        );

        $statusPage = $component->findStatusPage($status);

        $siteCmsResource = $this->getSiteCmsResourceByRequest->__invoke($request);

        // Try to get the $statusPage from site
        if (!empty($siteCmsResource)) {
            $siteVersion = $siteCmsResource->getContentVersion();
            $statusPage = $siteVersion->findStatusPage(
                $status,
                $statusPage
            );
        }

        return $statusPage;
    }
}
