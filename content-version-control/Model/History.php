<?php

namespace Zrcms\ContentVersionControl\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface History
{
    public function getRevisionId(): string;
}
