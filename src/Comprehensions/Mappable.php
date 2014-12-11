<?php

namespace Comprehensions;

trait Mappable {

    abstract public function map(callable $func);
    abstract public function flatMap(callable $func);
}