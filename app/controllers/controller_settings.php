<?php
class Controller_Settings extends Controller
{
	private static $view_page = "settings_view.php";

	public function __construct()
	{
		$this->view = new View();
		$this->model = new Model_Settings();
	}

	public function action_index($param = null)
	{
		$this->view->generate(Controller_Settings::$view_page, Controller::$template);
	}

	public function action_send_email()
	{
		$result = $this->model->sending_mail();
		if ($result === Model::SUCCESS)
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		else
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
	}

	public function action_nickname()
	{
		$result = $this->model->change_nickname();
		if ($result === Model::SUCCESS)
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		else
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
	}

	public function action_change_email()
	{
		$result = $this->model->change_email();
		if ($result === Model::SUCCESS)
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		else
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
	}

	public function action_change_password()
	{
		$result = $this->model->change_password();
		if ($result === Model::SUCCESS)
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		else
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
	}

	public function action_icon()
	{
		$result = $this->model->change_icon();
		if ($result === Model::SUCCESS)
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		else
			$this->view->generate(Controller_Settings::$view_page, Controller::$template, $result);
	}
}