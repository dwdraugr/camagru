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

    function action_profile()
    {
        if (!isset($_SESSION['nickname']) or !isset($_SESSION['password']) or !isset($_SESSION['uid']))
        {
            header("Location: /auth/");
            exit();
        }
        $data = $this->model->get_profile();
        if ($data === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		$this->view->generate(Controller_Main::$view_page, Controller::$template, $data);
    }
}