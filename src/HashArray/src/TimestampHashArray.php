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
//        $result = null;
//        foreach ($this->storage[$key] as $savedTimestamp => $value) {
//            if ($timestamp < $savedTimestamp) {
//                break;
//            }
//            $result = $value;
//        }
        $result = $this->search($key, $timestamp);

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

    protected function search($key, $timestamp)
    {
        $haystack = array_keys($this->storage[$key]);
        $keyTs = $this->findClosest($haystack, count($haystack), $timestamp);
        $value = $this->storage[$key][$keyTs] ?? null;
        return $value;
    }

    function findClosest(array $arr, int $n, $target)
    {
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
            if ($arr[$mid] == $target)
                return $arr[$mid];
            /* If target is less than array element,
                then search in left */
            if ($target < $arr[$mid]) {

                // If target is greater than previous
                // to mid, return closest of two
                if ($mid > 0 && $target > $arr[$mid - 1])
                    return $this->getClosest($arr[$mid - 1],
                        $arr[$mid], $target);

                /* Repeat for left half */
                $j = $mid;
            } // If target is greater than mid
            else {
                if ($mid < $n - 1 &&
                    $target < $arr[$mid + 1])
                    return $this->getClosest($arr[$mid],
                        $arr[$mid + 1], $target);
                // update i
                $i = $mid + 1;
            }
        }
        // Only single element left after search
        return $arr[$mid];
    }

    /**
     * @param $val1
     * @param $val2
     * @param $target
     * @return mixed
     */
    protected function getClosest($val1, $val2, $target)
    {
        return $target - $val1 >= $val2 - $target ? $val2 : $val1;
    }
}