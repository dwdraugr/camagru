<?php
if ($data === Model::DB_ERROR)
	echo <<<SUC
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	Sorry, we have some problem with database. Please stand by.
	</p>
SUC;
else
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
	<hr>
	<p>Change E-Mail</p>
	<form action="/settings/change_email" method="post">
		<input type="email" name="new_email" placeholder="New E-Mail" required="required">
		<input type="submit" name="submit" value="Change E-Mail">
	</form>
	<hr>
	<p>Change Password</p>
	<form action="/settings/change_password" method="post">
		<input type="password" name="old_password" placeholder="Current Password" required="required">
		<input type="password" name="new_password" placeholder="New Password" required="required">
		<input type="password" name="confirm_password" placeholder="Confirm Password" required="required">
		<br>
		<input type="submit" name="submit" value="Change Password">
	</form>
	<hr>
	<p>Change Icon</p>
	<form id="upload_form" enctype="multipart/form-data" action="/settings/icon/" method="post">
		<input type="file" name="image_upload" accept="image/jpeg, image/png, image/gif" required="required">
		<input type="submit" value="Upload Image">
	</form>
</div>
SET;