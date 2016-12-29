<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DBC Online Banking</title>

	<!-- Bootstrap CSS -->
	<link href="http://localhost/resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- JQuery -->
	<script src="http://localhost/resources/js/jquery.min.js"></script>
	<script src="http://localhost/resources/js/bootstrap.min.js"></script>
	<!-- [if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Style for Webpage specific elements. When complete, transfer all common elements in single CSS -->
	<style>
	.navbar-inverse {
		background-color:#bb0c0c;
		border-color:#bb0c0c;
	}
	.navbar-inverse .navbar-nav>li>a {
		color:#ffffff;
	}
	.navbar-inverse .navbar-nav>.active>a {
		background-color:#9c3f3f;
	}
	.navbar-inverse .navbar-brand {
		color:#ffffff;
	}
	.form-control {
		margin:15px 15px 15px 0;
	}
	#loginform {
		background-color:#f1f1f1;
	}
	</style>
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://localhost">DBC Online Banking</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li class="dropdown">
					<a class="dropdwon-toggle" data-toggle="dropdown"
					href="#">Banking<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Bank Accounts</a></li>
						<li><a href="#">Credit Cards</a></li>
					</ul>
				</li>
				<li><a href="#">Mortgages</a></li>
				<li><a href="#">Lending</a></li>
				<li><a href="#">Investments</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height:200px;overflow:hidden;">
				<img src="http://localhost/resources/images/body-row1-bg.jpg" class="img-rounded" alt="body-row1-bg" style="margin: -250px 0 0 -100px;">
			</div>
		</div>
		<div class="row" style="margin-top:20px;">
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="loginform">
				<span class="glyphicon glyphicon-lock" aria-hidden="true" style="font-size:24px;margin-top:15px;display:block-inline;"></span>
				<h4 style="display:inline;margin-left:10px;font-weight:700;">Online Banking</h4>
				<hr style="border-color:#aaaaaa;">
				<form class="navbar-form navbar-left" role="login" action="http://localhost/resources/php/login.php" method="post">
					<div class="form-group">
						<?php
						if(isset($_SESSION["loginFail"])){
							if($_SESSION["loginFail"]){
								unset($_SESSION["loginFail"]);
								?>
								<div class="alert alert-danger" role="alert"><strong>Error - </strong> Invalid Card Number or Password, Try Again</div>
								<?php
							}
						}
						?>
						<p style="font-weight:700;">Card Number</p>
						<input type="text" class="form-control" placeholder="Card Number" name="cardnum">
						<p style="font-weight:700;">Password</p>
						<input type="password" class="form-control" placeholder="Password" name="password">
					</div>
					<div class="visible-lg-block visible-sm-block"></div>
					<button type="submit" class="btn btn-lg btn-danger" name="login">Submit</button>
				</form>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-4" style="overflow:hidden;">
				<h4>Transfer Funds in 1 Click</h4>
				<img src="http://localhost/resources/images/fund-transfers.png" class="img-rounded" alt="fund-transfers" style="margin:10px;">
				<p>With our 24/7 Online Banking service, take advantage of our DirectFund Option to transfer funds fast & easy in Canada. </p>
				<a href="#" class="btn btn-lg btn-default">Learn More</a>
			</div>
	</div>
</body>
</html>
