<?php
	

?>
<div class="page-header">
  <h1>Admin Panel</h1>
</div>
<div class="row">
	<div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php $c = get_users(true); echo $c[0]['count(id)']; ?></div>
                        <div>User(s)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo get_mostly_taught_lang()?get_mostly_taught_lang():"-"; ?></div>
                        <div>Mostly Learnt</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo get_mostly_learnt_lang()?get_mostly_learnt_lang():"-"; ?></div>
                        <div>Mostly Taught</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo distinct_nationalities(); ?></div>
                        <div>Different National(s)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php $pcounts = program_counts();  ?>
                        <p>Masters : <?php echo $pcounts['masters']; ?></p>
                        <p>Undergrad : <?php echo $pcounts['undergrads']; ?></p>
                        <p>PhD : <?php echo $pcounts['phd']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php $pcounts = type_counts();  ?>
                        <p>Erasmus : <?php echo $pcounts[0]; ?></p>
                        <p>Visiting : <?php echo $pcounts[1]; ?></p>
                        <p>Non EU : <?php echo $pcounts[2]; ?></p>
                        <p>Others/Irish : <?php echo $pcounts[3]; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
	
	
		
				<table class="table table-striped table-responsive data-table">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>E-Mail</th>
						<th>Password</th>
						<th>Nationality</th>
						<th>Dept</th>
						<th>College</th>
						<th>Program</th>
						<th>Age</th>
						<th>Gender</th>
						<th>Wants to Learn</th>
						<th>Can Teach</th>
					</thead>

					<tbody>
					<?php
						$users = get_users();

						foreach ($users as $user) {
							$country = get_data("countries",$user['country_id']);
							$college = get_data("college",$user['college_id']);
							$dept = get_data("departments",$user['department_id']);
							$pgm = get_data("program",$user['program_id']);
							echo "<tr>";
							echo "<td>". $user['id']."</td>";
							echo "<td>". $user['name']."</td>";
							echo "<td>". $user['email']."</td>";
							echo "<td>". $user['password']."</td>";
							echo "<td>". $country['country']."</td>";
							echo "<td>". $dept['department_name']."</td>";
							echo "<td>". $college['college']."</td>";
							echo "<td>". $pgm['program']."</td>";
							echo "<td>". $user['age']."</td>";
							echo "<td>". $user['gender']."</td>";
							echo "<td>". get_language($user['lang_teach'])."</td>";
							echo "<td>". get_language($user['lang_learn'])."</td>";
							echo "</tr>";
						}
					?>
					</tbody>
				</table>
			
		
	
</div>