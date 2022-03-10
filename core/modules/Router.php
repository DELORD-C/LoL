<?php

class Router {
    private $view;
    private $app;

    function __construct (View $view, App $app) {
        $this->app = $app;
        $this->view = $view;
    }

    function route($app) {
        if (!empty($_POST)) {

        }
        else if (!empty($_GET['champion'])) {
            $champion = $this->app->getDb()->getChampion($_GET['champion']);
            $this->view->render('champion', [
                'title' => 'LoL API - ' . $champion->name,
                'champion' => $champion
            ]);
        }
        else {
            $this->view->render('index', ['champions' => $this->view->getChampionSearchList()]);
        }
    }

}