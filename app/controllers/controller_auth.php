<?php
class Controller_Auth extends Controller
{
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Auth();
    }

    public function action_index($param = null)
    {
        $this->view->generate("signin_view.php", "template_view.php", $param);
    }

    public function action_signin($param)
    {
        if (isset($_SESSION['nickname']) and isset($_SESSION['password']))
        {
            header("Location: /main/");
            exit();
        }
        $nickname = $param['nickname'];
        $password = $param['password'];
        $data = $this->model->get_data($nickname, $password);
        if ($data)
        {
            $_SESSION['nickname'] = $data[0]['nickname'];
            $_SESSION['password'] = $data[0]['password'];
            $_SESSION['uid'] = $data[0]['id'];
            header("Location: /main/");
            exit();
        }
        else
        {
            $data = 1;
            $this->action_index($data);
        }
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
        if ($result)
        {
            header("Location: /main/");
            exit;
        }
        else
        $this->view->generate("confirmed_view.php", "template_view.php");
    }
}