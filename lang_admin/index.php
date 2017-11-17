<?php
//Login handled by .htacess
require_once 'common.php';

if(!empty($_GET['p'])){
	$g_page = $_GET['p'];
}
else{
	$g_page = "home";
}

/*if(!empty($_REQUEST['action']) and $_REQUEST['action']=="logout")
	logout();
if(!empty($_POST['submit']) and $_POST['submit'] == "Login"){
	$result = attempt_login($_POST['email'],$_POST['password']);
	if(!$result) 
		$feedback = "<div class='text-center alert alert-danger'>Invalid Username and/or Password</div>";
	else
		$g_page = "home";
}
*/


?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Language Center</title>
		<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>
		<style type="text/css">
			.huge{
				font-size: xx-large;
			}
		</style>
		<!-- jQuery -->
		<script src="../js/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
		<script src="../js/raphael/raphael.min.js"></script>
		<script src="../js/morrisjs/morris.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.data-table').DataTable();
			});
		</script>
	</head>
	<body>

	<div class="navbar">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php?p=home">Admin Panel</a>
			<ul class="nav navbar-nav">
				<li>
					<a href="index.php?p=home">Home</a>
				</li>
				<li>
					<a href="index.php?p=stats">Statistics</a>
				</li>
				
			</ul>
		</div>
	</div>

		<div class="container">
			<?php
			/*if(!is_logged_in()){
				$g_page = "login";
			}
			if (is_logged_in() and $g_page=="login") {
				$g_page="home";
			}*/
			if(!empty($g_page) and file_exists("page_$g_page.php"))
				require_once "page_$g_page.php";
			else
				require_once "page_404.php";
			?>
		</div>


	</body>
</html>