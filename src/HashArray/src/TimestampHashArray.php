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

        $keyTs = $this->findClosest($key, $timestamp);
        $value = $this->storage[$key][$keyTs] ?? null;
        return $value;
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

    function findClosest($key, $target)
    {

        $arr = array_keys($this->storage[$key]);
        $n = count($arr);
        // Corner cases
        if ($target < $arr[0])
            return null;
        if ($target == $arr[0])
            return $arr[0];
        if ($target >= $arr[$n - 1])
            return $arr[$n - 1];

        // Doing binary search
        $i = 0;
        $j = $n;
        $mid = 0;
        while ($i < $j) {
            $mid = ($i + $j) / 2;
            if ($arr[$mid] == $target) {
                return $arr[$mid];
            }

            /* If target is less than array element, then search in left */
            if ($target < $arr[$mid]) {
                // If target is greater than previous
                // to mid, return closest of two
                if ($mid > 0 && $target > $arr[$mid - 1]){
                    return $arr[$mid - 1];
                }
                /* Repeat for left half */
                $j = $mid;
            } // If target is greater than mid
            else {
                if ($mid < $n - 1 &&  $target < $arr[$mid + 1]){
                    return $arr[$mid];
                }
                // update i
                $i = $mid + 1;
            }
        }
        // Only single element left after search
        return $arr[$mid];
    }
}