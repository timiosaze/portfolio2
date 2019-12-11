<?php ob_start(); ?>
<?php include ("../includes/init.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Adegbulugbe Timilehin | Portfolio</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<style type="text/css">
		.auth {
			width: 100%;
			max-width: 320px;
			min-width: 300px;
			border: 1px solid black;
			border-radius: 5px;
			margin: 100px auto;
		}
		.auth label {
			font-size: 2em;
			font-weight: 700;
		}
		.auth #submit {
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<?php 
		$user = new User();
		if(isset($_POST['submit'])){
			$username = trim($_POST['username']);
			$usermail = trim($_POST['user_mail']);
			$password = trim($_POST['password']);
			$c_password = trim($_POST['c_password']);

			// SERVER SIDE VALIDATION
			$error = [
				'username'=> '',
				'usermail'=> '',
				'password'=> '',
				'c_password'=> ''
			];

			if(strlen($username)<1){
				$error['username'] = 'username needs to be longer';
			}
			if($usermail == ''){
				$error['user_mail'] = 'user email is empty';
			}
			if(strlen($password)<8 || strlen($c_password)<8){
				$error['password'] = 'password length too small';
			}
			if($password !== $c_password){
				$error['c_password'] = 'password not matching';
			}
			if(User::username_exists($username)){
				$error['username'] = 'username already taken';
			}
			if(User::usermail_exists($usermail)){
				$error['usermail'] = 'email already used';
			}
			foreach($error as $key => $value){
				if(empty($value)){
					unset($error[$key]);
				}
			}

			if(empty($error)){
				$user->username = $username;
				$user->usermail = $usermail;
				$user->password = $user->password_encrypt($password);

				$user->save();
				$user->login_user($username, $password);

			}

		}

	 ?>
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
		<section class="auth">
			  <div class="container">
			<form method="POST" role="form" id="register_form" action="register.php" enctype="multipart/form-data">

			  <label>Register</label>	
			  <div class="form-group">
			    <input type="text" class="form-control" id="name" name="username" placeholder="Enter name">
			    <?php echo isset($error['username']) ? "<div class='text-danger'><small>" . $error['username'] . "</div>" : ''; ?>
			  </div>
			  <div class="form-group">
			    <input type="email" class="form-control" id="email" name="user_mail" placeholder="Enter email">
			    <?php echo isset($error['usermail']) ? "<div class='text-danger'><small>" . $error['usermail'] . "</div>" : ''; ?>
			  </div>
			  <div class="form-group">
			    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" placeholder="Password">
			    <?php echo isset($error['password']) ? "<div class='text-danger'><small>" . $error['password'] . "</div>" : ''; ?>
			  </div>
			   <div class="form-group">
			    <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password">
			    <?php echo isset($error['c_password']) ? "<div class='text-danger'><small>" . $error['c_password'] . "</div>" : ''; ?>
			  </div>
			  <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Submit">

			</form>
			</div>

		</section>
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>
<script type="text/javascript" src="../scripts/auth.js"></script>

</html>