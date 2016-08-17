<?php

namespace Controllers;

class ExampleController extends BaseController {

    public function pingAction() {
        $a = $this->request->getPost('aaa');
        echo "pong";
    }

    public function testAction($id) {
        echo "test (id: $id)";
    }

    public function skipAction($name) {
        echo "auth skipped ($name)";
    }
    
    public function getAction() {
        echo  $this->getCodeByMid('221110410216147026');
        $remote = new \REMOTES\WeixinRemote();
        $remote->getToken();
        
        $returnInfo = array(
            'error_code' => '0',
            'error_msg' => '测试信qq息',
            'data' => array('user_name' => '111', 'pwd' => 'ga1kkh'),
        );
        return $returnInfo;
    }
    
    public function putAction() {
    	echo "pong - put method";
    }
    
    public function deleteAction() {
    	echo "pong - delete method";
    }
    
    private function int10to62($int10) {
        $str62keys = array(
            "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "a", "b", "c", "d", "e", "f", "g", "h", "i", 
            "j", "k", "l", "m", "n", "o", "p", "q", 
            "r", "s", "t", "u", "v", "w", "x", "y", 
            "z","A", "B", "C", "D", "E", "F", "G", "H", 
            "I", "J", "K", "L", "M", "N", "O", "P", 
            "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
        );
        $s62 = '';
        $r = 0;
        while ($int10 != 0) {
            $r = $int10 % 62;
            echo 'key:'.$r.'【s62】:'.$s62."【val】:$str62keys[$r] \r\n";
            $s62 = $str62keys[$r].$s62;
            $int10 = floor($int10 / 62);
        }
        return $s62;
    }
    
    private function getCodeByMid($mid){
        $url = '';

        for ($i = strlen($mid) - 7; $i > -7; $i -=7) {
            $offset1 = $i < 0 ? 0 : $i;
            $offset2 = $i + 7;
            $num = substr($mid, $offset1,$offset2-$offset1); 
            echo $num.'--'."\r\n";
            $num = $this->int10to62($num);
            echo "\r\n";
            $url = $num .$url;
        }
        return $url;
    }

}
