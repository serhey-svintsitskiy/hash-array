<?php

namespace HashArray;

class TimestampHashArray implements TimestampHashArrayInterface
{

    /**
     * @var array
     */
    protected $storage = [];

    /**
     * @param string $key
     * @param int $timestamp
     * @return mixed|null
     */
    public function get(string $key, int $timestamp)
    {
        if (!isset($this->storage[$key])) {
            throw new \RuntimeException("Could not find key '{$key}' in the HashArray");
        }

        $result = null;
        foreach ($this->storage[$key] as $savedTimestamp => $value) {
            if ($timestamp < $savedTimestamp) {
                break;
            }
            $result = $value;
        }
        return $result;
    }

    /**
     * @param string $key
     * @param $value
     * @return int
     */
    public function set(string $key, $value): int
    {
        $timestamp = time();
        $this->storage[$key][$timestamp] = $value;
        return $timestamp;
    }
}