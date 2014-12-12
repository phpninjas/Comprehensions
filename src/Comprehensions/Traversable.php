<?php

namespace Comprehensions;

trait Traversable {

    /**
     * @param $func
     * @return mixed
     */
    abstract public function each(callable $func);

    /**
     * @return boolean
     */
    abstract public function isEmpty();

    /**
     * @param callable $func - A function that returns a boolean value when supplied with the value.
     * @return mixed
     */
    abstract public function filter(callable $func);

    /**
     * The number of elements in the traversable
     * @return int
     */
    abstract public function count();

    /**
     * @param callable $func
     * @return bool
     */
    public function exists(callable $func){
        $or = false;
        $this->each(function($v)use($func, &$or){
            $or = $or||$func($v);
        });
        return $or;
    }

    /**
     * @param callable $func
     * @return null
     */
    public function fold(callable $func, $initial = null){
        $accumulator = $initial;
        $this->each(function($v)use($func, &$accumulator){
           $accumulator = call_user_func($func, $v, $accumulator);
        });
        return $accumulator;
    }

}
