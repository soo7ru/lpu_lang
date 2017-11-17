<?php
	$languages = get_languages(); //getting language list
	/*
	3 different tasks:
	Save => save language Preferences
	Save Bio => Save the Bio
	accept => Accept a connection request
	*/
	if(!empty($_POST['submit']) ){
		if($_POST['submit']=="Save"){
			$result = save_lang_preferences($_POST['lang_learn'],$_POST['lang_teach']);
			if($result){
				$feedback = "<p class='alert alert-success'>Preferences Saved</p>";
			}
			else{
				$feedback = "<p class='alert alert-danger'>Failed to Save Preferences</p>";
			}
		}
		if($_POST['submit']=="Save Bio"){
			save_bio($_POST['bio']);
		}
	}

	if(!empty($_REQUEST['action']) and $_REQUEST['action']=="accept"){
		update_connection($_REQUEST['from'],'connected');
	}
	

?>
<div class="page-header">
  <h1>LPU Language Center<small><a href="index.php?p=login&action=logout" class="btn btn-sm btn-danger pull-right">Logout</a></small></h1>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Language Preferences</h3>
			</div>
			<div class="panel-body">
				<!-- If there is some feedback from actions, show it -->
				<?php
				if(!empty($feedback)) echo $feedback;
				?>
				<form method="post" action="index.php?p=home">
					<!-- Display lang settings -->
					<strong>I Can Teach:</strong>
					<select class="form-control" name="lang_learn">
						<option value="">N/A</option>
						<?php

							foreach ($languages as $lang) {
								if($lang['id']==$_SESSION['user']['lang_learn']) 
									$selected = "selected";
								else
									$selected="";
								echo "<option $selected value='". $lang['id']. "'>". $lang['language_name']. "</option>";
							}
						?>
						
					</select>
					<br>
					<strong>I Want To Learn:</strong>
					<select class="form-control" name="lang_teach">
						<option value="">N/A</option>
						<?php
							foreach ($languages as $lang) {
								if($lang['id']==$_SESSION['user']['lang_teach']) 
									$selected = "selected";
								else
									$selected = "";

								echo "<option $selected value='". $lang['id']. "'>". $lang['language_name']. "</option>";
							}
						?>
					</select>
					<br>
					<input type="submit" name="submit" value="Save" class="btn btn-primary btn-block">

				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
	<!-- Matching profiles panel -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Matching Profiles</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-responsive">
					<thead>
						<th>Name</th>
						
						<th>Can Teach</th>
						<th>Wants to Learn</th>
						<th>Signed Up</th>
						<th>Actions</th>
					</thead>
				<?php
					$matches = get_matches(); //get the matches and display in table
					foreach ($matches as $profile) {
						echo "<tr>";
						echo "<td>".$profile['name']."</td>";
						echo "<td>".get_language($profile['lang_learn'])."</td>";
						echo "<td>".get_language($profile['lang_teach'])."</td>";
						echo "<td>".$profile['created_at']."</td>";
						
						echo "<td><a role='button' href='index.php?p=view_details&pid=".$profile['id']."' class='btn btn-sm btn-primary'>View</a></td>";
						echo "</tr>";
					}
				?>
					
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">About Me</h3>
			</div>
			<div class="panel-body">
				<form method="post" action="index.php?p=home">
					<div class="form-group">
						<label>A Short description about yourself (min 10 characters)</label>
						<textarea rows="5" cols="40" name="bio" class="form-control"><?php echo trim($_SESSION['user']['bio']); ?></textarea>
					</div>
					<input type="submit" name="submit" class="btn btn-success btn-block"  value="Save Bio" />
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Connection Requests</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-responsive data-table">
					<thead>
						<th>Name</th>
						<th>E-Mail</th>
						<th>Can Teach</th>
						<th>Wants to Learn</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							$conn_req = get_connection_requests(); //get connection requests and display in table
							foreach ($conn_req as $req) {
								$u = get_user($req['adding_user']);

								echo "<tr>";
								echo "<td>".$u['name']."</td>";
								echo "<td>".$u['email']."</td>";
								echo "<td>".get_language($u['lang_learn'])."</td>";
								echo "<td>".get_language($u['lang_teach'])."</td>";
								echo "<td><a role='button' href='index.php?p=home&action=accept&from=".$u['id']."' class='btn btn-sm btn-primary'>Accept</a></td>";
								echo "</tr>";
							}

						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>