<?php

namespace Zrcms\CoreApplication\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetTypeValueBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetTypeValueBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $typesConfig = $config['zrcms-component-types'];

        return new GetTypeValueBasic(
            $typesConfig
        );
    }
}
