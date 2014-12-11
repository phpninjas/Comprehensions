<?php

namespace Comprehensions\Options;

use Comprehensions\NoSuchElementException;

class None extends Option
{
    public function __construct()
    {
        $this->get = function () {
            throw new NoSuchElementException("None.get");
        };
        $this->isEmpty = true;
    }
}