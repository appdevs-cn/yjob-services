<?php

namespace Models;

class Job extends BaseModel
{
    protected $table = 'ys_jobs';

    public function initialize() {

        $this->setSource("ys_jobs");

    }

}