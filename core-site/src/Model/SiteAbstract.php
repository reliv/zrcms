<?php

namespace Zrcms\CoreSite\Model;

use Zrcms\Core\Exception\PropertyMissing;
use Zrcms\Core\Model\ContentAbstract;
use Zrcms\CoreSite\Fields\FieldsSite;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            FieldsSite::THEME_NAME,
            PropertyMissing::buildThrower(
                FieldsSite::THEME_NAME,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsSite::LOCALE,
            PropertyMissing::buildThrower(
                FieldsSite::LOCALE,
                $properties,
                get_class($this)
            )
        );

        $statusPages = Param::getArray(
            $properties,
            FieldsSite::STATUS_PAGES,
            []
        );

        $this->assertValidStatusPages($statusPages);

        parent::__construct(
            $properties
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->getProperty(
            FieldsSite::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getProperty(
            FieldsSite::LOCALE,
            ''
        );
    }

    /**
     * @param string     $httpStatus
     * @param mixed|null $default
     *
     * @return string|null
     */
    public function findStatusPage(string $httpStatus, $default = null)
    {
        $statusPages = $this->getProperty(
            FieldsSite::STATUS_PAGES,
            []
        );

        return Param::getArray(
            $statusPages,
            $httpStatus,
            $default
        );
    }

    /**
     * @param string|int $status
     * @param null       $default
     *
     * @return string|null
     */
    public function findStatusPagePath($status, $default = null)
    {
        $statusPage = $this->findStatusPage($status, null);

        if (empty($statusPage)) {
            return $default;
        }

        return (string)$statusPage['path'];
    }

    /**
     * @param string|int $status
     * @param string     $default
     *
     * @return string|null
     */
    public function findStatusPageType($status, $default = 'render')
    {
        $statusPage = $this->findStatusPage($status, null);

        if (empty($statusPage)) {
            return $default;
        }

        return (string)$statusPage['type'];
    }

    /**
     * @param array $statusPages
     *
     * @return void
     * @throws \Exception
     */
    protected function assertValidStatusPages(array $statusPages)
    {
        foreach ($statusPages as $statusPage) {
            if (!is_array($statusPage)) {
                throw new \Exception('statusPage must be array: ' . json_encode($statusPage));
            }

            if (!array_key_exists('path', $statusPage)) {
                throw new \Exception('path is required for a status page: ' . json_encode($statusPage));
            }

            if (!array_key_exists('type', $statusPage)) {
                throw new \Exception('type is required for a status page: ' . json_encode($statusPage));
            }
        }
    }
}