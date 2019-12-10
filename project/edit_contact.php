<?php ob_start(); ?>
<?php require_once("../includes/init.php"); ?>
<?php if(isset($_SESSION['link'])){
	  }elseif(isset($_GET['link'])){
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
 			$user_id = Contact::find_user_id($_GET['id'])->user_id;
 			if($_SESSION['id'] == $user_id){
 				if(isset($_POST['update_contact']) && !empty($_POST['contact_number']) && !empty($_POST['contact_name'])){
		 			$contacts = new Contact();
		 			$contacts->user_id = trim($_SESSION['id']);
		 			$contacts->contact_name = trim($_POST['contact_name']);
		 			$contacts->contact_number = trim($_POST['contact_number']);

		 			if($contacts->update($_GET['id'])){
		 				$_SESSION['alert-success'] = "Contact was successfully created";
		 				redirect("contacts.php");
		 				exit();
		 			} else {
		 				$_SESSION['alert-danger'] = "Contact was not created";
		 				redirect("contacts.php");
		 				exit();
		 			}
		 		} 
 			} else {
 				$_SESSION['blank_statement'] = "YOU ARE NOT THE OWNER OF THIS CONTACT";
 			}
 		} else {
 			redirect("contacts.php");
 			exit();
 		}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<!-- <style type="text/css">
		.header {
			width: 100%;
			max-width: 500px;
			min-width: 300px;
			margin: 30px auto;
			background-color: #fff;
		}
		.header .element {
			width: inherit;
			border-bottom: 1px solid #f1f1f1;
			border-left: 2px solid #3828e0;
			padding: 10px;
		}
		.header .element-group {
			width:inherit;
		}
		.header .element .time {
			font-size: 0.85em;
			color: #3828e0;
			font-weight: 300;
		}
		.header .element:hover {
			background-color: #FDFEF3;
			cursor: pointer;
		}
		.header .element:hover .actions {
			visibility: visible;
		}
		.header .header-topic {
			width: inherit;
			height: 30px;
			background-color: #000;
			
		}
		.header-topic p {
			/*padding: px;*/
			line-height: 30px;
			font-size: 15px;
			color:#fff;
		}
		.header .post {
			padding: 30px 0px;
			background-color: #fff;

		}
		.element-group .actions {
			display: none;
		}
		.editForm, .deleteForm {
			display: inline-block !important;
		}
		.element-group .inside-container {
			height: 40px;
			background-color: rgba(0,0,0,0.4);
			border: 1px solid black;
		}
		.col form {
			text-align: center;
			line-height: 40px;
			font-size: 1.3em;
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 600;
		}
		.contact_name, .contact_number {
			text-align: center;
			line-height: 25px;
			height: 25px;
			font-size: 1.15em;
			font-family: 'Open Sans';
			font-style: normal;
		}
		.contact_name {
			font-weight: 300;
			color:#3828e0;
		}
		.contact_number {
			font-weight: 600;
		}
		.col .edit-form a {
			color: #3828e0;

		}
		.col .delete-form a {
			color: #db2e1f;
		}
	</style> -->
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	 <div class="container">
	  <a class="navbar-brand" href="#">PORTFOLIO</a>
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
			<p>Add New Contact</p>
		</div>
		<div class="post">
			<form class="container-fluid" method="post">
			 <?php if(isset($_SESSION['blank_statement'])): ?>
			 	<?php echo $_SESSION['blank_statement'];
			 		 unset($_SESSION['blank_statement']); ?>
			 <?php else: ?>
				 <?php include("../includes/sessions.php"); ?>
				 <?php $contacts = Contact::find_by_id($_GET['id']); ?>
				  <div class="form-group">
				    <label for="contact_name">Name</label>
				    <input type="text" class="form-control" id="contact_name" name="contact_name" aria-describedby="emailHelp" placeholder="Enter name" value="<?php echo $contacts->contact_name; ?>">
				  </div>
				  <div class="form-group">
				    <label for="phonenumber">Phone Number</label>
				    <input type="number" class="form-control" id="phonenumber" name="contact_number" placeholder="Phone number" value="<?php echo $contacts->contact_number; ?>">
				  </div>
				  <button type="submit" class="btn btn-dark" name="update_contact">Submit</button>
			<?php endif; ?>
			</form>
		</div> 
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/contacts.js"></script>

</html>