<?php

namespace Comprehensions\Rescue;

class Success extends Rescue
{
    public function __construct($v)
    {
        $this->get = $v;
        $this->success = true;
    }
}