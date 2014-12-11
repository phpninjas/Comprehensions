<?php

namespace Comprehensions\Options;

use Comprehensions\Mappable;

abstract class Option // [Type A]
{
    use Mappable;

    protected $get;
    protected $isEmpty;

    public function get()
    {
        return is_callable($this->get) ? call_user_func($this->get) : $this->get;
    }

    public function isEmpty()
    {
        return $this->isEmpty;
    }

    public function map(callable $func)
    {
        return $this->isEmpty ? new None() : new Some($func($this->get()));
    }

    public function flatMap(callable $func)
    {
        if ($this->isEmpty()) {
            return new None();
        } else {
            $res = $func($this->get());
            if ($res instanceof Option) {
                return $res;
            }
            throw new \InvalidArgumentException("Function must return an Option[A]");
        }
    }

    public function getOrElse(callable $func)
    {
        return $this->isEmpty() ? $func() : $this->get();
    }

}