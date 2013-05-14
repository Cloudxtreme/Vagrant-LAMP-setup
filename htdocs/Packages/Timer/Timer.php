<?php
namespace Vagrant\Packages\Timer;

class Timer {

    private $time_start;
    private $time_stop;

    public function __construct()
    {

    }

    public function start()
    {
        $this->time_start = $this->microtime_float();
    }

    public function stop()
    {
        $this->time_stop = $this->microtime_float();
    }

    public function showRunningTime($count = 1)
    {
        echo "<br />", ($this->time_stop - $this->time_start)/$count, "<br />";
    }

    private function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }



}