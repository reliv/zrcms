<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutVersion;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        Param::assertNotEmpty(
            $properties,
            FieldsLayoutVersion::THEME_NAME
        );

        Param::assertNotEmpty(
            $properties,
            FieldsLayoutVersion::NAME
        );

        Param::assertHas(
            $properties,
            FieldsLayoutVersion::HTML,
            PropertyMissing::buildThrower(
                FieldsLayoutVersion::HTML,
                $properties,
                get_class($this)
            )
        );

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->getProperty(
            FieldsLayoutVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getProperty(
            FieldsLayoutVersion::NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->getProperty(
            FieldsLayoutVersion::HTML,
            ''
        );
    }
}
