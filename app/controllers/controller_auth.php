<?php
class Controller_Auth extends Controller
{
	private static $view_page = "auth_view.php";
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Auth();
    }

    public function action_index($param = null)
    {
        $this->view->generate(Controller_Auth::$view_page, Controller::$template, $param);
    }

    public function action_signin($param)
    {
        if (isset($_SESSION['nickname']) and isset($_SESSION['password']))
        {
            header("Location: /main/");
            exit();
        }
        $data = $this->model->get_data($param['nickname'], $param['password']);
        if ($data === Model::SUCCESS)
        {
            header("Location: /main/");
            exit();
        }
        else
            $this->action_index($data);
    }

    public function action_signout()
    {
        session_destroy();
        header("Location: /main/");
        exit();
    }

    public function action_confirm($param)
    {
        $result = $this->model->confirm_account($param);
        if ($result === Model::SUCCESS)
        {
            header("Location: /main/");
            exit;
        }
        else
        $this->view->generate(Controller_Auth::$view_page, Controller::$template, $result);
    }
}