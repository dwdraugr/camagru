<?php
if ($data === Model::DB_ERROR)
	echo <<<DB_SUC
<br><br><br><br><br><br>
<p style="text-align: center; font-size: larger">
Sorry, we have some problem with database. Please stand by.
</p>
DB_SUC;
else
	foreach ($data as $d)
	{
		echo <<<article
	<article class="post">
			<section class="user-profile">
				<img class="user-pic" src="/exchange/icon/{$d['uid']}">
				<a href="/main/profile/{$d['uid']}"><p>{$d['nickname']}</p></a>
				<button>* * *</button>
			</section>
			<section class="photo">
				<img src="/exchange/photo/{$d['aid']}">
			</section>
			<section class="like-comment_button">
				<form action="/add/like/{$d['aid']}" method="post">
			<input class="like-button" name="like" value="LIKE IT!" type="submit">
</form>
				<br>
				<p style="font-weight: bold">This picture liked {$d['likes']} people</p>
				<p><span style="font-weight: bold">{$d['nickname']}: </span>{$d['description']}</p>
				<div class="comment-div"><a href="/article/index/{$d['aid']}">Open comments</a></div>
			</section>
		</article>
article;
}