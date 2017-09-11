<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTags;
use Zrcms\ContentCore\Container\Api\Render\RenderContainer;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCore\View\Api\GetTagNamesByLayout;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsContainers implements GetViewLayoutTags
{
    const RENDER_TAG_CONTAINER = 'container';
    const SERVICE_ALIAS = 'containers';

    /**
     * @var GetTagNamesByLayout
     */
    protected $getTagNamesByLayout;

    /**
     * @var FindContainerCmsResourcesBySitePaths
     */
    protected $findContainerCmsResourcesBySitePaths;

    /**
     * @var GetContainerRenderTags
     */
    protected $getContainerRenderTags;

    /**
     * @var RenderContainer
     */
    protected $renderContainer;

    /**
     * @param GetTagNamesByLayout                  $getTagNamesByLayout
     * @param FindContainerCmsResourcesBySitePaths $findContainerCmsResourcesBySitePaths
     * @param GetContainerRenderTags               $getContainerRenderTags
     * @param RenderContainer                      $renderContainer
     */
    public function __construct(
        GetTagNamesByLayout $getTagNamesByLayout,
        FindContainerCmsResourcesBySitePaths $findContainerCmsResourcesBySitePaths,
        GetContainerRenderTags $getContainerRenderTags,
        RenderContainer $renderContainer
    ) {
        $this->getTagNamesByLayout = $getTagNamesByLayout;
        $this->findContainerCmsResourcesBySitePaths = $findContainerCmsResourcesBySitePaths;
        $this->getContainerRenderTags = $getContainerRenderTags;
        $this->renderContainer = $renderContainer;
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $siteCmsResource = $view->getSiteCmsResource();

        $layout = $view->getLayoutCmsResource()->getContentVersion();

        $layoutTags = $this->getTagNamesByLayout->__invoke(
            $layout
        );

        $containerPaths = $this->findContainerPaths(
            $layoutTags
        );

        $containerCmsResources = $this->findContainerCmsResourcesBySitePaths->__invoke(
            $siteCmsResource->getId(),
            $containerPaths
        );

        $renderTags = [];

        /** @var ContainerCmsResource $containerCmsResource */
        foreach ($containerCmsResources as $containerCmsResource) {

            /** @var Container $container */
            $container = $containerCmsResource->getContentVersion();

            $containerRenderTags = $this->getContainerRenderTags->__invoke(
                $container,
                $request
            );

            $renderTags[$containerCmsResource->getPath()] = $this->renderContainer->__invoke(
                $container,
                $containerRenderTags
            );
        }

        return [
            self::RENDER_TAG_CONTAINER => $renderTags
        ];
    }

    /**
     * @param array $layoutTags
     *
     * @return array
     */
    protected function findContainerPaths(
        array $layoutTags
    ) {
        $paths = [];
        foreach ($layoutTags as $layoutTag) {
            $path = $this->getPath($layoutTag);
            if ($path !== null) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

    /**
     * @todo NOTE: this will only work with tags like container.{path}
     * @todo Not with container.something.{path}
     *
     * @param string $layoutTag
     *
     * @return bool
     */
    protected function getPath(string $layoutTag)
    {
        $hasTag = (0 === strpos($layoutTag, self::RENDER_TAG_CONTAINER));

        if (!$hasTag) {
            return null;
        }

        $parts = explode('.', $layoutTag);

        if (count($parts) !== 2) {
            // @todo error??
            return null;
        }

        return $parts[1];
    }
}
