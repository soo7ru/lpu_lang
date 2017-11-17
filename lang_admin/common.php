<?php
require_once "../common.php";
//get enrolled user list from database
function get_users($count=false){

	global $g_db;

	if($count)
		$query = "select count(id) from users";
	else
		$query = "select * from users";
	$result = mysqli_query($g_db,$query);
	$rows = array();

	if($result and mysqli_num_rows($result)>0){
		
		for($i=0;$i<mysqli_num_rows($result);$i++)
			$rows[] = mysqli_fetch_assoc($result);
	}

	return $rows;
}
//function to compute mostly taught language
function get_mostly_taught_lang(){
	global $g_db;

	$query = "SELECT lang_teach,COUNT(lang_teach) AS most_taught from users  GROUP BY `lang_teach` ORDER BY `most_taught` DESC LIMIT    1";
	$result = mysqli_query($g_db,$query);

	$count = mysqli_fetch_assoc($result);

	return get_language($count['lang_teach']);
}

//function to compute mostly learnt language
function get_mostly_learnt_lang(){
	global $g_db;

	$query = "SELECT lang_learn,COUNT(lang_learn) AS most_learnt from users  GROUP BY `lang_learn` ORDER BY `most_learnt` DESC LIMIT    1";
	$result = mysqli_query($g_db,$query);

	$count = mysqli_fetch_assoc($result);

	return get_language($count['lang_learn']);
}
//function to compute distince nationalities enrolled
function distinct_nationalities(){
	global $g_db;

	$query = "select count(distinct country_id) as nationalities from users";
	$result = mysqli_query($g_db,$query);

	$count = mysqli_fetch_assoc($result);

	return $count['nationalities'];
}
//function to distinct programs 
function program_counts(){
	global $g_db;

	$users = get_users();

	$counts = array("masters"=>0,"undergrads"=>0,"phd"=>0);
	foreach ($users as $user) {
		if($user['program_id'] == 1) $counts['masters']++;
		if($user['program_id'] == 2) $counts['undergrads']++;
		if($user['program_id'] == 3) $counts['phd']++;
	}

	return $counts;
}
//function to compute student type
function type_counts(){
	global $g_db;

	$users = get_users();

	$counts = [0,0,0,0];
	foreach ($users as $user) {
		if($user['student_type'] == 1) $counts[0]++;
		if($user['student_type'] == 2) $counts[1]++;
		if($user['student_type'] == 3) $counts[2]++;
		if($user['student_type'] == 4) $counts[3]++;
	}

	return $counts;
}
//function to compute languages exchanged
function get_lang_count($lang_id,$teach_or_learn){
	global $g_db;
	$column = $teach_or_learn ? "lang_teach":"lang_learn";

	$query = "select count($column) as count from users where $column='$lang_id'";

	$result = mysqli_query($g_db,$query);

	$count =  mysqli_fetch_assoc($result);

	return $count['count'];
}
//function that outputs data for languages graph
function get_lang_learn_teach(){
	

	$languages = get_languages();
	$ret = array();
	foreach ($languages as $language) {
		$teach = get_lang_count($language['id'],true);
		$learn = get_lang_count($language['id'],false);
		$ret[ ] = array( 
			"y" => $language['language_name'],
			"a" => $teach,
			"b" => $learn
			 
		);



	}

	return $ret;
}
//function that outputs data for sex graph
function get_sex_data(){
	$users = get_users();
	$counts = array("male"=>0,"female"=>0,"other"=>0);
	foreach ($users as $user) {
		if($user['gender'] == "female") $counts['female']++;
		if($user['gender'] == "male") $counts['male']++;
		if($user['gender'] == "other") $counts['other']++;
	}

	return array(
			["label" => "Male", "value"=> $counts['male'] ],
			["label" => "Female", "value"=> $counts['female'] ],
			["label" => "other", "value"=> $counts['other'] ],
		);
}
?>