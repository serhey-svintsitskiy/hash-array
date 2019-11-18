<?php


namespace HashArray;


interface TimestampHashArrayInterface
{
    public function set(string $key, $value): int;

    public function get(string $key, int $timestamp);
}