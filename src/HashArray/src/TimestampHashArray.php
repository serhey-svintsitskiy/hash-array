<?php

namespace HashArray;

use RuntimeException;

class TimestampHashArray implements TimestampHashArrayInterface
{
    protected array $storage = [];

    /**
     * @param string $key
     * @param int $timestamp
     * @return mixed|null
     */
    public function get(string $key, int $timestamp)
    {
        if (!isset($this->storage[$key])) {
            throw new RuntimeException("Could not find key '{$key}' in the HashArray");
        }

        $keyTs = $this->findClosest($timestamp, array_keys($this->storage[$key]));
        return $this->storage[$key][$keyTs] ?? null;
    }

    public function set(string $key, $value, ?int $timestamp = null): int
    {
        $timestamp = $timestamp ?? time();
        $this->storage[$key][$timestamp] = $value;
        return $timestamp;
    }

    private function findClosest(int $needle, array $list): ?int
    {
        if (empty($list) || $needle < $list[0]) {
            return null;
        }
        $diff = static function($el) use ($needle) {
            return $needle - $el >= 0 ? $needle - $el : INF;
        };
        
        $interval = array_map($diff, $list);
        asort($interval);
        $closest = key($interval);
//        $closest = $list[0];
//        foreach ($list as $el) {
//            if ($needle - $el < 0) {
//                break;
//            }
//            $closest = min($closest, $el);
//        }
//        
//        return $closest;
        return $list[$closest];
    }
}