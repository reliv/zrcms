<?php

namespace Zrcms\Content\Api\Action;

use Zrcms\Content\Model\CmsResource;

/**
 * If ContentVersion does not exist, throw ContentVersionNotExistsException
 * Unpublish (delete) CmsResource if exists
 * Create CmsResource (or recreate) WARNING: foreign keys constraints can not be used
 * Make CmsResourceHistory entry
 * Save CmsResource
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishCmsResource
{
    /**
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     * @param string|null $publishDate
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason,
        string $publishDate = null
    ): CmsResource;
}
