<?php

class smiteApiHelper {

	var $devid = null;
	var $authkey = null;
	var $sessionId = null;

	//resturns session_id on succes, returns empty string at failure
	function __construct($id, $key) {
		$this->devid = $id;
		$this->authkey = $key;
		$timestamp = date('YmdHis');
		$signature = $this->getSignature('createsession', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/createsessionJson/' . $this->devid . '/' . $signature . '/' . $timestamp;
		$json = json_decode(file_get_contents($url), true);
		$this->sessionId =  $json['session_id'];
	}

	function getSignature($method, $timestamp) {
		$domd5 = $this->devid . $method . $this->authkey. $timestamp;
		return md5($domd5);
	}

	function getDataUsed() {
		$timestamp = date('YmdHis');
		$signature = $this->getSignature('getdataused', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getdatausedJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp;
		return json_decode(file_get_contents($url), true);
	}

	function getItems() {
		$timestamp = date('YmdHis');
		$signature = $this->getSignature('getitems', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getitemsJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/1';
		return json_decode(file_get_contents($url), true);
	}

	function getFriends($player) {
		$timestamp = date('YmdHis');
		$signature = $this->getSignature('getfriends', $timestamp);
		$playerid = $this->getPlayerId($player);
		$url = 'http://api.smitegame.com/smiteapi.svc/getfriendsJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . $playerid;
		return json_decode(file_get_contents($url), true);
	}

	function getPlayer($player) {
		$timestamp = date('YmdHis');
		$signature = $this->getSignature('getplayer', $timestamp);
		$url = 'http://api.smitegame.com/smiteapi.svc/getplayerJson/' . $this->devid . '/' . $signature . '/' . $this->sessionId . '/' . $timestamp . '/' . urlencode($player);
		return json_decode(file_get_contents($url), true);
	}

	function getPlayerId($player) {
		$json = $this->getPlayer($player);
		return $json[0]['Id'];
	}

}