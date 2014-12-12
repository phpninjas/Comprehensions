<?php

namespace Comprehensions\Options {

    final class Some extends Option
    {
        public function __construct($value)
        {
            $this->get = $value;
            $this->isEmpty = false;
        }
    }
}