<!DOCTYPE html>
<?php 
	session_start();
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Account Summary</title>

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
	.accountsummary {
		height:125px;
		background-color:#f2f2f2;
		border-color:#cccccc;
		border-width: 1px;
        border-style: solid;
	}
	.accountlist {
		padding-left:0px;
		padding-right:20px;
	}
	.list-group-item.active, .list-group-item.active:focus {
		background-color:#dcdcdc;
		border-color:#dcdcdc;
		color:#000000;
	}
	.list-group-item.active:hover{
		background-color:#cccccc;
		border-color:#cccccc;
		color:#000000;
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
			<ul class="nav navbar-nav" style="float:right;">
				<li><a href="http://localhost/services/globalmoneytransfer/">
					<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
					<span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
				Global Money Transfer</a></li>
			</ul>
		</div>
	</nav>
</body>
</html>