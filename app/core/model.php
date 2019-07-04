<?php
class Model
{
    const SUCCESS				= 0;
    const DB_ERROR				= 1;
    const USER_EXIST			= 2;
    const INCOMPLETE_DATA		= 3;
    const BAD_EMAIL				= 4;
    const INCORRECT_NICK_PASS	= 5;
    const SID_NOT_FOUND			= 6;
    const WEAK_PASSWORD			= 7;

    const REASON_CREATE			= 100;
    const REASON_FORGOTTEN		= 101;
}
