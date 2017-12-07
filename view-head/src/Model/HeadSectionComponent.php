<?php

namespace Zrcms\ViewHead\Model;

use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HeadSectionComponent extends ViewLayoutTagsComponentAbstract implements ViewLayoutTagsComponent
{
    /**
     * @param string $type
     * @param string $name
     * @param string $configLocation
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
     */
    public function __construct(
        string $type,
        string $name,
        string $configLocation,
        string $moduleDirectory,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        Param::assertHas(
            $properties,
            PropertiesHeadSectionComponent::TAG
        );

        $properties[PropertiesHeadSectionComponent::SECTIONS] = Param::getArray(
            $properties,
            PropertiesHeadSectionComponent::SECTIONS,
            []
        );

        parent::__construct(
            $type,
            $name,
            $configLocation,
            $moduleDirectory,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->getProperty(
            PropertiesHeadSectionComponent::TAG
        );
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->getProperty(
            PropertiesHeadSectionComponent::SECTIONS,
            []
        );
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return array|null
     */
    public function getSection(string $name, $default = null)
    {
        $sections = $this->getSections();

        return Param::getArray(
            $sections,
            $name,
            []
        );
    }
}
