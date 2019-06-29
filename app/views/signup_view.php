<?php
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
    if ($data == 'not-data')
        echo "<p style='color: darkred; font-style: italic'>Please, enter login, e-mail and password</p>";
    elseif ($data == 'email-gov')
        echo "<p style='color: darkred; font-style: italic'>Please, enter correct e-mail</p>";
echo <<<SIGNIN
        <p><input type="submit" name="submit" value="Sign In"></p>
    </form>
</div>
SIGNIN;
