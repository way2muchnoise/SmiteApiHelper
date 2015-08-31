# SmiteApiHelper
PHP Class for easy interact with Smite API

## What you need
- PHP 5.4 or greater
- **Smite API devid and authkey (you can get it [here](https://fs12.formsite.com/HiRez/form48/secure_index.html))**

## Usage
```
// create session for storing sessionId and sessionTime
session_start();

// Require SmiteApiHelper, set Devid and Authkey
require_once('classes/Api.php');
$api = new SmiteApiHelper('DEVID', 'AUTHKEY');

// response format JSON or ARRAY
$api->getRes('JSON');

// getGods example
$getGods = $api->getGods();
print_r($getGods);
```
