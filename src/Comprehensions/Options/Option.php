<?php

namespace Comprehensions\Options;

use Comprehensions\Mappable;
use Comprehensions\Traversable;

abstract class Option // [Type A]
{
    use Mappable;
    use Traversable;

    protected $get;
    protected $isEmpty;

    /**
     * @return mixed
     */
    public function get()
    {
        return is_callable($this->get) ? call_user_func($this->get) : $this->get;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->isEmpty;
    }

    /**
     * @param callable $func
     * @return static
     */
    public function map(callable $func)
    {
        return $this->isEmpty() ? new None() : new Some($func($this->get()));
    }

    /**
     * @param callable $func
     * @return static
     * @throws \InvalidArgumentException
     */
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


    /**
     * @param $func
     * @return mixed
     */
    public function each(callable $func)
    {
        if (!$this->isEmpty()) $func($this->get());
    }

    /**
     * @param callable $func - A function that returns a boolean value when supplied with the value.
     * @return Option
     */
    public function filter(callable $func)
    {
        return $this->isEmpty() ? new None() : new Some($func($this->get()));
    }

    /**
     * The number of elements in the traversable
     * @return int
     */
    public function count()
    {
        return $this->isEmpty() ? 0 : 1;
    }

}