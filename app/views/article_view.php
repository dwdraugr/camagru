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
			<button>* * *</button>
		</section>
		<section class="photo">
			<img src="/exchange/photo/{$data[0]['aid']}">
		</section>
		<section class="like-comment_button">
			<button class="like-button">
				<svg class="like-svg" viewBox="0 0 20 20">
					<path d="M9.719,17.073l-6.562-6.51c-0.27-0.268-0.504-0.567-0.696-0.888C1.385,7.89,1.67,5.613,3.155,4.14c0.864-0.856,2.012-1.329,3.233-1.329c1.924,0,3.115,1.12,3.612,1.752c0.499-0.634,1.689-1.752,3.612-1.752c1.221,0,2.369,0.472,3.233,1.329c1.484,1.473,1.771,3.75,0.693,5.537c-0.19,0.32-0.425,0.618-0.695,0.887l-6.562,6.51C10.125,17.229,9.875,17.229,9.719,17.073 M6.388,3.61C5.379,3.61,4.431,4,3.717,4.707C2.495,5.92,2.259,7.794,3.145,9.265c0.158,0.265,0.351,0.51,0.574,0.731L10,16.228l6.281-6.232c0.224-0.221,0.416-0.466,0.573-0.729c0.887-1.472,0.651-3.346-0.571-4.56C15.57,4,14.621,3.61,13.612,3.61c-1.43,0-2.639,0.786-3.268,1.863c-0.154,0.264-0.536,0.264-0.69,0C9.029,4.397,7.82,3.61,6.388,3.61"></path>
				</svg>
			</button>
			<br>
			<p style="font-weight: bold">This picture liked {$data[0]['likes']} people</p>
			<p><span style="font-weight: bold">{$data[0]['nickname']}: </span>{$data[0]['description']}</p>
ARTICLE;
	foreach ($data[1] as $datum)
	{
		$content = htmlentities($datum['content']);
		echo <<<COMMENT
	<p><span style="font-weight: bold"><a href="/main/profile/{$datum['uid']}">{$datum['nickname']}:</a></span>
	{$content}
	</p>
COMMENT;
	}
	echo <<<ADD_COMMENT
<form id="comment_field" action="/article/add/{$data[0]['aid']}" method="post">
	<input style="width: 50%" name="comment" type="text" required="required" maxlength="250">
	<input type="submit" value="submit" name="butt">
</form>
ADD_COMMENT;

	echo "</section></article>";
}