<?php
class Controller_Main extends Controller
{
	private static $view_page = "main_view.php";
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index($param = null)
    {
        $data = $this->model->get_feed();
        $this->view->generate(Controller_Main::$view_page, Controller::$template, $data);
    }

    function action_feed($param = null)
    {
        $this->action_index($param);
    }

    function action_profile($param)
    {
        $data = $this->model->get_profile($param);
		$this->view->generate(Controller_Main::$view_page, Controller::$template, $data);
    }
}