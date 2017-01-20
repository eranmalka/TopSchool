<script src="../login.js"></script>
<?php
$title = 'login'; 
require 'header.php';
require 'navigation-bar.php';
?> 

<link rel="stylesheet" href="css/login.css">
<div class="container">
		<div id="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <!--<label for="inputEmail" class="sr-only">Email address</label>-->
        <input type="email" id="inputEmail" class="form-control" name="username" placeholder="Email address" required autofocus>
        <!--<label for="inputPassword" class="sr-only">Password</label>-->
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block">Sign in</button>
			</div>
    </div> <!-- /container -->


<script src="scripts/login.js"></script>
<?php require 'footer.php'; ?> 