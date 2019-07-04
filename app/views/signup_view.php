<?php
if ($data === Model::USER_EXIST)
{
	echo <<<SUC
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	An account with this email or login has already been created  
	</p>
SUC;
}
elseif ($data === Model::DB_ERROR)
{
	echo <<<SUC
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	Sorry, we have some problem with database. Please stand by.
	</p>
SUC;
}
elseif ($data === Model::SUCCESS)
{
	echo <<<SUC
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
		You successfully create account! Now, check you email address and confirm account.
	</p>
	<a  style="text-align: center;" href="/main">
		<p>return to main page</p>
	</a>
SUC;
}
else
{
	echo <<<SIGNIN
		<div class="zhir"></div>
		<div class="auth">
			<p>Welcome to amazing Camagru!</p>
			<form name="signin" action="/signup/create" method="post">
				<p><input  type="text" placeholder="Nickname" name="nickname" required="required"></p>
				<p><input  type="email" placeholder="E-mail" name="email" required="required"</p>
				<p><input type="password" placeholder="Password" name="password" required="required"></p>
				<hr>
				<br>
SIGNIN;
			if ($data === Model::INCOMPLETE_DATA)
				echo "<p style='color: darkred; font-style: italic'>Please, enter login, e-mail and password</p>";
			elseif ($data === Model::BAD_EMAIL)
				echo "<p style='color: darkred; font-style: italic'>Please, enter correct e-mail</p>";
			elseif ($data === Model::WEAK_PASSWORD)
				echo "<p style='color: darkred; font-style: italic'>Your password is weak. Please, input minimum
																	7 characters with upper case symbol</p>";
			echo <<<SIGNIN
				<p><input type="submit" name="submit" value="Sign In"></p>
			</form>
		</div>
SIGNIN;
}