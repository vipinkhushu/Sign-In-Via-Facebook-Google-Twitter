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

/******Sets the default access token**************/
$fb->setDefaultAccessToken($_SESSION['token']);

/******Retrieving Users FB Profile With Display Picture**************/
try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
  $responseDp = $fb->get('/me/picture?redirect=false&type=small');
  $userNodeDp = $responseDp->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
?>
<?php
/******Printing Responses Recieved From Facebook Graph API**************/
//echo '<pre>' . print_r( $userNode, 1 ) . '</pre>';
//echo '<pre>' . print_r( $userNodeDp, 1 ) . '</pre>';
//echo 'Welcome ' . $userNode->getName().'<br/>';
//echo '<img src='.$userNodeDp->getProperty('url').'><br/>';
//echo'<a href=logout.php>Logout</a>';
require_once 'sqlfunctions.php';
$Fuid=$userNode->getProperty('id');
$fname=$userNode->getProperty('first_name');
$lname=$userNode->getProperty('last_name');
$gender=$userNode->getProperty('gender');
$email=$userNode->getProperty('email');
$fullname=$userNode->getProperty('name');
$fblink=$userNode->getProperty('link');
$dp=$userNodeDp->getProperty('url');
$referal='facebook';
/******Storing User Data In Databases (SQL)**************/

checkAndAddUser($Fuid,$fname,$lname,$gender,$email,$fullname,$fblink,$dp,$referal);
//echo $_SESSION['user_check'];

/**************Storing Data In Sessions******************/
$_SESSION['Fuid']=$userNode->getProperty('id');
$_SESSION['fname']=$userNode->getProperty('first_name');
$_SESSION['lname']=$userNode->getProperty('last_name');
$_SESSION['gender']=$userNode->getProperty('gender');
$_SESSION['fullname']=$userNode->getProperty('name');
$_SESSION['fblink']=$userNode->getProperty('link');
$_SESSION['dp']=$userNodeDp->getProperty('url');
$_SESSION['referal']='facebook';


/*********Redirecting To User Profile Page************/
header('location: profile.php');
?>

