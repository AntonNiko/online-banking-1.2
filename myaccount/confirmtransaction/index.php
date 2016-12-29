<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Confirm Transaction</title>

	<!-- Bootstrap CSS -->
	<link href="http://localhost/resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- JQuery -->
	<script src="http://localhost/resources/js/jquery.min.js"></script>
	<script src="http://localhost/resources/js/bootstrap.min.js"></script>
	<!-- Required for Select Option in Transfer Funds -->
	<!--<script src="http://localhost/resources/js/bootstrap-select.min.js"></script>-->
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
	.transferinfo li {
		height:50px;
	}
	</style>
</head>
<body>
<?php
if(isset($_SESSION["loggedIn"]) && isset($_SESSION["ipAddress"])){
	if($_SESSION["loggedIn"][0] && $_SERVER["REMOTE_ADDR"]==$_SESSION["ipAddress"] && $_SESSION["validQuickTransfer"]){
		?>
		<!-- Display Main Content -->
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://localhost">DBC Online Banking</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="http://localhost">Home</a></li>
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


	<div class="container" style="font-size:1.2rem;">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<h2>Confirm your Transaction</h2>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<form class="navbar-form navbar-right" action="http://localhost/resources/php/quicktransferverify.php" method="post">
					<button type="submit" class="btn btn-lg btn-default" name="cancelquicktransfer">Cancel</button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<p>Please verify that the information below is accurate and select "Transfer" to continue.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<?php
				/* Check if Unsucceseful Transfer Attempt */
				if(isset($_SESSION["invalidTransferInfo"])){
					unset($_SESSION["invalidTransferInfo"]);
					?>
					<div class="alert alert-danger" role="alert"><strong>Error - </strong>An error ocurred while processing your transfer. Please try again later or contact our support team.</div>
					<?php
				}
				?>
				<ul class="list-group transferinfo">
					<li class="list-group-item">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<strong>From:</strong>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<?php echo $_SESSION["originAccount"];?>
						</div>
					</li>
					<li class="list-group-item">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<strong>To:</strong>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<?php echo $_SESSION["destinationAccount"];?>
						</div>
					</li>
					<li class="list-group-item">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<strong>Amount:</strong>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							$<?php echo number_format($_SESSION["transferAmount"],2);?>
						</div>
					</li>
					<li class="list-group-item">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<strong>Date of Transfer:</strong>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<?php echo date("M. j, Y");?>
						</div>
					</li>
					<li class="list-group-item">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<strong>Date of Transfer:</strong>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<?php echo "Once";?>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<form action="http://localhost/resources/php/quicktransfer.php" method="post">
					<button type="submit" class="btn btn-lg btn-primary" name="quicktransfer" style="float:right;">Transfer</button>
				</form>
			</div>
		</div>
	</div>
		<?php
	}else{
		// If IP addresses do not match, log out the user
		unset($_SESSION["ipAddress"]);
		if(isset($_SESSION["loggedIn"])){
			unset($_SESSION["loggedIn"]);
			header("Location: http://localhost");
			die();
		}else{
			header("Location: http://localhost");
			die();
		}
	}
}else{
	header("Location: http://localhost");
}
?>
</body>
</html>
