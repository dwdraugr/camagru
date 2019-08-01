<?php
if ("array" === gettype($data) and $data[0] === Model::WRONG_PASSWORD)
{
	echo <<<SIGNIN
	<div class="zhir"></div>
	<div class="auth">
	<p>Enter new password</p>
	<form name="signin" action="/forgotten/recovery/{$data[1]}" method="post">
		<p><input  type="password" placeholder="New Password" name="new_password" required="required"></p>
		<p><input  type="password" placeholder="Confirm Password" name="confirm_password" required="required"></p>
		<hr>
		<br>
		<p><input type="submit" name="submit" value="Sign In"></p>
	</form>
	</div>
SIGNIN;
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
elseif ($data === Model::SID_NOT_FOUND)
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
elseif ($data === Model::WEAK_PASSWORD)
{
	echo <<<SIGNIN
	<div class="zhir"></div>
	<div class="auth">
	<p>Enter new password</p>
	<form name="signin" action="/forgotten/recovery/{$data[1]}" method="post">
		<p><input  type="password" placeholder="New Password" name="new_password" required="required"></p>
		<p><input  type="password" placeholder="Confirm Password" name="confirm_password" required="required"></p>
		<hr>
		<br>
		<p><input type="submit" name="submit" value="Sign In"></p>
		<p style='color: darkred; font-style: italic'>Your password is weak. Please, input minimum
																	7 characters with upper case symbol</p>
	</form>
	</div>
SIGNIN;
}
elseif ($data === Model::SUCCESS)
{
	echo <<<SUC
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
		We send link for you E-Mail. Please, check it
	</p>
	<a  style="text-align: center;" href="/main">
		<p>return to main page</p>
	</a>
SUC;
}
else
echo <<<SIGNIN
	<div class="zhir"></div>
	<div class="auth">
	<p>Please, enter your E-Mail</p>
	<form name="signin" action="/forgotten/check_email" method="post">
		<p><input  type="email" placeholder="E-Mail" name="email" required="required"></p>
		<hr>
		<br>
		<p><input type="submit" name="submit" value="Sign In"></p>
</form>
	</div>
SIGNIN;
