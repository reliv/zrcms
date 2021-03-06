<?php

namespace Zrcms;

use Zend\ConfigAggregator\ConfigAggregator;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModulesConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        $zrcmsModules = [
            new \Zrcms\BlockHtml\ModuleConfigZrcms(),
            new \Zrcms\CoreAdminTools\ModuleConfigZrcms(),
            new \Zrcms\CoreApplicationState\ModuleConfigZrcms(),
            new \Zrcms\CoreApplication\ModuleConfigZrcms(),
            new \Zrcms\CoreBlock\ModuleConfigZrcms(),
            new \Zrcms\CoreContainer\ModuleConfigZrcms(),
            new \Zrcms\CoreCountry\ModuleConfigZrcms(),
            new \Zrcms\CoreLanguage\ModuleConfigZrcms(),
            new \Zrcms\CorePage\ModuleConfigZrcms(),
            new \Zrcms\CoreRedirect\ModuleConfigZrcms(),
            new \Zrcms\CoreResourceSearchFields\ModuleConfigZrcms(),
            new \Zrcms\CoreSite\ModuleConfigZrcms(),
            new \Zrcms\CoreTheme\ModuleConfigZrcms(),
            new \Zrcms\CoreView\ModuleConfigZrcms(),
            new \Zrcms\HttpApi\ModuleConfigZrcms(),
            new \Zrcms\HttpApi\ModuleConfigSwagger(),
            new \Zrcms\HttpApiSiteContainer\ModuleConfigZrcms(),
            new \Zrcms\HttpApiPage\ModuleConfigZrcms(),
            new \Zrcms\HttpApiRedirect\ModuleConfigZrcms(),
            new \Zrcms\HttpApiSite\ModuleConfigZrcms(),
            new \Zrcms\HttpApiTheme\ModuleConfigZrcms(),
            new \Zrcms\HttpApplicationState\ModuleConfigZrcms(),
            // @todo ViewHead included by default?
            new \Zrcms\HttpAssetsViewHead\ModuleConfigZrcms(),
            new \Zrcms\HttpAssetsAdminTools\ModuleConfigZrcms(),
            new \Zrcms\HttpStatusPages\ModuleConfigZrcms(),
            new \Zrcms\HttpViewRender\ModuleConfigZrcms(),
            new \Zrcms\PageAccess\ModuleConfigZrcms(),
            new \Zrcms\ServiceAlias\ModuleConfigZrcms(),
            new \Zrcms\ThemeDefault\ModuleConfigZrcms(),
            new \Zrcms\ViewHead\ModuleConfigZrcms(),
            // @todo XampleComponent should NOT be included by default
            new \Zrcms\XampleComponent\ModuleConfigZrcms(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
