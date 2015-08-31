<?php

class SmiteApiHelper {

	protected $devid;
	protected $authkey;
	protected $sessionId;
	protected $res;

	// getSession and check if it longs > 15 min, if true get new Session after refresh
	public function __construct($id, $key) {
		$this->devid = $id;
		$this->authkey = $key;
		if(empty($_SESSION['sessionId'])) {
			$timestamp = gmdate('YmdHis');
			$signature = $this->getSignature('createsession', $timestamp);
			$url = 'http://api.smitegame.com/smiteapi.svc/createsessionJson/' . $this->devid . '/' . $signature . '/' . $timestamp;
			$json = json_decode(file_get_contents($url), true);
			$this->sessionId = $json['session_id'];
			$_SESSION['sessionId'] = $this->sessionId;
			$_SESSION['sessionTime'] = time();
		} else {
			if((time() - $_SESSION['sessionTime']) > 900) {
				unset($_SESSION['sessionId']);
				unset($_SESSION['sessionTime']);
			} else {
				$this->sessionId = $_SESSION['sessionId'];
			}
		}
	}

	public function getSignature($method, $timestamp) {
		$domd5 = $this->devid.$method.$this->authkey.$timestamp;
		return md5($domd5);
	}

	public function getRes($res) {
		if($res == 'JSON') {
			$this->res = 'JSON';
		} elseif($res = 'ARRAY') {
			$this->res = 'ARRAY';
		} else {
			$this->res = 'ARRAY';
		}
	}

	public function getDataUsed() {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getdataused', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getdatausedJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp;
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return json_encode(file_get_contents($url), true);
		}
	}

	public function getItems() {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getitems', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getitemsJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/1';
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return json_encode(file_get_contents($url), true);
		}
	}

	public function getFriends($player) {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getfriends', $timestamp);
		$playerid = $this->getPlayerId($player);
		$url = 'http://api.smitegame.com/smiteapi.svc/getfriendsJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . $playerid;
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return json_encode(file_get_contents($url), true);
		}
	}

	public function getPlayer($player) {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getplayer', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getplayerJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . urlencode($player);
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return json_encode(file_get_contents($url), true);
		}
	}

	public function getPlayerId($player) {
		$json = $this->getPlayer($player);
		return $json[0]['Id'];
	}

	public function getGodranks($player) {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getgodranks', $timestamp);
		$playerid = $this->getPlayerId($player);
		$url = 'http://api.smitegame.com/smiteapi.svc/getgodranksJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . $playerid;
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return file_get_contents($url, true);
		}
	}

	public function getMatchHistory($player) {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getmatchhistory', $timestamp);
		$playerid = $this->getPlayerId($player);
		$url = 'http://api.smitegame.com/smiteapi.svc/getmatchhistoryJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . $playerid;
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return file_get_contents($url, true);
		}
	}

	public function getMatchDetails($matchId) {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getmatchdetails', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getmatchdetailsJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . $matchId;
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return file_get_contents($url, true);
		}
	}

	public function getLastMatch($player) {
		$history = $this->getMatchHistory($player);
		$match = $this->getMatchDetails($history[0]['Match']);
		return $match;
	}

	public function getGods() {
		$timestamp = gmdate('YmdHis');
		$signature = $this->getSignature('getgods', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getgodsJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/1';
		if($this->res == 'ARRAY') {
			return json_decode(file_get_contents($url), true);
		} elseif($this->res == 'JSON') {
			return file_get_contents($url, true);
		}
	}

}
