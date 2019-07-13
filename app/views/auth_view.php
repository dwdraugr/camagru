<?php
if ($data === Model::SID_NOT_FOUND)
{
	echo <<<SUC
    <br><br><br><br><br><br>
    <p style="text-align: center; font-size: larger">
        Sorry, but you confirmed link is incorrect. Please, try again
    </p>
    <a  style="text-align: center;" href="/main">
        <p>return to main page</p>
    </a>
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
else
{
		echo <<<SIGNIN
	<div class="zhir"></div>
	<div class="auth">
		<p>Sign in to amazing Camagru</p>
		<form name="signin" action="/auth/signin" method="post">
			<p><input  type="text" placeholder="Nickname" name="nickname" required="required"></p>
			<p><input type="password" placeholder="Password" name="password" required="required"></p>
			<hr>
			<br>
			<p><input type="submit" name="submit" value="Sign In"></p>
SIGNIN;
		if ($data === Model::INCORRECT_NICK_PASS)
			echo "<p style='color: darkred; font-style: italic'>Incorrect login or password</p>";
		echo <<<SIGNIN
			<p><a href="/forgotten">Forgotten password?</a></p>
		</form>
	</div>
SIGNIN;
}