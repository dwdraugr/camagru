<?php
echo <<<SIGNIN
<div class="zhir"></div>
<div class="auth">
    <p>Sign in to amazing Camagru</p>
    <form name="signin" action="/auth/signin" method="post">
        <p><input  type="text" placeholder="Nickname" name="nickname"></p>
        <p><input type="password" placeholder="Password" name="password"></p>
        <hr>
        <br>
        <p><input type="submit" name="submit" value="Sign In"></p>
SIGNIN;
if ($data)
    echo "<p style='color: darkred; font-style: italic'>Incorrect login or password</p>";
echo <<<SIGNIN
        <p><a href="#forg">Forgotten password?</a></p>
    </form>
</div>
SIGNIN;
