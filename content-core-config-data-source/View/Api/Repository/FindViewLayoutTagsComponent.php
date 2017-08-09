<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\Content\Api\GetRegisterComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewLayoutTagsComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent
{
    /**
     * @param GetRegisterComponents $getRegisterComponents
     * @param SearchConfigList    $searchConfigList
     */
    public function __construct(
        GetRegisterComponents $getRegisterComponents,
        SearchConfigList $searchConfigList
    ) {
        parent::__construct(
            $getRegisterComponents,
            $searchConfigList
        );
    }
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ViewLayoutTagsComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        return parent::__invoke(
            $name,
            $options
        );
    }
}