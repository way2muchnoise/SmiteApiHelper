<?php
session_start();

require_once('classes/Api.php');

$api = new SmiteApiHelper('DEVID', 'AUTHKEY');
$api->getRes('JSON');

/* check data used (sessions, limit, requests...) */
//$getDataUsed = $api->getDataUsed();

/* Gods */
$getGods = $api->getGods();

/* Items */
//$getItems = $api->getItems();

/* Player */
//$getPlayer = $api->getPlayer('NAME');
//$getPlayerId = $api->getPlayerId('NAME');
//$getGodRanks = $api->getGodRanks('NAME');
//$getMatchHistory = $api->getMatchHistory('NAME');
//$getLastMatch = $api->getLastMatch('NAME');

//$getFriends = $api->getFriends('NAME');

/* Match */
//$getMatchDetails = $api->getMatchDetails('MATCHID');

?>
<h2>Response of getGods</h2>
<p>You should save into some JSON file like gods.json and then fetch it</p>
<?php 
print_r($getGods); 
?>