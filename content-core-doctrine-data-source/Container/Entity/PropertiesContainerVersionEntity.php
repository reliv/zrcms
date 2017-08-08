<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Entity;

use Zrcms\ContentCore\Container\Model\PropertiesContainer;
use Zrcms\ContentCore\Container\Model\PropertiesContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesContainerVersionEntity extends PropertiesContainerVersion
{
    const BLOCK_VERSIONS = PropertiesContainer::BLOCK_VERSIONS;

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::RENDER_TAGS_GETTER => '',
            self::RENDERER => '',
            self::BLOCK_VERSIONS => [],
        ];
}
