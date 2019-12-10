<?php ob_start(); ?>
<?php require_once("../includes/init.php"); ?>
<?php if(isset($_SESSION['link'])){
	  } elseif(isset($_GET['link'])){
	  		$_SESSION['link'] = $_GET['link'];
	  }else{
	  		redirect("../index.php");
	  }
?>
<?php 
		if(isset($_SESSION['id'])){

		}else{
			redirect("../auth/login.php");
		}
 ?>
<?php 
	if(isset($_GET['id'])){

		$user_id = Note::find_user_id($_GET['id'])->user_id;

		if($user_id == $_SESSION['id']){

		} else {
			$_SESSION['blank_statement'] = "YOU ARE NOT THE OWNER OF THIS NOTE";
		}

	} else {
		redirect("notes.php");
		exit();
	}

	if(isset($_POST['update_note']) && !empty($_POST['note'])){
		$notes = new Note();

		$notes->note = trim($_POST['note']);
		$notes->user_id = $user_id;
		if($notes->update($_GET['id'])){
			$_SESSION['alert-success'] = "Note was successfully created";
			redirect("notes.php");
			exit();
		} else {
			$_SESSION['alert-danger'] = "Note was not successfully created";
			redirect("notes.php");
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Notes App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
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
			<p>Add New Note</p>
		</div>
		<div class="post">
			<?php if(isset($_SESSION['blank_statement'])): ?>
				<?php echo $_SESSION['blank_statement']; 
					  unset($_SESSION['blank_statement']); ?>
				<?php else: ?>
				<?php 
					$notes = Note::find_by_id($_GET['id']);
				 ?>
				<form class="container-fluid" method="post">
					<div class="form-group">
					    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Note" rows="3" name="note"><?php echo $notes->note; ?></textarea>
					</div>
					<button type="submit" class="btn btn-dark" name="update_note">Submit</button>
				</form>
			<?php endif; ?>
		</div> 
	</section>
	
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>

</html>