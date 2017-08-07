<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Theme\Api\Repository\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Repository\ReadThemeComponentRegistry;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponent;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponentsBy;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentRegistry;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\ContentCore\Block\Api\GetRegisterBlockComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;
use Zrcms\ContentCore\Theme\Api\GetRegisterThemeComponents;
use Zrcms\ContentCore\ViewLayoutTags\Api\GetRegisterViewLayoutTagsGetterComponents;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Block Component ===========================================
                     */
                    FindBlockComponent::class => [
                        'class' => This\Block\Api\Repository\FindBlockComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterBlockComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => This\Block\Api\FindBlockComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterBlockComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    ReadBlockComponentRegistry::class => [
                        // @BC 'factory' => This\Block\Api\Repository\ReadBlockComponentRegistryBasicFactory::class,
                        'factory' => This\Block\Api\Repository\ReadBlockComponentRegistryBcFactory::class,
                    ],
                    GetRegisterBlockComponents::class => [
                        'class' => This\Block\Api\GetRegisterBlockComponentsBasic::class,
                        'arguments' => [
                            '0-' => PrepareBlockConfigBc::class,
                            '1-' => ReadBlockComponentRegistry::class,
                            '2-' => Cache::class,
                        ],
                    ],

                    /**
                     * Content (abstracts) ===========================================
                     */
                    SearchConfigList::class => [
                        'class' => SearchConfigList::class,
                    ],

                    /**
                     * Theme Component ===========================================
                     */
                    FindThemeComponent::class => [
                        'class' => This\Theme\Api\Repository\FindThemeComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterThemeComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    FindThemeComponentsBy::class => [
                        'class' => This\Theme\Api\Repository\FindThemeComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterThemeComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    ReadThemeComponentRegistry::class => [
                        'factory' => This\Theme\Api\Repository\ReadThemeComponentRegistryBasicFactory::class,
                    ],
                    GetRegisterThemeComponents::class => [
                        'class' => This\Theme\Api\GetRegisterThemeComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadThemeComponentRegistry::class,
                            '1-' => ReadLayoutComponentConfigJsonFile::class,
                            '2-' => Cache::class
                        ],
                    ],

                    /**
                     * ViewLayoutTagsGetter Component ===========================================
                     */
                    FindViewLayoutTagsGetterComponent::class => [
                        'class' => This\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterViewLayoutTagsGetterComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    FindViewLayoutTagsGetterComponentsBy::class => [
                        'class' => This\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterViewLayoutTagsGetterComponents::class,
                            '1-' => SearchConfigList::class
                        ],
                    ],
                    ReadViewLayoutTagsGetterComponentRegistry::class.'1' => [
                        'factory'
                        => This\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentRegistryBasicFactory::class,

                    ],
                    GetRegisterViewLayoutTagsGetterComponents::class => [
                        'class' => This\ViewLayoutTags\Api\GetRegisterViewLayoutTagsGetterComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadViewLayoutTagsGetterComponentRegistry::class.'1',
                            '1-' => Cache::class
                        ],
                    ],
                ],
            ],
            'zrcms' => [
                'blocks' => [
                    /*
                    '{block-name}' => '{block-location}(directory)'
                    OR
                    '{block-name}' => [
                      ComponentConfigFields::LOCATION => '{block-location}(service-name)',
                      ComponentConfigFields::COMPONENT_CONFIG_READER => '{block-location}(service-name)',
                     ]
                    */
                ],
                'themes' => [
                    /*
                    '{theme-name}' => '{theme-location}(directory)'
                    OR
                    '{theme-name}' => [
                      ComponentConfigFields::LOCATION => '{theme-location}(service-name)',
                      ComponentConfigFields::COMPONENT_CONFIG_READER => '{theme-location}(service-name)',
                     ]
                    */
                ],
                'view-layout-tags-getters' => [
                    /*
                     '{view-layout-tags-getter-name}' => '{view-layout-tags-getter-location}(directory)'
                     OR
                     '{view-layout-tags-getter-name}' => [
                       ComponentConfigFields::LOCATION => '{view-layout-tags-getter-location}(service-name)',
                       ComponentConfigFields::COMPONENT_CONFIG_READER => '{view-layout-tags-getter-location}(service-name)',
                      ]
                     */
                ],
            ],
        ];
    }
}
