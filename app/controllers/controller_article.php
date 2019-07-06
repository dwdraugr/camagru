<?php
class Controller_Article extends Controller
{
	private static $view_page = "article_view.php";
	public function __construct()
	{
		$this->model = new Model_Article();
		$this->view = new View();
	}

	public function action_index($param = null)
	{
		if ($param == null)
		{
			Route::ErrorPage404();
			exit();
		}
		$data = $this->model->get_data($param);
		$this->view->generate(Controller_Article::$view_page, Controller::$template, $data);
	}

	public function action_add($param)
	{
		$data = $this->model->put_comment($param);
		if ($data  === Model::SUCCESS)
		{
			header("Location: /article/index/$param");
			exit();
		}
		elseif ($data === Model::INCORRECT_NICK_PASS)
		{
			header("Location: /auth/");
			exit;
		}
		else
			$this->view->generate(Controller_Article::$view_page, Controller::$template, $data);
	}
}