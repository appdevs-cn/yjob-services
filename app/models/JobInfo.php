<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 16/8/21
 * Time: 下午9:19
 */

namespace Models;


class JobInfo extends BaseModel
{
    public function initialize() {

        $this->setSource("ys_jobs_info");

    }

}