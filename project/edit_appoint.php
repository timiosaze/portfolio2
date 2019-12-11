<?php ob_start(); ?>
<?php require_once("../includes/init.php"); ?>
<?php include("../includes/check_the_link.php"); ?>
<?php include("../includes/check_if_login.php"); ?>

<?php 
		if(isset($_GET['id'])){
			$user_id = Meeting::find_user_id($_GET['id'])->user_id;
			if($user_id == $_SESSION['id']){
				if(isset($_POST['create_meeting']) && !empty($_POST['meeting']) && !empty($_POST['meeting_date'])){
					$meetings = new Meeting();
					$meetings->user_id = $_SESSION['id'];
					$meetings->meeting = trim($_POST['meeting']);
					$meetings->meeting_date = trim($_POST['meeting_date']);

					if($meetings->update($_GET['id'])){
						$_SESSION['alert-success'] = "Meeting successfully updated";
						redirect("appointments.php");
						exit();
					} else {
						$_SESSION['alert-danger'] = "Meeting was not updated";
						redirect("appointments.php");
						exit();
					}
				}
			} else {
				$_SESSION['blank_statement'] = "YOU ARE NOT THE OWNER OF THIS MEETING";
			}
		} else {
			redirect("appointments.php");
			exit();
		}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Appointments App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	 <div class="container">
	  <a class="navbar-brand" href="../index.php">PORTFOLIO</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav ml-auto">

	  	<?php if(isset($_SESSION['username'])): ?>
	  	  <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <?php echo ucfirst($_SESSION['username']); ?>
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="../auth/logout.php">Logout</a>
	        </div>
	      </li>

	  	<?php else: ?>
		      <li class="nav-item active">
		        <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="register.php">Register</a>
		      </li>
		      <!-- <li class="nav-item">
		        <a class="nav-link" href="#">Pricing</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#">Disabled</a>
		      </li> -->
		<?php endif; ?>
		    </ul>
	  </div>
	  </div>
	</nav>
	<section class="container">
		
	<section class="header">
	<?php if(isset($_SESSION['blank_statement'])): ?>
		<?php echo $_SESSION['blank_statement'];
			  unset($_SESSION['blank_statement']);
		 ?>
	<?php else: ?>
		<div class="header-topic container-fluid">
			<p>New Appointment</p>
		</div>
		<div class="post">
			<form class="container-fluid" method="post">
			 	<?php include("../includes/sessions.php"); ?>
			 	<?php $meetings = Meeting::find_by_id($_GET['id']);  ?>
				<div class="form-group">
				    <label for="exampleFormControlTextarea1">Appointment</label>
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Meeting" rows="3" name="meeting"><?php echo $meetings->meeting; ?></textarea>
				</div>
				<div class="form-group">
				    <label for="exampleFormControlTextarea1">Appointment Time</label>
				    <input type="text" class="form-control clockpicker" name="meeting_date" value="<?php echo $meetings->meeting_date; ?>">
				    <span class="input-group-addon">
				        <span class="glyphicon glyphicon-time"></span>
				    </span>
				</div>
				<button type="submit" class="btn btn-dark" name="create_meeting">Submit</button>
			</form>
		</div> 
	<?php endif; ?>
	</section>
	
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<!-- ClockPicker script -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript" src="../scripts/script.js"></script>
<script type="text/javascript">
$('.clockpicker').flatpickr({
	enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today"
});
</script>
</html>