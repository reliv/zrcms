<?php

namespace Zrcms\PageAccess;

use Zrcms\CorePage\Fields\FieldsPageVersion;
use Zrcms\PageAccess\Api\GetApplicationStatePageAccess;
use Zrcms\PageAccess\Fields\FieldsPageAccess;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsPageVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsPageAccess::PAGE_ACCESS_OPTIONS,
                        'type' => 'assoc-array',
                        'label' => 'Page Access Options',
                        'required' => false,
                        'default' => null,
                        'options' => [],
                    ],
                ],
            ],

            'zrcms-application-state' => [
                GetApplicationStatePageAccess::APPLICATION_STATE_KEY
                => GetApplicationStatePageAccess::class,
            ],
        ];
    }
}
