<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCore\Block\Api\GetMergedConfig;
use Zrcms\ContentCore\Block\Api\GetMergedConfigBasic;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfig;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBc;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBcFactory;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfig;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigBasic;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigBc;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigBcFactory;
use Zrcms\ContentCore\Block\Api\Repository\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTags;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTagsBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMustache;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockVersionsByContainer;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockData;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockDataBasic;
use Zrcms\ContentCore\Block\Api\Repository\GetBlockDataNoop;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersionLegacy;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBasic;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerBasic;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerRows;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBy;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersionsBy;
use Zrcms\ContentCore\Container\Api\Repository\InsertContainerVersion;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainerLegacy;
use Zrcms\ContentCore\Container\Model\ServiceAliasContainer;
use Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource;
use Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource;
use Zrcms\ContentCore\Page\Api\Action\PublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Action\UnpublishPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTags;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsBasic;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsBlocks;
use Zrcms\ContentCore\Page\Api\Render\GetPageContainerRenderTagsHtml;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainer;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerBasic;
use Zrcms\ContentCore\Page\Api\Render\RenderPageContainerRows;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResource;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourceBySitePath;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerCmsResourcesBy;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersion;
use Zrcms\ContentCore\Page\Api\Repository\FindPageContainerVersionsBy;
use Zrcms\ContentCore\Page\Api\Repository\InsertPageContainerVersion;
use Zrcms\ContentCore\Page\Model\ServiceAliasPageContainer;
use Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourceByHost;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResourcesBy;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion;
use Zrcms\ContentCore\Site\Api\Repository\FindSiteVersionsBy;
use Zrcms\ContentCore\Site\Api\Repository\InsertSiteVersion;
use Zrcms\ContentCore\Theme\Api\Repository\ReadLayoutComponentConfig;
use Zrcms\ContentCore\Theme\Api\Repository\ReadLayoutComponentConfigBasic;
use Zrcms\ContentCore\Theme\Api\Repository\ReadLayoutComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Repository\ReadThemeComponentConfig;
use Zrcms\ContentCore\Theme\Api\Repository\ReadThemeComponentConfigBasic;
use Zrcms\ContentCore\Theme\Api\Repository\ReadThemeComponentConfigJsonFile;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderData;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderDataBasic;
use Zrcms\ContentCore\Theme\Api\Render\GetLayoutRenderDataNoop;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayout;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutBasic;
use Zrcms\ContentCore\Theme\Api\Render\RenderLayoutMustache;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResource;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourceByThemeNameLayoutName;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResourcesBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersion;
use Zrcms\ContentCore\Theme\Api\Repository\FindLayoutVersionsBy;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent;
use Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponentsBy;
use Zrcms\ContentCore\Theme\Api\Repository\InsertLayoutVersion;
use Zrcms\ContentCore\Theme\Model\ServiceAliasLayout;
use Zrcms\ContentCore\Theme\Model\ServiceAliasTheme;
use Zrcms\ContentCore\View\Api\GetLayoutName;
use Zrcms\ContentCore\View\Api\GetLayoutNameBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderTags;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderTagsBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderTagsContainers;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderTagsPage;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Render\RenderViewBasic;
use Zrcms\ContentCore\View\Api\Render\RenderViewLayout;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayout;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutBasic;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayoutMustache;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequestBasic;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentConfig;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentConfigApplicationConfig;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentConfigApplicationConfigFactory;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentConfigBasic;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\ReadViewLayoutTagsGetterComponentConfigJsonFile;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponent;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponentsBy;
use Zrcms\ContentCore\ViewLayoutTags\Model\ServiceAliasViewLayoutTagsGetter;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

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
                     * Block ===========================================
                     */
                    GetBlockRenderTags::class => [
                        'class' => GetBlockRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetBlockData::class,
                            '1-' => GetMergedConfig::class,
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => RenderBlockBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindBlockComponent::class,
                        ],
                    ],
                    RenderBlockBc::class => [
                        'factory' => RenderBlockBcFactory::class,
                    ],
                    RenderBlockMustache::class => [
                        'arguments' => [
                            '0-' => FindBlockComponent::class,
                        ],
                    ],
                    FindBlockComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockComponent::class],
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockComponentsBy::class],
                        ],
                    ],
                    FindBlockVersionsByContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockVersionsByContainer::class],
                        ],
                    ],
                    GetBlockData::class => [
                        'class' => GetBlockDataBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindBlockComponent::class
                        ],
                    ],
                    GetBlockDataNoop::class => [],
                    GetBlockConfigFields::class => [
                        'class' => GetBlockConfigFields::class,
                    ],
                    GetBlockConfigFieldsBcSubstitution::class => [
                        'class' => GetBlockConfigFieldsBcSubstitution::class,
                    ],
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],
                    PrepareBlockConfig::class => [
                        'class' => PrepareBlockConfigBc::class,
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    PrepareBlockConfigBc::class => [
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    ReadBlockComponentConfig::class => [
                        'class' => ReadBlockComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadBlockComponentConfigBc::class => [
                        'factory' => ReadBlockComponentConfigBcFactory::class
                    ],
                    ReadBlockComponentConfigJsonFile::class => [
                        'class' => ReadBlockComponentConfigJsonFile::class,
                    ],

                    WrapRenderedBlockVersion::class => [
                        'class' => WrapRenderedBlockVersionLegacy::class,
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],

                    /**
                     * Container ===========================================
                     */
                    PublishContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishContainerCmsResource::class],
                        ],
                    ],
                    UnpublishContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishContainerCmsResource::class],
                        ],
                    ],
                    GetContainerRenderTags::class => [
                        'class' => GetContainerRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetContainerRenderTagsBlocks::class => [
                        'arguments' => [
                            '0-' => FindBlockVersionsByContainer::class,
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderTags::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class,
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => RenderContainerBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    RenderContainerRows::class => [
                        'arguments' => [
                            '0-' => RenderBlock::class,
                            '1-' => WrapRenderedContainer::class
                        ],
                    ],
                    FindContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerCmsResource::class],
                        ],
                    ],
                    FindContainerCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerCmsResourcesBy::class],
                        ],
                    ],
                    FindContainerCmsResourcesBySitePaths::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerCmsResourcesBySitePaths::class],
                        ],
                    ],
                    FindContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerVersion::class],
                        ],
                    ],
                    FindContainerVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindContainerVersionsBy::class],
                        ],
                    ],
                    InsertContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertContainerVersion::class],
                        ],
                    ],
                    WrapRenderedContainer::class => [
                        'class' => WrapRenderedContainerLegacy::class,
                    ],
                    WrapRenderedContainerLegacy::class => [],

                    /**
                     * Page ===========================================
                     */
                    PublishPageContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishPageContainerCmsResource::class],
                        ],
                    ],
                    UnpublishPageContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishPageContainerCmsResource::class],
                        ],
                    ],
                    GetPageContainerRenderTags::class => [
                        'class' => GetPageContainerRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetPageContainerRenderTagsBlocks::class => [
                        'arguments' => [
                            '0-' => FindBlockVersionsByContainer::class,
                            '1-' => RenderBlock::class,
                            '2-' => GetBlockRenderTags::class,
                            '3-' => WrapRenderedBlockVersion::class,
                            '4-' => WrapRenderedContainer::class
                        ],
                    ],
                    GetPageContainerRenderTagsHtml::class => [],
                    RenderPageContainer::class => [
                        'class' => RenderPageContainerBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    RenderPageContainerRows::class => [
                        'arguments' => [
                            '0-' => RenderBlock::class,
                            '1-' => WrapRenderedContainer::class
                        ],
                    ],
                    FindPageContainerCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerCmsResource::class],
                        ],
                    ],
                    FindPageContainerCmsResourceBySitePath::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerCmsResourceBySitePath::class],
                        ],
                    ],
                    FindPageContainerCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerCmsResourcesBy::class],
                        ],
                    ],
                    FindPageContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerVersion::class],
                        ],
                    ],
                    FindPageContainerVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageContainerVersionsBy::class],
                        ],
                    ],
                    InsertPageContainerVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertPageContainerVersion::class],
                        ],
                    ],
                    /**
                     * Site ===========================================
                     */
                    PublishSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishSiteCmsResource::class],
                        ],
                    ],
                    UnpublishSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishSiteCmsResource::class],
                        ],
                    ],
                    FindSiteCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResource::class],
                        ],
                    ],
                    FindSiteCmsResourceByHost::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResourceByHost::class],
                        ],
                    ],
                    FindSiteCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteCmsResourcesBy::class],
                        ],
                    ],
                    FindSiteVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteVersion::class],
                        ],
                    ],
                    FindSiteVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindSiteVersionsBy::class],
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertSiteVersion::class],
                        ],
                    ],

                    /**
                     * Theme ===========================================
                     */
                    PublishLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => PublishLayoutCmsResource::class],
                        ],
                    ],
                    UnpublishLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UnpublishLayoutCmsResource::class],
                        ],
                    ],
                    GetLayoutRenderData::class => [
                        'class' => GetLayoutRenderDataBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetLayoutRenderDataNoop::class => [],
                    RenderLayout::class => [
                        'class' => RenderLayoutBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    RenderLayoutMustache::class => [],
                    FindLayoutCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutCmsResource::class],
                        ],
                    ],
                    FindLayoutCmsResourceByThemeNameLayoutName::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutCmsResourceByThemeNameLayoutName::class],
                        ],
                    ],
                    FindLayoutCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutCmsResourcesBy::class],
                        ],
                    ],
                    FindLayoutVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutVersion::class],
                        ],
                    ],
                    FindLayoutVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindLayoutVersionsBy::class],
                        ],
                    ],
                    FindThemeComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindThemeComponent::class],
                        ],
                    ],
                    FindThemeComponentsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindThemeComponentsBy::class],
                        ],
                    ],
                    InsertLayoutVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertLayoutVersion::class],
                        ],
                    ],
                    ReadLayoutComponentConfig::class => [
                        'class' => ReadLayoutComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadLayoutComponentConfigJsonFile::class => [
                        'class' => ReadLayoutComponentConfigJsonFile::class,
                    ],

                    ReadThemeComponentConfig::class => [
                        'class' => ReadThemeComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadThemeComponentConfigJsonFile::class => [
                        'class' => ReadThemeComponentConfigJsonFile::class,
                    ],

                    /**
                     * View ===========================================
                     */
                    GetViewRenderTags::class => [
                        'class' => GetViewRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindViewLayoutTagsGetterComponentsBy::class,
                        ],
                    ],
                    GetViewRenderTagsContainers::class => [
                        'arguments' => [
                            '0-' => FindTagNamesByLayout::class,
                            '1-' => FindContainerCmsResourcesBySitePaths::class,
                            '2-' => FindContainerVersion::class,
                            '3-' => GetContainerRenderTags::class
                        ],
                    ],
                    GetViewRenderTagsPage::class => [
                        'arguments' => [
                            '0-' => GetPageContainerRenderTags::class,
                            '1-' => RenderPageContainer::class,
                        ],
                    ],
                    RenderView::class => [
                        'class' => RenderViewBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    RenderViewLayout::class => [
                        'arguments' => [
                            '0-' => RenderLayout::class,
                        ],
                    ],
                    FindTagNamesByLayout::class => [
                        'class' => FindTagNamesByLayoutBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    FindTagNamesByLayoutMustache::class => [],
                    FindViewByRequest::class => [
                        'class' => FindViewByRequestBasic::class,
                        'arguments' => [
                            '0-' => FindSiteCmsResourceByHost::class,
                            '1-' => FindSiteVersion::class,
                            '2-' => FindPageContainerCmsResourceBySitePath::class,
                            '3-' => FindPageContainerVersion::class,
                            '4-' => FindLayoutCmsResourceByThemeNameLayoutName::class,
                            '5-' => FindLayoutVersion::class,
                            '6-' => GetLayoutName::class,
                            '7-' => FindThemeComponent::class,
                            '8-' => GetViewRenderTags::class,
                            '9-' => RenderView::class
                        ],
                    ],
                    GetLayoutName::class => [
                        'class' => GetLayoutNameBasic::class
                    ],

                    /**
                     * ViewLayoutTagsGetter ===========================================
                     */
                    FindViewLayoutTagsGetterComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindViewLayoutTagsGetterComponent::class],
                        ],
                    ],
                    FindViewLayoutTagsGetterComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindViewLayoutTagsGetterComponent::class],
                        ],
                    ],
                    ReadViewLayoutTagsGetterComponentConfigApplicationConfig::class => [
                        'factory' => ReadViewLayoutTagsGetterComponentConfigApplicationConfigFactory::class,
                    ],
                    ReadViewLayoutTagsGetterComponentConfig::class => [
                        'class' => ReadViewLayoutTagsGetterComponentConfigBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadViewLayoutTagsGetterComponentConfigJsonFile::class => [
                        'class' => ReadViewLayoutTagsGetterComponentConfigJsonFile::class,
                    ],
                ],
            ],
            'zrcms' => [
            ],
            /**
             * Service Alias ===========================================
             */
            'zrcms-service-alias' => [
                /**
                 * Block ===========================================
                 */
                ServiceAliasBlock::NAMESPACE_COMPONENT_CONFIG_READER => [
                    ReadBlockComponentConfigBc::SERVICE_ALIAS => ReadBlockComponentConfigBc::class,
                    ReadBlockComponentConfigJsonFile::SERVICE_ALIAS => ReadBlockComponentConfigJsonFile::class,
                ],
                ServiceAliasBlock::NAMESPACE_CONTENT_RENDERER => [
                    'mustache' => RenderBlockMustache::class,
                    RenderBlockBc::SERVICE_ALIAS => RenderBlockBc::class,
                ],
                ServiceAliasBlock::NAMESPACE_CONTENT_DATA_PROVIDER => [
                    'noop' => GetBlockDataNoop::class,
                ],
                /**
                 * Container ===========================================
                 */
                ServiceAliasContainer::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    'blocks' => GetContainerRenderTagsBlocks::class,
                ],
                ServiceAliasContainer::NAMESPACE_CONTENT_RENDERER => [
                    'rows' => RenderContainerRows::class,
                ],

                /**
                 * Page ===========================================
                 */
                ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    'blocks' => GetPageContainerRenderTagsBlocks::class,
                    'html' => GetPageContainerRenderTagsHtml::class,
                ],
                ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDERER => [
                    'rows' => RenderPageContainerRows::class,
                ],

                /**
                 * Theme ===========================================
                 */
                ServiceAliasTheme::NAMESPACE_COMPONENT_CONFIG_READER => [
                    'json' => ReadThemeComponentConfigJsonFile::class,
                ],
                // layout
                ServiceAliasLayout::NAMESPACE_COMPONENT_CONFIG_READER => [
                    'json' => ReadLayoutComponentConfigJsonFile::class,
                ],
                ServiceAliasLayout::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    'noop' => GetLayoutRenderDataNoop::class,
                ],
                ServiceAliasLayout::NAMESPACE_CONTENT_RENDERER => [
                    'mustache' => RenderLayoutMustache::class
                ],
                /**
                 * View ===========================================
                 */
                ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER => [
                    GetViewRenderTagsContainers::SERVICE_ALIAS => GetViewRenderTagsContainers::class,
                    GetViewRenderTagsPage::SERVICE_ALIAS => GetViewRenderTagsPage::class,
                ],
                ServiceAliasView::NAMESPACE_CONTENT_RENDERER => [
                    'layout' => RenderViewLayout::class,
                ],
                ServiceAliasView::NAMESPACE_LAYOUT_TAG_NAME_PARSER => [
                    'mustache' => FindTagNamesByLayoutMustache::class
                ],
                /**
                 * ViewLayoutTagsGetter ===========================================
                 */
                ServiceAliasViewLayoutTagsGetter::NAMESPACE_COMPONENT_CONFIG_READER => [
                    'json' => ReadViewLayoutTagsGetterComponentConfigJsonFile::class,
                ],
                ServiceAliasViewLayoutTagsGetter::NAMESPACE_COMPONENT_VIEW_RENDER_TAGS_GETTER => [
                    // not used just yet, using ServiceAliasView::NAMESPACE_CONTENT_RENDER_TAGS_GETTER
                ],
            ],
        ];
    }
}
