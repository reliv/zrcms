<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Model\BlockComponentConfigFields;

/**
 * @deprecated BC only
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareBlockConfigBc implements PrepareBlockConfig
{
    /**
     * @var GetBlockConfigFields
     */
    protected $getBlockConfigFields;

    /**
     * @var GetBlockConfigFieldsBcSubstitution
     */
    protected $getBlockConfigFieldsBcSubstitution;

    /**
     * @param GetBlockConfigFields               $getBlockConfigFields
     * @param GetBlockConfigFieldsBcSubstitution $getBlockConfigFieldsBcSubstitution
     */
    public function __construct(
        GetBlockConfigFields $getBlockConfigFields,
        GetBlockConfigFieldsBcSubstitution $getBlockConfigFieldsBcSubstitution
    ) {
        $this->getBlockConfigFields = $getBlockConfigFields;
        $this->getBlockConfigFieldsBcSubstitution = $getBlockConfigFieldsBcSubstitution;
    }

    /**
     * @param array $blockConfig
     *
     * @return array
     */
    public function __invoke(array $blockConfig): array
    {
        $blockConfigFields = $this->getBlockConfigFields->__invoke();
        $blockConfigFieldsBcSubstitution = $this->getBlockConfigFieldsBcSubstitution->__invoke();

        $blockConfigBc = [];

        foreach ($blockConfig as $key => $value) {
            if (array_key_exists($key, $blockConfigFieldsBcSubstitution)) {
                $blockConfigBc[$blockConfigFieldsBcSubstitution[$key]] = $value;
            }
        }

        $new = array_merge($blockConfigFields, $blockConfig);

        $new = array_merge($blockConfigBc, $new);

        if (empty($new[BlockComponentConfigFields::DEFAULT_CONFIG])) {
            $new[BlockComponentConfigFields::DEFAULT_CONFIG] = $new[BlockComponentConfigFields::FIELDS];
        }

        return $new;
    }
}