<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockConfigFields
{
    /**
     * @var array
     */
    protected $fields
        = [
            BlockConfigFields::NAME => '',
            BlockConfigFields::DIRECTORY => null,
            BlockConfigFields::CATEGORY => null,
            BlockConfigFields::LABEL => null,
            BlockConfigFields::DESCRIPTION => null,
            BlockConfigFields::RENDERER => null,
            BlockConfigFields::DATA_PROVIDER => null,
            BlockConfigFields::ICON => null,
            BlockConfigFields::CACHEABLE => false,
            BlockConfigFields::FIELDS => [],
            BlockConfigFields::DEFAULT_CONFIG => [],
            BlockConfigFields::CREATED_BY_USER_ID => Trackable::UNKNOWN_USER_ID,
            BlockConfigFields::CREATED_REASON => Trackable::UNKNOWN_REASON
        ];

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->fields;
    }
}