<?php

namespace Zrcms\CoreTheme\Fields;

use Zrcms\Core\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsThemeComponent extends FieldsComponent
{
    const PRIMARY_LAYOUT_NAME = 'primaryLayoutName';
    const LAYOUT_VARIATIONS = 'layoutVariations';

    const DEFAULT_PRIMARY_LAYOUT_NAME = 'primary';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::PRIMARY_LAYOUT_NAME,
                'type' => 'text',
                'label' => 'Primary Layout Name',
                'required' => true,
                'default' => self::DEFAULT_PRIMARY_LAYOUT_NAME,
                'options' => [],
            ],
            [
                'name' => self::LAYOUT_VARIATIONS,
                'type' => 'array',
                'label' => 'Layout Variation Locations',
                'required' => true,
                'default' => [],
                'options' => [],
            ],
        ];
}
