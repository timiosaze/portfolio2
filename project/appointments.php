<?php ob_start(); ?>
<?php require_once("../includes/init.php"); ?>
<?php include("../includes/check_the_link.php"); ?>
<?php include("../includes/check_if_login.php"); ?>
<?php 
	if(isset($_GET['del_id'])){
		$user_id = Meeting::find_user_id($_GET['del_id'])->user_id;
		if($user_id == $_SESSION['id']){
			$meeting = new Meeting();
			if($meeting->delete($_GET['del_id'])){
				$_SESSION['alert-success'] = "Meeting successfully deleted";
				redirect("appointments.php");
				exit();
			} else {
				$_SESSION['alert-danger'] = "Meeting not deleted";
				redirect("appointments.php");
				exit();
			}
		} else {
			$_SESSION['alert-danger'] = "You are not entitled to this operation";
			redirect("appointments.php");
			exit();
		}
	}
?>
<?php 
	if(isset($_POST['create_meeting']) && !empty($_POST['meeting']) && !empty($_POST['meeting_date'])){
		$meetings = new Meeting();
		$meetings->user_id = $_SESSION['id'];
		$meetings->meeting = trim($_POST['meeting']);
		$meetings->meeting_date = trim($_POST['meeting_date']);

		if($meetings->save()){
			$_SESSION['alert-success'] = "Meeting successfully created";
		} else {
			$_SESSION['alert-danger'] = "Meeting was not created";
		}
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
		<div class="header-topic container-fluid">
			<p>New Appointment</p>
		</div>
		<div class="post">
			<form class="container-fluid" method="post">
			 	<?php include("../includes/sessions.php"); ?>
				<div class="form-group">
				    <label for="exampleFormControlTextarea1">Appointment</label>
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Meeting" rows="3" name="meeting"></textarea>
				</div>
				<div class="form-group">
				    <label for="exampleFormControlTextarea1">Appointment Time</label>
				    <input type="text" class="form-control clockpicker" name="meeting_date">
				    <span class="input-group-addon">
				        <span class="glyphicon glyphicon-time"></span>
				    </span>
				</div>
				<button type="submit" class="btn btn-dark" name="create_meeting">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<div class="header-topic container-fluid">
			<p>APPOINTMENTS(click to edit or delete)</p>
		</div>
		<?php 

			$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
			$items_per_page = 5;
			$items_total_count = Meeting::count_all($_SESSION['id']);
			$paginate = new Paginate($page, $items_per_page, $items_total_count);

			$user_id = $_SESSION['id'];
			$sql = "SELECT * FROM meetings ";
			$sql .= " WHERE user_id = $user_id ORDER BY meeting_date ASC LIMIT {$paginate->offset()}, {$items_per_page} ";

			$meetings = Meeting::find_by_query($sql);

		?>
		<?php foreach($meetings as $the_meeting): ?>
		<div class="element-group">
			<div class="element">
				<div class="container">
					<div class="row">
						<div class="col-10 appoint_title">
							<p><?php echo $the_meeting->meeting; ?></p>
						</div>
						<div class="col-2 time_date">
							<div class="col appoint_time">
								<p><?php echo date("g:ia", strtotime($the_meeting->meeting_date)); ?></p>
							</div>
							<div class="col appoint_date">
								<p><?php echo date("M d, Y", strtotime($the_meeting->meeting_date)); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="edit_appoint.php?id=<?php echo $the_meeting->id; ?>">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="appointments.php?del_id=<?php echo $the_meeting->id; ?>">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>

		</div>
		<?php endforeach; ?>
		<ul class="pagina">
			<?php   if($paginate->page_total() > 1){
						if($paginate->has_previous()){
							echo "<li class='float-left'><a href='appointments.php?page={$paginate->previous()}'>Previous</a></li>";
						}
						if($paginate->has_next()){
							echo "<li class='float-right'><a href='appointments.php?page={$paginate->next()}'>Next</a></li>";
						}
					} 
			?>
			
		</ul>
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