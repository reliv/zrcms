<?php

namespace Zrcms\HttpApi;

use Zrcms\Http\Request\JsonBodyParser;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamic;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
use Zrcms\HttpApi\CmsResource\HttpApiCreateCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesByDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesPublishedDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiUpdateCmsResourceDynamic;
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryByDynamic;
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryDynamic;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Component\HttpApiFindComponentsBy;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionDynamic;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionsByDynamic;
use Zrcms\HttpApi\Content\HttpApiInsertContentVersionDynamic;
use Zrcms\HttpApi\Dynamic\HttpApiDynamic;
use Zrcms\HttpApi\Params\HttpApiLimit;
use Zrcms\HttpApi\Params\HttpApiOffset;
use Zrcms\HttpApi\Params\HttpApiOrderBy;
use Zrcms\HttpApi\Params\HttpApiWhere;
use Zrcms\HttpApi\Validate\HttpApiValidateFieldsDynamic;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiIsAllowedZrcmsConfig;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsConfig;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsRoutes;

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
                /**
                 * CreateCmsResource create-cms-resource
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.create' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.create',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/create',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'body-parser' => JsonBodyParser::class,
                        'fields-validator' => HttpApiValidateFieldsDynamic::class,
                        'api' => HttpApiCreateCmsResourceDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'create-cms-resource'
                    ],
                    'allowed_methods' => ['POST'],
                    'swagger' => [
                        'post' => [
                            'description' => 'Create CMS Resource',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResource'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindCmsResource find-cms-resource
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.find.{id}' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.find.{id}',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/find/{id}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        // @todo 'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindCmsResourceDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resource'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find CMS Resource by ID',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsIdPathProperty'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResource'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindCmsResourcesBy find-cms-resources-by
                 */
                'zrcms.api.cms-resources.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.cms-resources.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/cms-resources/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindCmsResourcesByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resources-by'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find CMS Resources by query',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsWhereParameter'],
                                ['$ref' => '#/route-params/ZrcmsOrderByParameter'],
                                ['$ref' => '#/route-params/ZrcmsLimitParameter'],
                                ['$ref' => '#/route-params/ZrcmsOffsetParameter'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResourceList'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindCmsResourcesPublished find-cms-resources-published
                 */
                'zrcms.api.cms-resources.{zrcms-implementation}.find-published' => [
                    'name' => 'zrcms.api.cms-resources.{zrcms-implementation}.find-published',
                    'path' => '/zrcms/api/cms-resources/{zrcms-implementation}/find-published',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindCmsResourcesPublishedDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resources-published'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find published CMS Resources by query',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsWhereParameter'],
                                ['$ref' => '#/route-params/ZrcmsOrderByParameter'],
                                ['$ref' => '#/route-params/ZrcmsLimitParameter'],
                                ['$ref' => '#/route-params/ZrcmsOffsetParameter'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResourceList'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * UpdateCmsResource update-cms-resource
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.update' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.update',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/update',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'body-parser' => JsonBodyParser::class,
                        'fields-validator' => HttpApiValidateFieldsDynamic::class,
                        'api' => HttpApiUpdateCmsResourceDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'update-cms-resource'
                    ],
                    'allowed_methods' => ['PUT'],
                    'swagger' => [
                        'put' => [
                            'description' => 'Update CMS Resource',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResource'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindCmsResourceHistory find-cms-resource-history
                 */
                'zrcms.api.cms-resource-history.{zrcms-implementation}.find.{id}' => [
                    'name' => 'zrcms.api.cms-resource-history.{zrcms-implementation}.find.{id}',
                    'path' => '/zrcms/api/cms-resource-history/{zrcms-implementation}/find/{id}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        // @todo 'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindCmsResourceHistoryDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resource-history'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find CMS Resource History by ID',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsIdPathProperty'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResourceHistory'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindCmsResourceHistoryBy find-cms-resources-by-histories
                 */
                'zrcms.api.cms-resource-histories.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.cms-resource-histories.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/cms-resource-histories/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindCmsResourceHistoryByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resources-by-histories'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find CMS Resource Histories by query',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsWhereParameter'],
                                ['$ref' => '#/route-params/ZrcmsOrderByParameter'],
                                ['$ref' => '#/route-params/ZrcmsLimitParameter'],
                                ['$ref' => '#/route-params/ZrcmsOffsetParameter'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:CmsResourceHistoryList'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * Find ZRCMS Config
                 */
                'zrcms.api.config.list' => [
                    'name' => 'zrcms.api.config.list',
                    'path' => '/zrcms/api/config/list',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedZrcmsConfig::class,
                        'api' => HttpApiZrcmsConfig::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'List all ZRCMS configs',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * Find ZRCMS Routes
                 */
                'zrcms.api.route.list' => [
                    'name' => 'zrcms.api.route.list',
                    'path' => '/zrcms/api/route/list',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedZrcmsConfig::class,
                        'api' => HttpApiZrcmsRoutes::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'List all ZRCMS routes',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindComponent
                 */
                'zrcms.api.component.{zrcms-component-type}.find.{zrcms-component-name}' => [
                    'name' => 'zrcms.api.component.{zrcms-component-type}.find.{zrcms-component-name}',
                    'path' => '/zrcms/api/component/{zrcms-component-type}/find/{zrcms-component-name}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'api' => HttpApiFindComponent::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'List all ZRCMS routes',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsComponentType'],
                                ['$ref' => '#/route-params/ZrcmsComponentName']
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:Component'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindComponentsBy
                 */
                'zrcms.api.components.find-by' => [
                    'name' => 'zrcms.api.components.find-by',
                    'path' => '/zrcms/api/components/find-by',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindComponentsBy::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find Components by query',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsWhereParameter'],
                                ['$ref' => '#/route-params/ZrcmsOrderByParameter'],
                                ['$ref' => '#/route-params/ZrcmsLimitParameter'],
                                ['$ref' => '#/route-params/ZrcmsOffsetParameter'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:ComponentList'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindContentVersion find-content-version
                 */
                'zrcms.api.content-version.{zrcms-implementation}.find.{id}' => [
                    'name' => 'zrcms.api.content-version.{zrcms-implementation}.find.{id}',
                    'path' => '/zrcms/api/content-version/{zrcms-implementation}/find/{id}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        // @todo 'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindContentVersionDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-content-version'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find Content Version by ID',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsIdPathProperty'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:ContentVersion'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindContentVersionsBy find-content-versions-by
                 */
                'zrcms.api.content-versions.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.content-versions.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/content-versions/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindContentVersionsByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-content-versions-by'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find Content Versions by query',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                                ['$ref' => '#/route-params/ZrcmsWhereParameter'],
                                ['$ref' => '#/route-params/ZrcmsOrderByParameter'],
                                ['$ref' => '#/route-params/ZrcmsLimitParameter'],
                                ['$ref' => '#/route-params/ZrcmsOffsetParameter'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:ContentVersionList'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * InsertContentVersion insert-content-version
                 */
                'zrcms.api.content-version.{zrcms-implementation}.insert' => [
                    'name' => 'zrcms.api.content-version.{zrcms-implementation}.insert',
                    'path' => '/zrcms/api/content-version/{zrcms-implementation}/insert',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'body-parser' => JsonBodyParser::class,
                        'fields-validator' => HttpApiValidateFieldsDynamic::class,
                        'api' => HttpApiInsertContentVersionDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'insert-content-version'
                    ],
                    'allowed_methods' => ['POST'],
                    'swagger' => [
                        'post' => [
                            'description' => 'Insert Content Version',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                ['$ref' => '#/route-params/ZrcmsImplementationPathProperty'],
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse:ContentVersion'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
