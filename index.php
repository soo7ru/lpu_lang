<?php

require_once 'common.php'; //contains the functions

//determine which page to goto based on the GET "p" parameter
if(!empty($_GET['p'])){
	$g_page = $_GET['p'];
}
else{
	$g_page = "home";
}
//if logout is received as a GET or POST action, perform logout
if(!empty($_REQUEST['action']) and $_REQUEST['action']=="logout"){ 
	logout();
}
//attempt login
if(!empty($_POST['submit']) and $_POST['submit'] == "Login"){
	$result = attempt_login($_POST['email'],$_POST['password']); 
	if(!$result) 
		$feedback = "<div class='text-center alert alert-danger'>Invalid Username and/or Password</div>";
	else
		$g_page = "home";
}



?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Language Center</title>
		<link rel="stylesheet" href="css/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div class="container">
			<?php
			/*
			if user is not logged in show login and signup page. Else goto the requested page or show page not found if
			the requested page doesnt exist.

			*/
			if(!is_logged_in()){
				$g_page = "login";
			}
			if (is_logged_in() and $g_page=="login") {
				$g_page="home";
			}
			if(!empty($g_page) and file_exists("page_$g_page.php"))
				require_once "page_$g_page.php";
			else
				require_once "page_404.php";
			?>
		</div>

		<!-- jQuery -->
		<script src="js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>