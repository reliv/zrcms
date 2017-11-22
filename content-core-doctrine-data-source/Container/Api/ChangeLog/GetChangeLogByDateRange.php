<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\ChangeLog;

use Zrcms\Content\Model\ActionCmsResource;
use Zrcms\Content\Model\ChangeLogEvent;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\ChangeLog\AbstractGetChangeLogByDateRange;

class GetChangeLogByDateRange extends AbstractGetChangeLogByDateRange
{
    protected $entityManger;

    protected function getResourceHistoryEntityName(): string
    {
        return ContainerCmsResourceHistoryEntity::class;
    }

    protected function getVersionEntityName(): string
    {
        return ContainerVersionEntity::class;
    }

    /**
     * @param ContainerVersionEntity $version
     *
     * @return ChangeLogEvent
     */
    protected function versionRowToChangeLogEvent($version): ChangeLogEvent
    {
        $properties = $version->getProperties();

        $event = new ChangeLogEvent();
        $event->setDateTime($version->getCreatedDateObject());
        $event->setUserId($version->getCreatedByUserId());
        $event->setActionId('create');
        $event->setActionName('created');
        $event->setResourceId($version->getId());
        $event->setResourceTypeName('site-wide container draft version');
        $event->setResourceName('for ' . $properties['path']);
        $event->setMetaData(
            [
                'siteCmsResourceId' => $version->getSiteCmsResourceId(),
            ]
        );

        return $event;
    }

    /**
     * @param ContainerCmsResourceHistoryEntity $historyItem
     *
     * @return ChangeLogEvent
     * @throws \Exception
     */
    protected function resourceHistoryRowToChangeLogEvent($historyItem): ChangeLogEvent
    {
        /** @var ContainerCmsResource $cmsResource */
        $cmsResource = $historyItem->getCmsResource();

        $contentVersionId = $historyItem->getContentVersionId();

        switch ($historyItem->getAction()) {
            case ActionCmsResource::PUBLISH_RESOURCE_NEW_VERSION;
                $actionDescription = 'published draft version #' . $contentVersionId . ' to';
                break;
            case ActionCmsResource::PUBLISH_RESOURCE_SAME_VERSION;
                $actionDescription = 'published draft version #' . $contentVersionId . ' to';
                break;
            case ActionCmsResource::UNPUBLISH_RESOURCE_NEW_VERSION;

                $actionDescription = 'modified an unpublished version of';
                break;
            case ActionCmsResource::UNPUBLISH_RESOURCE_SAME_VERSION;
                $actionDescription = 'depublished draft version #' . $contentVersionId . ' from';
                break;
            default:
                throw new \Exception('Unknown action type found: ' . $historyItem->getAction());
        }

        $event = new ChangeLogEvent();
        $event->setDateTime($historyItem->getCreatedDateObject());
        $event->setUserId($historyItem->getCreatedByUserId());
        $event->setActionId($historyItem->getAction());
        $event->setActionName($actionDescription);
        $event->setResourceId($cmsResource->getId());
        $event->setResourceTypeName('site-wide container');
        $event->setResourceName($cmsResource->getPath());
        $event->setMetaData(
            [
                'siteCmsResourceId' => $cmsResource->getSiteCmsResourceId(),
                'contentVersionId' => $historyItem->getContentVersionId()
            ]
        );

        return $event;
    }
}
