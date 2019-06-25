<?php

class View
{
    function generate($content_view, $template_view, $data = null)
    {
//        if(is_array($data)) {
//
//            // преобразуем элементы массива в переменные
//            extract($data);
//        }
        //content_view вызывается в template_view
        include 'app/views/'.$template_view;
    }
}