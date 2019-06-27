<?php
class Controller_Main extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index($param = null)
    {
        $data = $this->model->get_feed();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_feed($param = null)
    {
        $this->action_index($param);
    }

    function action_profile()
    {
        $data = $this->model->get_profile();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}