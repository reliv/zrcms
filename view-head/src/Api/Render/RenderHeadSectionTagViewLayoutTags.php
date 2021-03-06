<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\View;
use Reliv\ArrayProperties\Property;
use Zrcms\ServiceAlias\Api\AssertNotSelfReference;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagViewLayoutTags implements RenderHeadSectionTag
{
    const SERVICE_ALIAS = 'view-layout-tags-getter';
    const OPTION_VIEW = 'zrcms-view';

    protected $getServiceFromAlias;
    protected $serviceAliasNamespace;
    protected $debug;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $serviceAliasNamespace
     * @param bool                $debug
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        $serviceAliasNamespace = ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER,
        bool $debug = false
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = $serviceAliasNamespace;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $attributes
     * @param array                  $options
     *
     * @return string
     * @throws CanNotRenderHeadSectionTag
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     * @throws \Zrcms\ServiceAlias\Exception\ServiceSelfReferenceException
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $attributes,
        array $options = []
    ): string {
        // view-layout-tags-getter - Render from another tags getter
        if (!array_key_exists('__view-layout-tags-getter', $attributes)) {
            throw new CanNotRenderHeadSectionTag(
                'Does not have required key: (__view-layout-tags-getter)'
            );
        }

        /** @var View $view */
        $view = Property::getRequired(
            $options,
            self::OPTION_VIEW
        );

        $indent = Property::getString(
            $options,
            self::OPTION_INDENT,
            '    '
        );
        $lineBreak = Property::getString(
            $options,
            self::OPTION_LINE_BREAK,
            "\n"
        );

        /** @var GetViewLayoutTags $getViewLayoutTags */
        $getViewLayoutTags = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $attributes['__view-layout-tags-getter'],
            GetViewLayoutTags::class,
            ''
        );

        AssertNotSelfReference::invoke($this, $getViewLayoutTags);

        $viewLayoutTags = $getViewLayoutTags->__invoke(
            $view,
            $request,
            $options
        );

        $contentHtml = '';

        foreach ($viewLayoutTags as $viewLayoutTag => $viewLayoutTagHtml) {
            if ($this->debug) {
                $contentHtml .= $indent
                    . '<!-- RenderHeadSectionTagViewLayoutTags: ' . $viewLayoutTag . ' -->'
                    . $lineBreak;
            }
            $contentHtml .= $indent . $viewLayoutTagHtml . $lineBreak;
        }

        return $contentHtml;
    }
}
