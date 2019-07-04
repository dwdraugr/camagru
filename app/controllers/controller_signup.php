<?php
class Controller_Signup extends Controller
{
	private static $view_page = "signup_view.php";
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Signup();
    }

    public function action_index($param = null)
    {
        $this->view->generate("signup_view.php", Controller::$template, $param);
    }


    public function action_create()
    {
        if (!(isset($_POST['nickname']) and isset($_POST['email']) and isset($_POST['password']))) {
            $this->action_index(Model::INCOMPLETE_DATA);
            return ;
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->action_index(Model::BAD_EMAIL);
            return ;
        }
            $result = $this->model->create_account($_POST['nickname'], $_POST['password'], $_POST['email']);
        switch ($result) {
            case Model::USER_EXIST:
                $this->view->generate(Controller_Signup::$view_page, Controller::$template,
                    Model::USER_EXIST);
                break;
            case Model::SUCCESS:
                $this->view->generate(Controller_Signup::$view_page, Controller::$template,
					Model::SUCCESS);
                break;
            case Model::DB_ERROR:
                $this->view->generate(Controller_Signup::$view_page, Controller::$template,
					Model::DB_ERROR);
                break;
			case Model::WEAK_PASSWORD:
				$this->view->generate(Controller_Signup::$view_page, Controller::$template,
					Model::WEAK_PASSWORD);
        }
    }
}