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

        $t0 = time();
        sleep(1);
        $t1 = $hashArray->set($label, $expValue1);
        sleep(1);
        $t2 = $hashArray->set($label, $expValue2);

        self::assertEquals(null, $hashArray->get($label, $t0));
        self::assertEquals($expValue1, $hashArray->get($label, $t1));
        self::assertEquals($expValue2, $hashArray->get($label, $t2));

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