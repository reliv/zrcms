<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Zrcms\ContentCore\Container\Model\ContainerProperties;
use Zrcms\ContentCore\Theme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerPathsByHtmlMustache implements FindTagNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return array ['{container-path}']
     */
    public function __invoke(Layout $layout, array $options = [])
    {
        // '/\{\{' . ContainerProperties::RENDER_NAMESPACE . '.([^}:]+)\}\}/'
        preg_match_all(
            '/\{\{([^}:]+)\}\}/',
            $layout->getHtml(),
            $matches
        );

        return $matches[1];
    }
}