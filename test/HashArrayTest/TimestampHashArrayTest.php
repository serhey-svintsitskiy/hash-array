<?php

namespace HashArrayTest;

use HashArray\TimestampHashArray;
use PHPUnit\Framework\TestCase;

class TimestampHashArrayTest extends TestCase
{
    private const LABEL_A = 'a';
    
    private function createObject(): TimestampHashArray
    {
        return new TimestampHashArray();
    }

    public function testSimpleUsage(): void
    {
        $hashArray = $this->createObject();
        $expValue1 = 10;
        $expValue2 = 20;
        $t0 = 0;
        $t1 = 1;
        $t2 = 2;

        $hashArray->set(self::LABEL_A, $expValue1, $t1);
        $hashArray->set(self::LABEL_A, $expValue2, $t2);

        self::assertEquals(null, $hashArray->get(self::LABEL_A, $t0));
        self::assertEquals($expValue1, $hashArray->get(self::LABEL_A, $t1));
        self::assertEquals($expValue2, $hashArray->get(self::LABEL_A, $t2));

    }

    public function testWithGraterClosest(): void
    {
        $hashArray = $this->createObject();
        $expValue1 = 20;
        $expValue2 = 30;
        $t1 = 4;
        $t2 = 9;

        $hashArray->set(self::LABEL_A, $expValue1, $t1);
        $hashArray->set(self::LABEL_A, $expValue2, $t2);

        self::assertEquals($expValue1, $hashArray->get(self::LABEL_A, $t1));
        self::assertEquals($expValue1, $hashArray->get(self::LABEL_A, $t2 - 2));
    }

    public function testWithEmptyStorage(): void
    {
        $hashArray = $this->createObject();
        self::assertEquals(null, $hashArray->get('a', 1));
    }

    public function testWithEarlyTimestamp(): void
    {
        $hashArray = $this->createObject();

        $hashArray->set(self::LABEL_A, 10, 10);

        self::assertEquals(null, $hashArray->get(self::LABEL_A, 1));
    }
}