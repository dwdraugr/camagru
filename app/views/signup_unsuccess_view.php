<?php
if ($data == Model_Signup::EMAIL_EXIST) {
    echo <<<SUC
<br><br><br><br><br><br>
<p style="text-align: center; font-size: larger">
An account with this email or login has already been created  
</p>
SUC;
}
elseif ($data == Model_Signup::DB_ERROR) {
    echo <<<SUC
<br><br><br><br><br><br>
<p style="text-align: center; font-size: larger">
Sorry, we have some problem. Please stand by.
</p>
SUC;
}