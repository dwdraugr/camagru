<?php
class Controller_Add extends Controller
{
	private static $view_page = "add_view.php";

	public function __construct()
	{
		$this->view = new View();
		$this->model = New Model_Add();
	}

	public function action_index($param = null)
	{
		$this->view->generate(self::$view_page, Controller::$template);
	}

	public function action_like($param)
	{
		if (gettype($param) === 'array')
		{
			header("Location: /404/");
			exit;
		}
		$result = $this->model->add_like($param);
		if ($result  === Model::SUCCESS)
		{
			header("Location: ".$_SERVER['HTTP_REFERER']."#$param");
			exit();
		}
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit;
		}
		else
			$this->view->generate(self::$view_page, Controller::$template, $result);
	}

	public function action_create()
	{
		$result = $this->model->create_article();
		if (gettype($result) === "array")
		{
			header("Location: /article/index/$result[1]");
			exit();
		}
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		elseif ($result === Model::INCOMPLETE_DATA)
		{
			header("Location: /auth");
			exit();
		}
		else
			$this->view->generate(self::$view_page, Controller::$template, $result);
	}

	public function action_create_base()
	{
		$result = $this->model->create_article_base();
		if (gettype($result) === "array")
		{
			header("Location: /article/index/$result[1]");
			exit();
		}
		elseif ($result === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit();
		}
		elseif ($result === Model::INCOMPLETE_DATA)
		{
			header("Location: /auth");
			exit();
		}
		else
			$this->view->generate(self::$view_page, Controller::$template, $result);
	}
}