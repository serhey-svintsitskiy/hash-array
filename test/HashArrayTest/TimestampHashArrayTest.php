<?php

namespace HashArrayTest;

use HashArray;

class TimestampHashArrayTest extends \PHPUnit\Framework\TestCase
{

    public function testCreate()
    {
        $hashArray = new HashArray\TimestampHashArray();
        $this->assertInstanceOf(HashArray\TimestampHashArray::class, $hashArray);
    }

    public function testSimpleUsage()
    {
        $hashArray = new HashArray\TimestampHashArray();
        $t0 = time();
        sleep(1);
        $t1 = $hashArray->set('a', 10);
        sleep(1);
        $t2 = $hashArray->set('a', 20);

        $v0 = $hashArray->get('a', $t0);
        $v1 = $hashArray->get('a', $t1);
        $v2 = $hashArray->get('a', $t2);

        $this->assertEquals(null, $v0);
        $this->assertEquals(10, $v1);
        $this->assertEquals(20, $v2);

    }
}