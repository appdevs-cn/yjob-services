<?php


class ClientTask extends Phalcon\CLI\Task {
    
	public function sendAction() {
            $a = json_encode(array('aaa' => '111'));
                $arr = array('body' => $a);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://restful.api.test/skip/zhaokun");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $a);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$r = curl_exec($ch);
		curl_close($ch);
                var_dump($r );exit;
	}
}

$t = new ClientTask();
$t->sendAction();