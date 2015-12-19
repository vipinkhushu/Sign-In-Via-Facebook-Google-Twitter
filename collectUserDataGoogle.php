<?php
	session_start();
	/******Improting Facebook API Files**************/
	require_once 'includes/google-api-php-client/apiClient.php';
	require_once 'includes/google-api-php-client/contrib/apiOauth2Service.php';
	require_once 'credentials.php';
	require_once 'sqlFunctions.php';
	/******Google API Connection With My APP**************/
	$client = new apiClient();
	//$client->setApplicationName("TheASP");
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setDeveloperKey($api_key);
	$client->setRedirectUri($redirect_url);
	$client->setApprovalPrompt(false);
	$oauth2 = new apiOauth2Service($client);
	/******Waiting For OAuth Token And Then Authenticating**************/
			if (isset($_GET['code'])) {
				$client->authenticate();
				/******After Authentication Requesting For User Data******/
				$info = $oauth2->userinfo->get();
				//echo '<pre>' . print_r( $info, 1 ) . '</pre>';
			}
	    $email = $info['email'];
		$fullname = $info['name'];
		$fname = $info['given_name'];
		$lname = $info['family_name'];
		$Fuid = $info['id'];
		$fblink = $info['link'];
		if(isset($info['picture'])){
			$dp= $info['picture'];
		}
		else{
			$dp= 'assets/img/default_avatar.jpg';
		}
		/******Storing User Data In Databases (SQL)**************/
			checkAndAddUser($Fuid,$fname,$lname,'na',$email,$fullname,$fblink,$dp,'google');

		/**************Storing Data In Sessions******************/
		$_SESSION['Fuid']=$Fuid;
		$_SESSION['fname']=$fname;
		$_SESSION['lname']=$lname;
		$_SESSION['gender']='na';
		$_SESSION['fullname']=$fullname;
		$_SESSION['fblink']=$fblink;
		$_SESSION['dp']=$dp.'?sz=58';
		$_SESSION['referal']='google';


		/*********Redirecting To User Profile Page************/
		header('location: profile.php');
?>