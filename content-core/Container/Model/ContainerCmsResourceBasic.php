<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContainerCmsResourceBasic extends ContainerCmsResourceAbstract implements ContainerCmsResource
{
    /**
     * @param string|null                     $id
     * @param bool                            $published
     * @param ContainerVersion|ContentVersion $contentVersion
     * @param string                          $createdByUserId
     * @param string                          $createdReason
     * @param string|null                     $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
