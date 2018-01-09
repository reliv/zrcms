<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderLinkHrefTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderScriptSrcTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentCss;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentJs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.admin-tools.{zrcms-component-type}.css' => [
                    'name' => 'zrcms.admin-tools.{zrcms-component-type}.css',
                    'path' => '/zrcms/admin-tools/{zrcms-component-type}.css',
                    'middleware' => [
                        'middleware' => HttpAdminToolsComponentCss::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.admin-tools.{zrcms-component-type}.js' => [
                    'name' => 'zrcms.admin-tools.{zrcms-component-type}.js',
                    'path' => '/zrcms/admin-tools/{zrcms-component-type}.js',
                    'middleware' => [
                        'middleware' => HttpAdminToolsComponentJs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-view-head.head-link' => [
                'sections' => [
                    'modules' => [
                        'zrcms.admin-tools.block.css' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderLinkHrefTagAdminTools::class,
                            RenderLinkHrefTag::OPTION_HREF_ATTRIBUTE => '/zrcms/admin-tools/block.css',
                        ],
                    ],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'modules' => [
                        'zrcms.admin-tools.block.js' => [
                            'renderer' => 'render-service',
                            '__render_service' => RenderScriptSrcTagAdminTools::class,
                            RenderScriptSrcTag::OPTION_SRC_ATTRIBUTE => '/zrcms/admin-tools/block.js',
                        ],
                    ],
                ],
            ],
        ];
    }
}