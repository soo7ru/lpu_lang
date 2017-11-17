<?php

if(!empty($_POST['submit']) and $_POST['submit'] == "Signup"){
	
	$result = sign_up($_POST);
	$type = $result['success'] ? "success":"danger";
	$feedback = "<div class='text-center alert alert-$type'>" . $result['message'] . "</div>";

}

?>

<div class="page-header">
	<h3 class="">LPU Language Center 
		<div class="btn-group pull-right" role="group">
			<a class="btn btn-sm btn-success" href="img/online_safety.png">Online Safety</a>
			<a class="btn btn-sm btn-danger" href="lang_admin/index.php">Admin</a>  
		
		</div>
	</h3>


</div>
<div class="alert alert-info text-center">
	<h4><strong>Login or Signup to Continue</strong></h4>
</div>
<?php
		if(!empty($feedback)) echo $feedback;
?>
<div class="row">
	

	<div class="col-md-3">
		<div class="panel panel-primary ">
			<div class="panel-heading">
				<h3 class="panel-title">Signup</h3>
			</div>
			<div class="panel-body">
				<form class="form" method="post" action="index.php?p=login">

					Name : <input type="text" name="name" class="form-control" placeholder="Name" /><br/>
					E-Mail : <input type="text" name="email" class="form-control" placeholder="E-mail" /><br/>
					Password : <input type="password" name="password" class="form-control" placeholder="Password" /><br/>
					Confirm Password : <input type="password" name="password2" class="form-control" placeholder="Confirm Password" /><br/>
					College : <select class="form-control" name="college_id">
						<?php 
							$collection = get_collection("college");
							
							foreach ($collection as $item) {
								$key = $item['id'];
								$value = $item['college'];
								echo "<option value='$key'>$value</option>";
							}
						?>
					</select><br/>
					
					Department : <select class="form-control" name="department_id">
						
						<?php 
							$collection = get_collection("departments");
							
							foreach ($collection as $item) {
								$key = $item['id'];
								$value = $item['department_name'];
								echo "<option value='$key'>$value</option>";
							}
						?>
					</select><br/>
					Program : <select class="form-control" name="program_id">
						<?php 
							$collection = get_collection("program");
							
							foreach ($collection as $item) {
								$key = $item['id'];
								$value = $item['program'];
								echo "<option value='$key'>$value</option>";
							}
						?>
					</select><br/>
					Student Type : <select name="student_type" class="form-control">
						<?php
							$types = get_collection("student_type");

							foreach ($types as $type) {
								$key = $type['id'];
								$value = $type['type'];
								echo "<option value='$key'>$value</option>";
							}

						 ?>
					</select>

					Age : <input type="text" name="age" class="form-control" placeholder="Age" /><br/>
					Gender : <select class="form-control" name="gender">
						<option value="other">Other</option>
						<option value="female">Female</option>
						<option value="male">Male</option>
					</select><br/>
					Nationality : <select class="form-control" name="country_id">
						
						<?php 
							$collection = get_collection("countries");
							
							foreach ($collection as $item) {
								$key = $item['id'];
								$value = $item['country'];
								echo "<option value='$key'>$value</option>";
							}
						?>
					</select><br/>
					<p class="text-warning">By Signing up you automatically agree to the <a href="#">Terms and Conditions</a></p>
					<input type="submit" name="submit" class="btn btn-primary btn-block" value="Signup" />
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6" >
			<img class="img img-thumbnail img-responsive" src="img/loginpagepic.png">

	</div>
	<div class="col-md-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Signin</h3>
			</div>
			<div class="panel-body">
				<form class="form" method="post" action="index.php?p=login">
					<input type="text" name="email" class="form-control" placeholder="E-Mail" /><br>
					<input type="password" name="password" class="form-control" placeholder="Password" /><br>
					<input type="submit" name="submit" class="btn btn-primary btn-block" value="Login" />
				</form>
			</div>
		</div>

		
	</div>
</div>