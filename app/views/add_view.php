<?php
echo <<<MAIN
<div id="create_post"">
	<div id="image_field">
	<form id="upload_form" enctype="multipart/form-data" action="/add/put/" method="post">
	<input type="file" id="file_up" name="image_upload" accept="image/jpeg, image/png, image/gif">
</form>
</div>
	<div id="side_menu">	
		<div  id="sticker_bar">STICKER BAR</div>
		<div id ="description">DESCRIPTION</div>
		<input id="submit" type="submit" form="upload_form">
<!--		<div id="submit"><input type="submit" form="upload_form"></div></div>-->
</div>
</div>
MAIN;
