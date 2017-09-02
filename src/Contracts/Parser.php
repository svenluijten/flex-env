<?php

namespace Sven\FlexEnv\Contracts;

interface Parser
{
    /**
     * @param mixed $subject
     *
     * @return mixed
     */
    public function parse($subject);
}
