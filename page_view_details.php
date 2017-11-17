<?php
if(empty($_GET['pid'])) die("<h1>404 Not found</h1>");


$profile = get_user($_GET['pid']);

if(!empty($_POST['submit']) and $_POST['submit']=="Connect"){
	connect_to_user($profile['id']);
}
if(empty($profile)) die("<h1>404 Not found</h1>");
$connected = get_status($profile['id']);

?>
<div class="page-header">
  <h1>User Profile</h1>
</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $profile['name']; ?></h3>
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				
				<tbody>
					<tr>
						<td>Name</td>
						<td><?php echo $profile['name']; ?></td>
					</tr>
					<!-- Show contach details only if the users are connected-->
					<?php
					if($connected=="connected" or is_connected($profile['id'])){
					?>
						<tr>
						<td>E-Mail</td>
						<td><?php echo $profile['email']; ?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td>Gender</td>
						<td><?php echo $profile['gender']; ?></td>
					</tr>
					<tr>
						<td>Age</td>
						<td><?php echo $profile['age']; ?></td>
					</tr>
					<tr>
						<td>Department</td>
						<td><?php $dept = get_data("departments",$profile['department_id']); echo $dept['department_name']; ?></td>
					</tr>
					<tr>
						<td>Nationality</td>
						<td><?php $c = get_data("countries",$profile['country_id']); echo $c['country']; ?></td>
					</tr>
					<tr>
						<td>Wants to teach</td>
						<td><?php echo get_language($profile['lang_learn']); ?></td>
					</tr>
					<tr>
						<td>wants to learn</td>
						<td><?php echo get_language($profile['lang_teach']); ?></td>
					</tr>

				</tbody>
			</table>

			<?php if(!empty($profile['bio'])) echo "<blockquote>".$profile['bio']."</blockquote>"; ?>
			<!-- If users are not connected, show Connect button, else show status -->
			<form method="post" action="index.php?p=view_details&pid=<?php echo $profile['id']; ?>">
				<?php if($connected=="not_connected" and !is_connected($profile['id'])){ ?>
				<label>Connect with the user to get contact details</label><br>
				<input type="submit" name="submit" class="btn btn-success" value="Connect" />
				<?php } else if (!is_connected($profile['id'])) { ?>
				<label>Connection <?php echo $connected; ?></label><br>
				<?php } elseif (is_connected($profile['id'])) {
					echo "<label>Connected</label><br>";
				} ?>
				<a href="index.php?p=home" role='button' class="btn btn-default">Back</a>
			</form>
			
		</div>
	</div>
	</div>
</div>