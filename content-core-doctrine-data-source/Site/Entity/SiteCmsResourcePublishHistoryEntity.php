<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\ContentCore\Site\Model\PropertiesSiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourcePublishHistory;
use Zrcms\ContentCore\Site\Model\SiteCmsResourcePublishHistoryAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_site_resource_publish_history",
 *     indexes={}
 * )
 */
class SiteCmsResourcePublishHistoryEntity
    extends SiteCmsResourcePublishHistoryAbstract
    implements SiteCmsResourcePublishHistory, CmsResourcePublishHistoryEntity
{
    use CmsResourcePublishHistoryEntityTrait;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $contentVersionId = null;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * Date object was first created
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdDate;

    /**
     * User ID of creator
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdReason;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $action;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $host;

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->id = Param::getInt(
            $properties,
            PropertiesSiteCmsResource::ID
        );

        $this->contentVersionId = Param::getInt(
            $properties,
            PropertiesSiteCmsResource::CONTENT_VERSION_ID
        );

        $this->host = Param::getString(
            $properties,
            PropertiesSiteCmsResource::HOST
        );

        $this->action = Param::getString(
            $properties,
            PropertiesCmsResourcePublishHistory::ACTION
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->id;
    }

    /**
     * @return string
     */
    public function getContentVersionId(): string
    {
        return $this->contentVersionId;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
}
