<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ComponentToArray
{
    /**
     * @param Component $component
     * @param array     $options
     *
     * @return array
     */
    public function __invoke(
        Component $component,
        array $options = []
    ): array;
}