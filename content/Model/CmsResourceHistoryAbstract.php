<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\CmsResourceInvalid;

/**
 * A history record of the state of
 *
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceHistoryAbstract
{
    use ImmutableTrait;
    use PropertiesTrait;
    use TrackableTrait;

    /**
     * @var null|string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var CmsResource
     */
    protected $cmsResource;

    /**
     * @var ContentVersion
     */
    protected $contentVersion;

    /**
     * @param string|null $id
     * @param string      $action
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason
    ) {
        // Enforce immutability
        if (!$this->isNew()) {
            return;
        }
        $this->new = false;

        $this->id = $id;

        $this->action = $action;

        $this->cmsResource = $cmsResource;

        $this->contentVersion = $cmsResource->getContentVersion();

        $this->setCreatedData(
            $publishedByUserId,
            $publishReason
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return ContentVersion
     */
    public function getContentVersion()
    {
        return $this->contentVersion;
    }

    /**
     * @return CmsResource
     */
    public function getCmsResource()
    {
        return $this->cmsResource;
    }

    /**
     * @param CmsResource $cmsResource
     *
     * @return void
     * @throws CmsResourceInvalid
     */
    protected function assertValidCmsResource($cmsResource)
    {
        if (!$cmsResource instanceof CmsResource) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . CmsResource::class
                . ' got: ' . var_export($cmsResource, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
