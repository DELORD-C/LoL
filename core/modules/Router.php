<?php

class Router {
    private $view;
    private $app;

    function __construct (View $view, App $app) {
        $this->app = $app;
        $this->view = $view;
    }

    function route($app) {
        if (empty($_POST) && empty($_GET)) {
            $this->view->render('index', ['champions' => $this->view->getChampionSearchList()]);
        }
    }

}