<?php
include "app/views/exchange_view.php";
class Controller_Exchange extends Controller
{
    function __construct()
    {
        $this->model = new Model_Exchange();
        $this->view = new Exchange_View();
    }

    function action_photo($param)
    {
        $data = $this->model->get_photo($param);
        $this->view->push_img($data);

    }

    function action_icon($param)
    {
        $data = $this->model->get_icon($param);
        $this->view->push_img($data);
    }
}