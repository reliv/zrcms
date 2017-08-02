<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Model;

use Zrcms\Content\Model\PropertiesComponent;
use Zrcms\Content\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentConfigFields
{
    const NAME = PropertiesComponent::NAME;
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
        ];
}
