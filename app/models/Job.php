<?php

namespace Models;

class Job extends \Phalcon\Mvc\Model
{
    public function initialize() {

        $this->setSource("ys_jobs");

    }

}