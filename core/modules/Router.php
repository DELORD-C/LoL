<?php

class Router {
    private $view;

    function __construct ($view) {
        $this->view = $view;
    }

    function route() {
        if (empty($_POST) && empty($_GET)) {
            $this->view->render('index');
        }
    }

}