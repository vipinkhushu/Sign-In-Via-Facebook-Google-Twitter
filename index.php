<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Google And Facebook And Twitter Powered Login System For PHP Websites </title>
        
        <!-- The stylesheets -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" />
        
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    
    <body>

		<h1>Login With Facebook Or Google Or Twitter</h1>
        <div id="main">
			
			
					<?php
					session_start();
					/******Improting Facebook API Files**************/
					require_once 'src/Facebook/autoload.php';
					require_once 'credentials.php';
					/******Facebook API Connection With My APP**************/
					$fb = new Facebook\Facebook([
					'app_id' => $appid,
					'app_secret' => $appsecret,
					'default_graph_version' => 'v2.2',
					]);

					/******Initializing The Login**************/
					$helper = $fb->getRedirectLoginHelper();
					$permissions = ['email', 'user_likes']; // optional
					$loginUrl = $helper->getLoginUrl($incommingurl, $permissions);

					/******Printing The Login URL**************/
					echo'<a href="' . $loginUrl . '" class="facebookLoginButton" title="Login With Facebook">Sign in with Facebook</a>';
					?>

					<?php
					/******Importing Google API Files**************/
					require_once 'includes/google-api-php-client/apiClient.php';
					require_once 'includes/google-api-php-client/contrib/apiOauth2Service.php';
					
					/******Google API Connection With My APP**************/
					$client = new apiClient();
					//$client->setApplicationName("TheASP");
					$client->setClientId($client_id);
					$client->setClientSecret($client_secret);
					$client->setDeveloperKey($api_key);
					$client->setRedirectUri($redirect_url);
					$client->setApprovalPrompt(false);
					$oauth2 = new apiOauth2Service($client);
					?>	
					<!--******Printing The Login URL*************-->
            		<a href="<?php echo $client->createAuthUrl()?>" class="googleLoginButton" title="Login With Google">Sign in with Google</a>

            		<!--******Printing The Login URL*************-->
        			<a href="collectUserDataTwitter.php" class="twitterLoginButton" title="Login With Twitter">Sign in with Twitter</a>
        		
            		</div>
		<p class="note">This Websites Uses The PHP APIS Of <a href="https://developers.facebook.com/docs/reference/php" target="_new">Facebook</a>   And <a href="https://developers.google.com/api-client-library/php/start/get_started" target="_new">Google</a> And <a href="http://wwwtwitteroauth.com" target="_new">Twitter</a> To Create The Login System.</p>

        <footer>
	        <h2><i>Author:</i><a href="http://www.vipinkhushu.com"> Vipin Khushu </a> | RAPL IND.( vipinkhushu[at]hotmail.com )</h2>
            <a class="tzine" href="http://www.github.com/vipinkhushu">Star And Fork This Project <i><b>Github</b></i></a>
        </footer>
        
    </body>
</html>