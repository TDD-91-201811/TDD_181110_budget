<?php

use App\Tennis;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: matt
 * Date: 2018/11/10
 * Time: 上午10:42
 */
class TennisTest extends TestCase
{
    public function testLoveAll()
    {
        $tennis = new App\Tennis;
        $result = $tennis->score();
        $this->assertEquals("Love All", $result);
    }

    public function testFifteenLove()
    {
        $tennis = new App\Tennis;
        $result = $tennis->score(Tennis::FIRST);
        $this->assertEquals("Fifteen Love", $result);
    }

    public function testFifteenAll()
    {
        $tennis = new App\Tennis;
        $tennis->score(Tennis::FIRST);
        $result = $tennis->score(Tennis::SECOND);
        $this->assertEquals("Fifteen All", $result);
    }
}
