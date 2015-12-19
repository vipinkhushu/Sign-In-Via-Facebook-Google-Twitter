<?php

session_start();
/******Improting Facebook API Files**************/
require_once 'src/Facebook/autoload.php';
require_once 'credentials.php';
$fb = new Facebook\Facebook([
  'app_id' => $appid,
  'app_secret' => $appsecret,
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

/******Getting Token From Facebook**************/
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

/******Storing Token In Sessions For Further Use**************/
if (isset($accessToken)) {
  $_SESSION['token'] = (string) $accessToken;
  echo $_SESSION['token'];
  header('location: collectUserData.php');
}
else{
  //echo "err";
  header('location: index.php');
}
?>