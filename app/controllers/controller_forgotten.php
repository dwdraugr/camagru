<?php
class Controller_Forgotten extends Controller
{
	private static $view_page = 'forgotten_view.php';

	public function __construct()
	{
		$this->model = new Model_Forgotten();
		$this->view = new View();
	}

	public function action_index($param = null)
	{
		$this->view->generate(Controller_Forgotten::$view_page, Controller::$template);
	}

	public function action_check_email()
	{
		$result = $this->model->check_email();
		$this->view->generate(Controller_Forgotten::$view_page, Controller::$template, $result);
	}

	public function action_recovery($param)
	{
		if (!isset($_POST['new_password']))
			$this->view->generate(Controller_Forgotten::$view_page, Controller::$template,
				array(Model::WRONG_PASSWORD, $param));
		else
		{
			$result = $this->model->new_password($param);
			if ($result === Model::SUCCESS)
			{
				header("Location: /auth/");
				exit();
			}
			else
				$this->view->generate(Controller_Forgotten::$view_page, Controller::$template, $result);
		}
	}
}