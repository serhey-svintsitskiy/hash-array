<?php


namespace HashArray;


interface TimestampHashArrayInterface
{
    public function set(string $key, $value, ?int $timestamp = null): void;

    public function get(string $key, int $timestamp);
}