<?php

namespace HashArray;

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
        $closestTime = $this->findClosest($timestamp, array_keys($this->storage[$key] ?? []));

        return $this->storage[$key][$closestTime] ?? null;
    }

    public function set(string $key, $value, ?int $timestamp = null): void
    {
        $this->storage[$key][$timestamp ?? time()] = $value;
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

        return $list[$closest] ?? null;
    }
}