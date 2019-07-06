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

	public function action_create()
	{
		$result = $this->model->create_article();
		if (gettype($result) === "array")
		{
			header("Location: /article/index/$result[1]");
			exit();
		}
	}
}