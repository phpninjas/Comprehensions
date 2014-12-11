<?php

use Comprehensions\Options\NoSuchElementException;

class OptionTest extends PHPUnit_Framework_TestCase {

    public function testSome(){

        $some = Some(1);

        $this->assertThat($some->get(), $this->equalTo(1));

    }

    public function testOption(){

        $unknown1 = Option("string");
        $unknown2 = Option(null);

        $this->assertThat($unknown1, $this->isInstanceOf("Comprehensions\Options\Some"));
        $this->assertThat($unknown2, $this->isInstanceOf("Comprehensions\Options\None"));

    }

    public function testSomeMap(){

        $some1 = Some(1);
        $some2 = $some1->map(function($whatever){
            return $whatever * 2;
        });

        $this->assertThat($some1, $this->isInstanceOf("Comprehensions\Options\Some"));
        $this->assertThat($some1->get(), $this->equalTo(1));
        $this->assertThat($some2->get(), $this->equalTo(2));
        // check different object, i.e. immutability
        $this->assertThat($some1, $this->logicalNot($this->identicalTo($some2)));

    }

    public function testNoneMap(){
        $none1 = None();
        $none2 = $none1->map(function($whatever){
            return $whatever * 2;
        });

        $this->assertThat($none2, $this->isInstanceOf("Comprehensions\Options\None"));
        // check different object, i.e. immutability
        $this->assertThat($none1, $this->logicalNot($this->identicalTo($none2)));
        try {
            $none1->get();
        }catch (NoSuchElementException $e){

        }
        $this->assertThat($e, $this->isInstanceOf("Comprehensions\Options\NoSuchElementException"));
    }

}