<?php

namespace Zrcms\CoreContainer\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\Json\Json;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderTagsBlocks implements GetContainerRenderTags
{
    /**
     * @var RenderBlock
     */
    protected $renderBlock;

    /**
     * @var GetBlockRenderTags
     */
    protected $getBlockRenderTags;

    /**
     * @var WrapRenderedBlockVersion
     */
    protected $wrapRenderedBlockVersion;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @param RenderBlock              $renderBlock
     * @param GetBlockRenderTags       $getBlockRenderTags
     * @param WrapRenderedBlockVersion $wrapRenderedBlockVersion
     * @param WrapRenderedContainer    $wrapRenderedContainer
     */
    public function __construct(
        RenderBlock $renderBlock,
        GetBlockRenderTags $getBlockRenderTags,
        WrapRenderedBlockVersion $wrapRenderedBlockVersion,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->renderBlock = $renderBlock;
        $this->getBlockRenderTags = $getBlockRenderTags;
        $this->wrapRenderedBlockVersion = $wrapRenderedBlockVersion;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

    /**
     * @param Container|Content      $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $container,
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $renderedData = []; //row -> renderOrder -> renderedBlockHtml

        $blocks = $container->getBlockVersions();

        /** @var Block $block */
        foreach ($blocks as $block) {
            $rowNumber = $block->getRequiredLayoutProperty(
                FieldsBlock::LAYOUT_PROPERTIES_ROW_NUMBER
            );

            $renderOrder = $block->getRequiredLayoutProperty(
                FieldsBlock::LAYOUT_PROPERTIES_RENDER_ORDER
            );

            if (!array_key_exists($rowNumber, $renderedData)) {
                $renderedData[$rowNumber] = [];
            }

            if (array_key_exists($renderOrder, $renderedData[$rowNumber])) {
                $message = 'Block instance has duplicate "renderOrder" in its row.'
                    . ' Container type: ' . get_class($container)
                    . ' Container ID: ' . $container->getId()
                    . ' Block ID: ' . $block->getId()
                    . ' layout properties: ' . Json::encode($block->getLayoutProperties(), 0, 3)
                    . ' duped in: ' . Json::encode($block->getLayoutProperties(), 0, 3);

                throw new \Exception(
                    $message
                );
            }

            $blockRenderTags = $this->getBlockRenderTags->__invoke(
                $block,
                $request
            );

            $blockInnerHtml = $this->renderBlock->__invoke(
                $block,
                $blockRenderTags
            );

            $blockOuterHtml = $this->wrapRenderedBlockVersion->__invoke(
                $blockInnerHtml,
                $block
            );

            $renderedData[$rowNumber][$renderOrder] = $blockOuterHtml;
        }

        // Sort by row number
        ksort($renderedData);

        return $renderedData;
    }
}
