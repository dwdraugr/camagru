<?php
if ($data === Model::DB_ERROR)
	echo <<<SUC
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	Sorry, we have some problem with database. Please stand by.
	</p>
SUC;
elseif($data === Model::NON_CONFIRMED_ACC)
{
	echo <<<SUC
		<br><br><br><br><br><br>
		<p style="text-align: center; font-size: larger">
		You account isn't confirmed. Please, check your email
		</p>
SUC;
}
else
{
	echo <<<SET
<link type="text/css" rel="stylesheet" href="/css/settings.css">
<div class="settings">
	<h1>SETTINGS</h1>
	<hr>
	<p>Sending  notification to E-Mail</p>
	<form action="/settings/send_email/" method="post">
		<input type="radio" name="send_email" value="Enable" checked="checked"> Enable
		<input type="radio" name="send_email" value="Disable"> Disable <br>
		<input type="submit" name="submit" value="Change Email Settings">
	</form>
	<hr>
	<p>Change nickname</p>
	<form action="/settings/nickname" method="post">
		<input type="text" name="new_nick" placeholder="New Nickname" required="required">
		<input type="submit" name="submit" value="Change Nickname">
	</form>
SET;
	if ($data === Model::USER_EXIST)
		echo "<p style='color: darkred; font-style: italic'>This login is already taken</p>";
	echo <<<SET
	<hr>
	<p>Change E-Mail</p>
	<form action="/settings/change_email" method="post">
		<input type="email" name="new_email" placeholder="New E-Mail" required="required">
		<input type="submit" name="submit" value="Change E-Mail">
	</form>
SET;
	if ($data === Model::EMAIL_EXIST)
		echo "<p style='color: darkred; font-style: italic'>This E-Mail is already taken</p>";
	elseif ($data === Model::BAD_EMAIL)
		echo "<p style='color: darkred; font-style: italic'>E-Mail incorrect. Please, enter valid address</p>";
	echo <<<SET
	<hr>
	<p>Change Password</p>
	<form action="/settings/change_password" method="post">
		<input type="password" name="old_password" placeholder="Current Password" required="required">
		<input type="password" name="new_password" placeholder="New Password" required="required">
		<input type="password" name="confirm_password" placeholder="Confirm Password" required="required">
		<br>
		<input type="submit" name="submit" value="Change Password">
	</form>
SET;
	if ($data === Model::WRONG_PASSWORD)
		echo "<p style='color: darkred; font-style: italic'>Wrong correct old password</p>";
	elseif ($data === Model::WEAK_PASSWORD)
		echo "<p style='color: darkred; font-style: italic'>Your password is weak. Please, input minimum
																	7 characters with upper case symbol</p>";
	elseif ($data === FALSE)
		echo "<p style='color: darkred; font-style: italic'>Please, enter new password twice</p>";
	echo <<<SET
	<hr>
	<p>Change Icon</p>
	<form id="upload_form" enctype="multipart/form-data" action="/settings/icon/" method="post">
		<input type="file" name="image_upload" accept="image/jpeg, image/png, image/gif" required="required">
		<input type="submit" value="Upload Image">
	</form>
SET;
	if ($data === Model::UNUPLOADED_FILE)
		echo "<p style='color: darkred; font-style: italic'>Failed to download file. Please, try again</p>";
	elseif ($data === Model::FORBIDDEN_FILETYPE)
		echo "<p style='color: darkred; font-style: italic'>File isn't correct. Please, try again</p>";
	if ($data === Model::SUCCESS)
		echo "<hr><p style='color: green; font-style: italic'>SUCCESS!</p>";
	echo <<<SET
</div>
SET;
}