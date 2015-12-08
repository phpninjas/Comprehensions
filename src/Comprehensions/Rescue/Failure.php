<?php

namespace Comprehensions\Rescue;

class Failure extends Rescue
{
    /**
     * @var \Exception
     */
    private $e;

    public function __construct(\Exception $e)
    {
        $this->e = $e;
    }
}