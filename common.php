<?php
session_start();

//connecting to database
$g_db = mysqli_connect("localhost","root","","ucc_lang") or die("DB connection failed");

//this function attempts to login the user by validating the username and password
function attempt_login($email,$password){
	global $g_db;
	$query = "select * from users where email='$email' and password='$password'";
	$result = mysqli_query($g_db,$query);

	if($result and mysqli_num_rows($result)>0){
		$_SESSION['user'] = mysqli_fetch_assoc($result); //set the session variable is match found
		return true;
	}
	return false;
}
//refresh session user data
function reload_user_data(){
	global $g_db;
	$query = "select * from users where id='".$_SESSION['user']['id']."'";
	$result = mysqli_query($g_db,$query);

	if($result and mysqli_num_rows($result)>0){
		$_SESSION['user'] = mysqli_fetch_assoc($result);
	}
}
//function that checks if user is logged in
function is_logged_in(){
	if(!empty($_SESSION['user']['email'])) 
		return true;

	return false;
}
//clear/destroy the session to logout
function logout(){
	unset($_SESSION['user']);
	session_destroy();
}
//function to sign up the user
function sign_up($data){
	global $g_db;
	//validate incoming data
	$name = $data['name'];
	$email = $data['email'];
	$password = $data['password'];
	$password2 = $data['password2'];
	$created_at = date("Y-m-d H:i:s");

	foreach ($data as $key => $value) {
		if(empty($value)){
			return array("success"=>false,"message"=>"$key is Required");
		}
	}
	
	if($password != $password2){
		return array("success"=>false,"message"=>"Passwords Doesn't match");
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  return array("success"=>false,"message"=>"Invalid Email");
	}
	//prepare data for query
	unset($data['password2']);
	unset($data['submit']);
	$data['created_at'] = $created_at;
	$keys = array_keys($data); //get the database fields to insert
	$keys = implode(",", $keys); // get values

	$values = array_values($data);
	$values = implode("','",$values);
	//construct query
	$query = "insert into users($keys)"; 	
	$query .= "values('$values')";

	$result = mysqli_query($g_db,$query);
	if($result and mysqli_affected_rows($g_db)>0){
		return array("success"=>true,"message"=>"Signed up Successfully. You may login with E-Mail and Password");
	}
	echo $query;
	return array("success"=>false,"message"=>"Failed to Create user. Please check the data entered or use different e-mail");
}
//get the list of languages
function get_languages(){
	global $g_db;
	$query = "select * from languages where 1";
	$result = mysqli_query($g_db,$query);

	$langs = array();

	for($i=0;$i<mysqli_num_rows($result);$i++){
		$langs[] = mysqli_fetch_assoc($result);
	}

	return $langs;
}
//function to set teach and learn language preference
function save_lang_preferences($lang_learn,$lang_teach){
	global $g_db;
	if($lang_learn!=$_SESSION['user']['lang_learn'] or $lang_teach!=$_SESSION['user']['lang_teach'])
	{
		$query = "update users set lang_learn = ";
		if(empty($lang_learn))
			$query.= "NULL";
		else
			$query.= "'$lang_learn'";

		$query .= ",lang_teach=";
		if(empty($lang_teach))
			$query.= "NULL";
		else
			$query.= "'$lang_teach'";

		$query .= " where id='".$_SESSION['user']['id']."'";
		$result = mysqli_query($g_db,$query);

		if($result and mysqli_affected_rows($g_db)>0){
			$_SESSION['user']['lang_learn'] = $lang_learn;
			$_SESSION['user']['lang_teach'] = $lang_teach;
			return true;
		}
		
		return false;
	}
	else{
		return true;
	}
}
/*
retrieve matching language pairs for the current user. Its a match if another user is willing to teach the required language
*/
function get_matches(){
	global $g_db;

	$lang_learn = $_SESSION['user']['lang_learn'];
	$lang_teach = $_SESSION['user']['lang_teach'];

	$query = "select * from users where (lang_learn='$lang_teach' or lang_learn is null) and (lang_teach = '$lang_learn') ";
	
	$result = mysqli_query($g_db,$query);
	$matches = array();
	for($i=0;$i<mysqli_num_rows($result);$i++)
		$matches[] = mysqli_fetch_assoc($result);

	return $matches;
}
//get language name when id is provided
function get_language($id){
	global $g_db;
	if(empty($id)) return null;
	$query = "select * from languages where id='$id'";
	$result = mysqli_query($g_db,$query);
	if($result and mysqli_num_rows($result)>0)
	{
		$lang  = mysqli_fetch_assoc($result);
		return $lang['language_name'];
	}

	return null;
}
//update bio of user
function save_bio($bio){
	global $g_db;
	if(empty($bio) or strlen($bio)<10) return;

	$query = "update users set bio='$bio' where id='".$_SESSION['user']['id']."'";
	$result = mysqli_query($g_db,$query);
	reload_user_data();

}
//get user data given id
function get_user($pid){
	global $g_db;
	$query = "select * from users where id='$pid'";
	$result = mysqli_query($g_db,$query);

	if($result and mysqli_num_rows($result)>0){
		return mysqli_fetch_assoc($result);
	}
	return null;
}
//issue connection request to a user
function connect_to_user ($connection_id){

	global $g_db;
	$user_id = $_SESSION['user']['id'];
	$query = "insert into connections (adding_user,added_user,status) values('$user_id','$connection_id','requested')";
	$result = mysqli_query($g_db,$query);
	if($result and mysqli_affected_rows($g_db)>0) return true;

	return false;

}
//checks if either of the users have issued a connection request and accepted the request
function is_connected($connection_id){
	global $g_db;
	$user_id = $_SESSION['user']['id'];
	$query = "select id from connections where (adding_user='$user_id' and added_user='$connection_id') or (adding_user='$connection_id' and added_user='$user_id') and status='connected'";
	
	$result = mysqli_query($g_db,$query);
	if($result and mysqli_num_rows($result)>0) return true;

	return false;
}
//retrieve all requests received to the user
function get_connection_requests(){
	global $g_db;
	$user_id = $_SESSION['user']['id'];
	$query = "select adding_user from connections where  added_user='$user_id' and status!='connected' and status!='not_connected'";
	
	$result = mysqli_query($g_db,$query);
	$res = array();
	if($result and mysqli_num_rows($result)>0){
		
		for($i=0;$i<mysqli_num_rows($result);$i++){
			$res[] = mysqli_fetch_assoc($result);
		}
	}

	return $res;
}
//get the connection status for $of_user_id for the current user
function get_status($of_user_id){
	global $g_db;
	$user_id = $_SESSION['user']['id'];
	$query = "select status from connections where adding_user='$user_id' and added_user='$of_user_id'";
	
	$result = mysqli_query($g_db,$query);

	if($result and mysqli_num_rows($result)>0){
		$status = mysqli_fetch_assoc($result);

		return $status['status'];
	}

	return 'not_connected';
}
//set connection
function update_connection($from_user_id,$status){
	global $g_db;
	$user_id = $_SESSION['user']['id'];

	$query = "update connections set status='$status' where adding_user='$from_user_id' and added_user='$user_id'";
	$result = mysqli_query($g_db,$query);
}
//retrieve master data (languages, programs etc) for list members
function get_data($table,$id){
	global $g_db;
	$query = "select * from $table where id='$id'";
	$result = mysqli_query($g_db,$query);

	if($result and mysqli_num_rows($result)>0){
		return mysqli_fetch_assoc($result);
	}
	return null;

}
//retrieve master datas (languages, programs etc) for lists
function get_collection($table){
	global $g_db;
	$query = "select * from $table";
	$result = mysqli_query($g_db,$query);
	$rows = array();
	if($result and mysqli_num_rows($result)>0){
		for($i=0;$i<mysqli_num_rows($result);$i++)
			$rows[] = mysqli_fetch_assoc($result);
	}
	return $rows;

}
?>