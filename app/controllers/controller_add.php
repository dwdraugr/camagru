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

	public function action_put()
	{
		header("Content-type: image/jpeg");
		$img = $this->model->put_file();
			echo file_get_contents("ftp://admin:admin@172.17.0.3/jj.jpg");
	}
}