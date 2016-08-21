<?php

namespace Models;

class RemoteCall extends \Phalcon\Mvc\Model {

    public function initialize() {

        $this->setSource("ys_remote_call_info");

    }
}
