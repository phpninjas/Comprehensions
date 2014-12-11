<?php


include_once "Options/Option.php";
include_once "Options/Some.php";
include_once "Options/None.php";
//sealed trait Option[+A] {
//  def bind[B](f: A => Option[B]): Option[B]
//}
use Comprehensions\Options\None;
use Comprehensions\Options\Some;

/**
 * @param $value
 * @return Comprehensions\Options\None|Comprehensions\Options\Some
 */
function Option($value)
{
    $res = is_callable($value) ? call_user_func($value) : $value;
    return $res === null ? None() : Some($res);
}

//case class Some[+A](value: A) extends Option[A] {
//  def bind[B](f: A => Option[B]) = f(value)
//}

// => return Option[Type B]

/**
 * @param $value
 * @return Comprehensions\Options\Some
 */
function Some($value)
{
    return new Some($value);
}

//case object None extends Option[Nothing] {
//  def bind[B](f: Nothing => Option[B]) = None
//}

/**
 * @return Comprehensions\Options\None
 */
function None()
{
    return new None();
}