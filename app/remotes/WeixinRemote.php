<?php
namespace REMOTES;

class WeixinRemote extends \REMOTES\BaseRemote {
    
    
    public function getToken() {
        $this->send(array('11'), __FUNCTION__);
    }
    
}
