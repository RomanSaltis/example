<?php

namespace App\Console\Commands;

class TestStatic {
    public int $prop = 3;
    public function __construct()
    {
        $this->prop = 5;
    }

    public function dynamic(): int
    {
        print $this->prop;
        return $this->prop;
    }

    public function static(): int
    {
        print $this->prop;
        return $this->prop;
    }

    public static function make(){
      return new static();
    }
}
