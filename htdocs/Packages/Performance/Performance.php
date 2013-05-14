<?php
namespace Vagrant\Packages\Performance;

class Performance {

    private $loop;

    public function __construct($loop = 10)
    {
        if (isset($loop)) {
            $this->loop = $loop;
        }
    }

    public function initiate($code)
    {
        for ($i = 0; $i < $this->loop; $i++) {
            $code;
        }
    }

}