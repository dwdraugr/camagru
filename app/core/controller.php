<?php
class Controller {
    public $model;
    public $view;
    protected static $template = "template_view.php";

    function __construct()
    {
        $this->view = new View;
    }

    function action_index($param = null)
    {

    }
}
?>