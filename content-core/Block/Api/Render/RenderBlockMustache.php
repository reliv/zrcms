<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Phly\Mustache\Mustache;
use Phly\Mustache\Resolver\DefaultResolver;
use Phly\Mustache\Resolver\ResolverInterface;
use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Exception\BlockComponentMissing;
use Zrcms\ContentCore\Block\Fields\FieldsBlockComponent;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockMustache implements RenderBlock
{
    const SERVICE_ALIAS = 'mustache';
    
    protected $findComponent;
    protected $resolver;

    /**
     * @param FindComponent     $findComponent
     * @param ResolverInterface $resolver
     */
    public function __construct(
        FindComponent $findComponent,
        ResolverInterface $resolver
    ) {
        $this->findComponent = $findComponent;
        $this->resolver = $resolver;
    }

    /**
     * @param Block|Content $block
     * @param array         $renderTags ['render-tag' => '{html}']
     * @param array         $options
     *
     * @return string
     * @throws BlockComponentMissing
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findComponent->__invoke(
            'block',
            $block->getBlockComponentName()
        );

        if (empty($blockComponent)) {
            throw new BlockComponentMissing(
                "BlockComponent not found: (" . $block->getBlockComponentName() . ")"
            );
        }

        $templateFile = $this->getTemplateFile($blockComponent);

        $mustache = new Mustache();
        $mustache->getResolver()->attach($this->resolver);

        return $mustache->render($templateFile, $renderTags);
    }

    /**
     * @param BlockComponent $blockComponent
     *
     * @return false|string
     * @throws \Exception
     */
    protected function getTemplateFile(BlockComponent $blockComponent)
    {
        $moduleDirectory = $blockComponent->getModuleDirectory();
        $templateFile = $blockComponent->getProperty(FieldsBlockComponent::TEMPLATE_FILE);

        // @todo @BC if we have no template directory, we assume it is next in the module directory
        if (empty($templateFile)) {
            $templateFile = $moduleDirectory . '/template.mustache';
        } else {
            $templateFile = $moduleDirectory . $templateFile;
        }

        $templateFileReal = realpath($templateFile);

        if ($templateFileReal === false) {
            throw new \Exception(
                'Block template directory not found'
                . ' for block: (' . $blockComponent->getName() . ')'
                . ' directory: (' . $templateFile . ')'
            );
        }

        return $templateFile;
    }
}
