<?php

/**
 * Created by IntelliJ IDEA.
 * User: james
 * Date: 08/12/2015
 * Time: 08:47
 */
class RescueTest extends PHPUnit_Framework_TestCase
{

    public function testCatchException(){

        $c = Rescue(function(){
            throw new RuntimeException();
        });

        $this->assertThat($c, $this->isInstanceOf("Comprehensions\Rescue\Failure"));
        $this->assertEquals(77,$c->getOrElse(77));

    }

    public function testNoException(){

        $c = Rescue(function(){
            return 5;
        });

        $this->assertThat($c, $this->isInstanceOf("Comprehensions\Rescue\Success"));
        $this->assertThat($c->getOrElse(6), $this->equalTo(5));

    }

    public function testWithMethodReturn(){
        Rescue($this->chuckException());
    }

    public function theNumber7(){
        return function(){return 7;};
    }

    public function chuckException(){
        return function(){throw new RuntimeException("BAM BAM");};
    }

    public function testMap(){

        $c = Rescue($this->theNumber7());
        $c = $c->map(function($v){
            return $v+1;
        });

        $this->assertThat($c->getOrElse(1), $this->equalTo(8));

    }

    public function testFlatMap(){
        $c = Rescue($this->theNumber7());
        $c = $c->flatMap(function($v){
            return Failure(new RuntimeException());
        });

        $this->assertThat($c->getOrElse(1), $this->equalTo(1));
    }
}
