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
        $expValue1 = 10;
        $expValue2 = 20;
        $label = 'a';
        $t0 = 0;
        $t1 = 1;
        $t2 = 2;

        $hashArray->set($label, $expValue1, $t1);
        $hashArray->set($label, $expValue2, $t2);

        self::assertEquals(null, $hashArray->get($label, $t0));
        self::assertEquals($expValue1, $hashArray->get($label, $t1));
        self::assertEquals($expValue2, $hashArray->get($label, $t2));

    }

    public function testWithGraterClosest(): void
    {
        $hashArray = new TimestampHashArray();
        $expValue1 = 20;
        $expValue2 = 30;
        $label = 'a';
        $t1 = 4;
        $t2 = 9;

        $hashArray->set($label, $expValue1, $t1);
        $hashArray->set($label, $expValue2, $t2);

        self::assertEquals($expValue1, $hashArray->get($label, $t1));
        self::assertEquals($expValue1, $hashArray->get($label, $t2 - 2));
    }
}