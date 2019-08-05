<?php
if ($data === Model::ARTICLE_NOT_FOUND)
	echo <<<NOT_FOUND
		<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	Page not found. Please, check you link.
	</p>
NOT_FOUND;
elseif ($data === Model::DB_ERROR)
	echo <<<DB
		<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	Sorry, we have some problem with database. Please stand by.
	</p>
DB;
elseif ($data === Model::INCOMPLETE_DATA)
	echo <<<ID
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	Your message is empty. Please write anything.
	</p>
ID;
elseif ($data === Model::NON_CONFIRMED_ACC)
	echo <<<NCA
	<br><br><br><br><br><br>
	<p style="text-align: center; font-size: larger">
	You account isn't confirmed. Please, check your email
	</p>
NCA;
else
{
	echo <<<ARTICLE
<article class="post">
		<section class="user-profile">
			<img class="user-pic" src="/exchange/icon/{$data[0]['uid']}">
			<p>{$data[0]['nickname']}</p>
		</section>
		<section class="photo">
			<img src="/exchange/photo/{$data[0]['aid']}">
		</section>
		<section class="like-comment_button">
			<form action="/add/like/{$data[0]['aid']}" method="post">
			<input class="like-button" name="like" value="LIKE IT!" type="submit">
</form>
			<br>
			<p style="font-weight: bold">This picture liked {$data[0]['likes']} people</p>
			<p><span style="font-weight: bold">{$data[0]['nickname']}: </span>{$data[0]['description']}</p>
			
ARTICLE;
	if (isset($_SESSION['uid']) and $_SESSION['uid'] === $data[0]['uid'])
	{
		echo "<form action='/article/delete/{$data[0]['aid']}' method='post'>";
		echo "<input style='font-style: italic; color: red' type='submit' name='del' value='Delete Post'>";
		echo "</form><hr>";
	}
	foreach ($data[1] as $datum)
	{
		$content = htmlentities($datum['content']);
		echo <<<COMMENT
	<p><span style="font-weight: bold"><a href="/main/profile/{$datum['uid']}">{$datum['nickname']}:</a></span>
	{$content}
	</p>
COMMENT;
		if ($datum['uid'] === $_SESSION['uid'])
			echo <<<DEL_INPUT
	<form action="/article/del_comment/{$datum['cid']};{$data[0]['aid']}" method="post">
	<input style="color: red" type="submit" value="Delete" name="Delete">
</form>
<hr>
DEL_INPUT;

	}
	echo <<<ADD_COMMENT
<form id="comment_field" action="/article/add/{$data[0]['aid']}" method="post">
	<input style="width: 50%" name="comment" type="text" required="required" maxlength="250">
	<input type="submit" value="submit" name="butt">
</form>
ADD_COMMENT;

	echo "</section></article>";
}