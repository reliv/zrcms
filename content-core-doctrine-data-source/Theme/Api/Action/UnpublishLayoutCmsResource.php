<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishLayoutCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutCmsResourceEntity::class,
            LayoutCmsResourceHistoryEntity::class,
            LayoutVersionEntity::class
        );
    }

    /**
     * @param string $layoutCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $layoutCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $layoutCmsResourceId,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
