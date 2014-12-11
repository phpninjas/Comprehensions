<?php

namespace Comprehensions\Options {

    class Some extends Option
    {
        public function __construct($value)
        {
            $this->get = $value;
            $this->isEmpty = false;
        }
    }
}