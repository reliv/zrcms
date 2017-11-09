<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;
use Zrcms\ContentRedirect\Fields\FieldsRedirectCmsResource;
use Zrcms\ContentRedirect\Fields\FieldsRedirectVersion;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResourceBySiteRequestPath
    implements \Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceBySiteRequestPath
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @var string
     */
    protected $entityClassContentVersion;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @var array
     */
    protected $cmsResourceSyncToProperties = [];

    /**
     * @var array
     */
    protected $contentVersionSyncToProperties = [];

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = RedirectCmsResourceEntity::class;
        $this->classCmsResourceBasic = RedirectCmsResourceBasic::class;

        $this->entityClassContentVersion = RedirectVersionEntity::class;
        $this->classContentVersionBasic = RedirectVersionBasic::class;

        $this->cmsResourceSyncToProperties = [];
        $this->contentVersionSyncToProperties = [];
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $requestPath
     * @param bool   $published
     * @param array  $options
     *
     * @return RedirectCmsResource|CmsResource|null
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $requestPath,
        bool $published = true,
        array $options = []
    ) {
        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource FROM {$this->entityClassCmsResource} resource"
            . " WHERE (resource.siteCmsResourceId = :siteCmsResource"
            // NOTE: siteCmsResource is a string, so empty is equivalent to NULL
            . " OR resource.siteCmsResourceId = '')"
            . " AND resource.requestPath = :requestPath"
            . " AND resource.published = :published"
            . " ORDER BY resource.siteCmsResourceId ASC";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('siteCmsResource', $siteCmsResourceId);
        $dQuery->setParameter('requestPath', $requestPath);
        $dQuery->setParameter('published', $published);
        $dQuery->setMaxResults(1);

        $result = $dQuery->getResult();

        if (empty($result)) {
            return null;
        }

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $result[0],
            $this->contentVersionSyncToProperties
        );
    }
}
