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
 <?php if(isset($_GET['del_id'])){
 			$notes = new Note();
 			$user_id = Note::find_user_id($_GET['del_id'])->user_id;
 			if($_SESSION['id'] == $user_id){
 				if($notes->delete($_GET['del_id'])){
	 				$_SESSION['alert-success'] = "Note was successfully deleted";
	 				redirect("notes.php");
	 				exit();
	 			} else {
	 				$_SESSION['alert-danger'] = "Note was not deleted";
	 				redirect("notes.php");
	 				exit();
	 			}
 			} else {
 				$_SESSION['alert-danger'] = "You are not entitled to this operation";
 				redirect("notes.php");
 				exit();
 			}
 		} 
 ?>
<?php 
	if(isset($_POST['create_note']) && !empty($_POST['note'])){
		$notes = new Note();

		$notes->note = trim($_POST['note']);
		$notes->user_id = trim($_SESSION['id']);

		if($notes->save()){
			$_SESSION['alert-success'] = "Note was successfully created";
		} else {
			$_SESSION['alert-danger'] = "Note was not successfully created";
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
			<form class="container-fluid" method="post">
			 <?php include("../includes/sessions.php"); ?>
				<div class="form-group">
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Note" rows="3" name="note"></textarea>
				</div>
				<button type="submit" class="btn btn-dark" name="create_note">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<div class="header-topic container-fluid">
			<p>NOTES(click to edit or delete)</p>
		</div>
		<?php $notes = Note::find_all(); ?>
		<?php foreach($notes as $the_note): ?>
		<div class="element-group">
			<div class="element">
				<p><?php echo $the_note->note; ?> <br> 
				<span class="time"><?php  
					$d = strtotime($the_note->updated_at);
				echo date('M j, Y | h:ia', $d); ?></span>
				</p>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="edit_note.php?id=<?php echo $the_note->id; ?>">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="notes.php?del_id=<?php echo $the_note->id; ?>" onclick="document.getElementById('editForm').submit();">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>

		</div>
		<?php endforeach ?>
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>

</html>