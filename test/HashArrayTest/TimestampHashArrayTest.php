<?php

namespace HashArrayTest;

use HashArray\TimestampHashArray;
use PHPUnit\Framework\TestCase;

class TimestampHashArrayTest extends TestCase
{
    public function testCreate(): void
    {
        $hashArray = new TimestampHashArray();
        self::assertInstanceOf(TimestampHashArray::class, $hashArray);
    }

    public function testSimpleUsage(): void
    {
        $hashArray = new TimestampHashArray();
        $t0 = time();
        sleep(1);
        $t1 = $hashArray->set('a', 10);
        sleep(1);
        $t2 = $hashArray->set('a', 20);

        $v0 = $hashArray->get('a', $t0);
        $v1 = $hashArray->get('a', $t1);
        $v2 = $hashArray->get('a', $t2);

        self::assertEquals(null, $v0);
        self::assertEquals(10, $v1);
        self::assertEquals(20, $v2);

    }

    public function testWithGraterClosest(): void
    {
        $hashArray = new TimestampHashArray();
        $expValue1 = 10;
        $expValue2 = 20;
        $expValue3 = 30;
        $label = 'a';

        $t1 = $hashArray->set($label, $expValue1);
        sleep(3);
        $t2 = $hashArray->set($label, $expValue2);
        sleep(5);
        $t3 =  $hashArray->set($label, $expValue3);

        self::assertEquals($expValue1, $hashArray->get($label, $t1));
        self::assertEquals($expValue2, $hashArray->get($label, $t2));
        self::assertEquals($expValue2, $hashArray->get($label, $t3 - 2));

    }
}