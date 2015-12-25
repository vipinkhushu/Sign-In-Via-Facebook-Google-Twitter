<?php
	session_start();
	/******Improting Twitter API Files**************/
	include_once("inc/twitteroauth.php");
	include_once("credentials.php");
	include_once("sqlFunctions.php");

	if(isset($_REQUEST['oauth_token']) && $_SESSION['token']  !== $_REQUEST['oauth_token']) {
		
		/******If token is old, distroy session and redirect **************/
		session_destroy();
		header('Location: index.php');
		
	}elseif(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']) {

		/******Twitter API Connection With My APP**************/
		$connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['token'] , $_SESSION['token_secret']);
		/******Waiting For OAuth Token And Then Authenticating**************/
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		if($connection->http_code == '200')
		{
			/******Redirect user to twitter*************/
			$_SESSION['status'] = 'verified';
			//$_SESSION['request_vars'] = $access_token;

			/******Requesting User Data From Twitter*************/
			$user_info = $connection->get('account/verify_credentials', array('include_email'=>'true')); 
			//echo '<pre>' . print_r( $user_info, 1 ) . '</pre>';
			
			$name = explode(" ",$user_info->name);
			$Fuid=$user_info->id;
			$fname = isset($name[0])?$name[0]:'';
			$lname = isset($name[1])?$name[1]:'';
			$gender='na';
			$email=$user_info->email;
			$fullname=$user_info->name;
			$fblink=$user_info->url;
			$dp=$user_info->profile_image_url;
			$referal='twitter';

			/********Follow On Twitter***********************/
			$connection->post('friendships/create', array('screen_name'=>$screen_name_of_person_to_be_followed,'follow'=>'true')); 

			/******Storing User Data In Databases (SQL)**************/
			checkAndAddUser($Fuid,$fname,$lname,$gender,$email,$fullname,$fblink,$dp,$referal);
			/**************Posting Tweet On Users Account******************/
			$connection->post('statuses/update', array('status' => $messageToPost));
			/**************Storing Data In Sessions******************/
			$_SESSION['Fuid']=$Fuid;
			$_SESSION['fname']=$fname;
			$_SESSION['lname']=$lname;
			$_SESSION['gender']=$gender;
			$_SESSION['fullname']=$fullname;
			$_SESSION['fblink']=$fblink;
			$_SESSION['dp']=$dp;
			$_SESSION['referal']=$referal;
			
			/******Unset no longer needed request tokens**************/
			unset($_SESSION['token']);
			unset($_SESSION['token_secret']);

			/*********Redirecting To User Profile Page************/
			header('location: profile.php');
		}else{
			die("error, try again later!");
		}
			
	}else{

		if(isset($_GET["denied"]))
		{
			header('Location: index.php');
			die();
		}

		//Fresh authentication
		$connection = new TwitterOAuth($consumer_key, $consumer_secret);
		$request_token = $connection->getRequestToken($oauth_callback);
		
		//Received token info from twitter
		$_SESSION['token'] 			= $request_token['oauth_token'];
		$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
		
		//Any value other than 200 is failure, so continue only if http code is 200
		if($connection->http_code == '200')
		{
			//redirect user to twitter
			$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
			header('Location: ' . $twitter_url); 
		}else{
			die("error connecting to twitter! try again later!");
		}
	}
?>