<?php
class Controller_Signup extends Controller
{
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Signup();
    }

    public function action_index($param = null)
    {
        $this->view->generate("signup_view.php", "template_view.php", $param);
    }

    public function action_create()
    {
        if (!(isset($_POST['nickname']) and isset($_POST['email']) and isset($_POST['password'])))
            $this->action_index("not-data");
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $this->action_index("email-gov");
    }
}