<?php
class Exchange_View
{
    function push_img($img)
    {
        header("Content-type: image/jpeg");
        echo $img;
    }
}