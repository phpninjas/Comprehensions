<?php


use Comprehensions\NoSuchElementException;
use Comprehensions\Options\None;
use Comprehensions\Options\Some;

class OptionTest extends PHPUnit_Framework_TestCase
{

    public function testSome()
    {

        $some = Some(1);

        $this->assertThat($some->get(), $this->equalTo(1));

    }

    public function testOption()
    {

        $unknown1 = Option("string");
        $unknown2 = Option(null);

        $this->assertThat($unknown1, $this->isInstanceOf("Comprehensions\Options\Some"));
        $this->assertThat($unknown2, $this->isInstanceOf("Comprehensions\Options\None"));

    }

    public function testSomeMap()
    {

        $some1 = Some(1);
        $some2 = $some1->map(function ($whatever) {
            return $whatever * 2;
        });

        $this->assertThat($some1, $this->isInstanceOf("Comprehensions\Options\Some"));
        $this->assertThat($some1->get(), $this->equalTo(1));
        $this->assertThat($some2->get(), $this->equalTo(2));
        // check different object, i.e. immutability
        $this->assertThat($some1, $this->logicalNot($this->identicalTo($some2)));

    }

    public function testNoneMap()
    {
        $none1 = None();
        $none2 = $none1->map(function ($whatever) {
            return $whatever * 2;
        });

        $this->assertThat($none2, $this->isInstanceOf("Comprehensions\Options\None"));
        // check different object, i.e. immutability
        $this->assertThat($none1, $this->logicalNot($this->identicalTo($none2)));
        try {
            $none1->get();
        } catch (NoSuchElementException $e) {

        }
        $this->assertThat($e, $this->isInstanceOf("Comprehensions\NoSuchElementException"));
    }

    public function testSomeFlatMap()
    {
        $product = function ($v) {
            return Some($v * 2);
        };
        $noneFunc = function($v){
            return None();
        };

        $none = Option(1);
        $none1 = $none->flatMap($product);
        $none2 = $none->flatMap($noneFunc);

        $this->assertThat($none1, $this->equalTo(new Some(2)));
        $this->assertThat($none2, $this->equalTo(new None()));

    }

    public function testNoneFlatMap()
    {

        $product = function ($v) {
            return Some($v * 2);
        };

        $none = Option(null);
        $none = $none->flatMap($product);

        $this->assertThat($none, $this->equalTo(new None()));

    }

    public function testEach()
    {
        $option1 = Option(1);

        $option1->each(function ($v) use (&$stack) {
            $stack[] = $v;
        });

        $this->assertThat($stack[0], $this->equalTo(1));
    }

    public function testNoneEach()
    {
        $this->setExpectedException("Comprehensions\NoSuchElementException");
        $option2 = Option(null);
        $option2->each(function ($v) use (&$stack) {
            $stack[] = $v;
        });
    }

    public function testSomeFold(){
        $option = Some(1);
        $folded = $option->fold(function($v, $i){
            return $i+$v;
        },1);

        $this->assertThat($folded, $this->equalTo(2));
    }

    public function testNoneFold(){
        $this->setExpectedException("Comprehensions\NoSuchElementException");
        $option = None();
        $option->fold(function($v, $i){
            return $i+$v;
        });

    }

    public function testImplicitFold(){
        $option1 = Some(1);
        $intFolded = $option1->fold(function($v, $i){
            return $i+$v;
        });

        $option2 = Some("some string");
        $stringFolded = $option2->fold(function($v, $i){
            return $i.$v;
        });

        $this->assertThat($intFolded, $this->equalTo(1));
        $this->assertThat($stringFolded, $this->equalTo("some string"));
    }
}