<?php ob_start(); ?>
<?php require_once("../includes/init.php"); ?>
<?php if(isset($_SESSION['link'])){
			echo $_SESSION['link'];
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
<!DOCTYPE html>
<html>
<head>
	<title>Contact App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<style type="text/css">
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
			/*margin-bottom: 30px;*/
			/*border-bottom: 1px solid black;*/
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
	</style>
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
			<form class="container-fluid">
			  <div class="form-group">
			    <label for="contact_name">Name</label>
			    <input type="email" class="form-control" id="contact_name" aria-describedby="emailHelp" placeholder="Enter name">
			  </div>
			  <div class="form-group">
			    <label for="phonenumber">Phone Number</label>
			    <input type="number" class="form-control" id="phonenumber" placeholder="Phone number">
			  </div>
			  <button type="submit" class="btn btn-dark">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<div class="header-topic container-fluid">
			<p>NUMBERS(click to edit | delete)</p>
		</div>
		<div class="element-group">
			<div class="element">
				<div class="container">
					<div class="row">
						<div class="col contact_name">
							<p>Adegbulugbe Timilehin</p>
						</div>
						<div class="col contact_number">
							<p>08160815635</p>
						</div>
					</div>
				</div>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="javascript:{}" onclick="document.getElementById('editForm').submit();">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="javascript:{}" onclick="document.getElementById('editForm').submit();">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="element-group">
			<div class="element">
				<div class="container">
					<div class="row">
						<div class="col contact_name">
							<p>Adegbulugbe Timilehin</p>
						</div>
						<div class="col contact_number">
							<p>08160815635</p>
						</div>
					</div>
				</div>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="javascript:{}" onclick="document.getElementById('editForm').submit();">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="javascript:{}" onclick="document.getElementById('editForm').submit();">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="element-group">
			<div class="element">
				<div class="container">
					<div class="row">
						<div class="col contact_name">
							<p>Adegbulugbe Timilehin</p>
						</div>
						<div class="col contact_number">
							<p>08160815635</p>
						</div>
					</div>
				</div>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="javascript:{}" onclick="document.getElementById('editForm').submit();">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="javascript:{}" onclick="document.getElementById('editForm').submit();">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/contacts.js"></script>

</html>