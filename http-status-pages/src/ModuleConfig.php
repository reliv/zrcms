<?php

namespace Zrcms\HttpStatusPages;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigComponentRegistryConfig;
use Zrcms\Core\Fields\FieldsComponentRegistry;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpStatusPages\Api\GetStatusPageBasic;
use Zrcms\HttpStatusPages\Fields\FieldsHttpStatusPagesComponent;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage;
use Zrcms\HttpStatusPages\Model\HttpStatusPagesComponent;
use Zrcms\HttpViewRender\Response\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetStatusPage::class => [
                        'class' => GetStatusPageBasic::class,
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindComponent::class,
                        ],
                    ],

                    ResponseMutatorStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                        ],
                    ],
                ],
            ],

            'zrcms-components' => [
                'basic.zrcms-http-status-pages' => [
                    /* 'zrcms-http-status-pages' */
                    FieldsComponentRegistry::NAME
                    => HttpStatusPagesComponent::NAME,

                    /* 'basic.zrcms-http-status-pages' */
                    FieldsComponentRegistry::CONFIG_LOCATION
                    => 'basic.' . HttpStatusPagesComponent::NAME,

                    FieldsComponentRegistry::MODULE_DIRECTORY
                    => __DIR__ . '/..',

                    FieldsComponentRegistry::COMPONENT_CONFIG_READER
                    => ReadComponentConfigComponentRegistryConfig::SERVICE_ALIAS,

                    FieldsComponentRegistry::COMPONENT_CLASS
                    => HttpStatusPagesComponent::class,

                    /**
                     * Map of HTTP status to the path and a type
                     * 'status-to-site-page-path-property-map'
                     */
                    FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY => [
                        '401' => [
                            'path' => '/not-authorized',
                            'type' => 'render',
                        ],
                        '404' => [
                            'path' => '/not-found',
                            'type' => 'render',
                        ],
                    ],
                ],
            ],
        ];
    }
}