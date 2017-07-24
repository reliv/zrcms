<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCoreConfigDataSource\Block\Model\BlockConfigFields;
use Zrcms\ContentCoreConfigDataSource\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockComponent implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent
{
    /**
     * @var GetBlocks
     */
    protected $getBlocks;

    /**
     * @var SearchConfigList
     */
    protected $searchConfigList;

    /**
     * @param GetBlocks       $getBlocks
     * @param SearchConfigList $searchConfigList
     */
    public function __construct(
        GetBlocks $getBlocks,
        SearchConfigList $searchConfigList
    ) {
        $this->getBlocks = $getBlocks;
        $this->searchConfigList = $searchConfigList;
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return Block|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        $result = $this->searchConfigList->__invoke(
            [BlockConfigFields::NAME => $name]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}