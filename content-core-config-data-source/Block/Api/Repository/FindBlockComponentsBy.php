<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentsByAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockComponentsBy
    extends FindComponentsByAbstract
    implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return BlockComponent[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
