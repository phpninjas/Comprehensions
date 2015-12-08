<?php


namespace Comprehensions\Rescue;

use Comprehensions\Mappable;

abstract class Rescue
{
    use Mappable;

    protected $success;

    protected $get;


    /**
     * @return mixed
     */
    public function get()
    {
        return is_callable($this->get) ? call_user_func($this->get) : $this->get;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this instanceof Success || false;
    }

    /**
     * @return bool
     */
    public function isFailure()
    {
        return !$this->isSuccess();
    }

    /**
     * @param $func
     * @return mixed
     */
    public function each(callable $func)
    {
        if ($this->isSuccess()) $func($this->get());
    }

    /**
     * @param callable $func
     * @return $this
     */
    public function flatMap(callable $func)
    {
        if ($this->isSuccess()) {
            return $func($this->get());
        }
        return $this;
    }

    /**
     * @param callable $func
     * @return $this|Success
     */
    public function map(callable $func)
    {
        if ($this->isSuccess()) {
            $value = $this->get();
            return self::apply(function()use($func, $value){return $func($value);});
        }
        return $this;
    }

    /**
     * @param $v
     * @return mixed
     */
    public function getOrElse($v)
    {
        if ($this->isSuccess()) {
            return $this->get();
        }
        return $v;
    }

    /**
     * @param $func
     * @return Failure|Success
     */
    public static function apply(callable $func)
    {
        try {
            $res = call_user_func($func);
            return new Success($res);
        } catch (\Exception $e) {
            return new Failure($e);
        }
    }

}

