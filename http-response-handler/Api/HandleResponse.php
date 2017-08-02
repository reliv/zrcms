<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HandleResponse
{
    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface;
}
