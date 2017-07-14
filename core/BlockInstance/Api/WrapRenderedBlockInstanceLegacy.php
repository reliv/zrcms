<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Model\BlockProperties;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceProperties;

class WrapRenderedBlockInstanceLegacy implements WrapRenderedBlockInstance
{
    protected $findBlock;

    /**
     * @param FindBlock $findBlock
     */
    public function __construct(FindBlock $findBlock)
    {
        $this->findBlock = $findBlock;
    }

    /**
     * @param string        $innerHtml
     * @param BlockInstance $blockInstance
     *
     * @return string
     */
    public function __invoke(string $innerHtml, BlockInstance $blockInstance): string
    {
        $block = $this->findBlock->__invoke(
            $blockInstance->getBlockName()
        );

        $rowNumber = $blockInstance->getRequiredLayoutProperty(
            BlockInstanceProperties::LAYOUT_PROPERTIES_ROW_NUMBER
        );
        $renderOrder = $blockInstance->getRequiredLayoutProperty(
            BlockInstanceProperties::LAYOUT_PROPERTIES_RENDER_ORDER
        );
        $columnClass = $blockInstance->getRequiredLayoutProperty(
            BlockInstanceProperties::LAYOUT_PROPERTIES_COLUMN_CLASS
        );

        $id = $blockInstance->getId();

        $editor = $block->getProperty(BlockProperties::EDITOR, '');

        return "\n"
        . '<div class="rcmPlugin RcmResponsiveImage ' . $columnClass . '" '
        . 'data-rcmpluginname="RcmResponsiveImage" '
        . 'data-rcmplugindefaultclass="rcmPlugin RcmResponsiveImage" '
        . 'data-rcmplugincolumnclass="' . $columnClass . '" '
        . 'data-rcmpluginrownumber="' . $rowNumber . '" '
        . 'data-rcmpluginrenderordernumber="' . $renderOrder . '" '
        . 'data-rcmplugininstanceid="' . $id . '" '
        . 'data-rcmpluginwrapperid="' . $id . '" ' //Deprecated
        . 'data-rcmsitewideplugin="" ' //Deprecated
        . 'data-rcmplugindisplayname="" ' //Deprecated
        . 'data-block-editor="' . $editor . '">'
        . "\n"
        . ' <div class="rcmPluginContainer">'
        . $innerHtml
        . ' </div>'
        . "\n"
        . '</div>'
        . "\n";
    }
}
