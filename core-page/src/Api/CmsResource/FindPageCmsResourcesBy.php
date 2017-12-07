<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CorePage\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageCmsResourcesBy extends FindContainerCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return PageCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}