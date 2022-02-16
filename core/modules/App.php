<?php

class App {
    private $env;
    private $db;
    private $api;
    private $version;
    private $view;

    function __construct () {
        $this->env = json_decode(file_get_contents(__DIR__ . '/../../secure/env.json'));
        if (is_file(__DIR__ . '/../../secure/version.json')) {
            $this->version = json_decode(file_get_contents(__DIR__ . '/../../secure/version.json'));
        }
        else {
            $this->version = (object) ["version" => "Null", "lang" => ""];
        }
        $this->handleErrors();
        $this->db = new Db($this->env->db, $this->env->test);
        $this->api = new Api($this->env->lang, $this->env->test);
        $this->view = new View();
        $this->checkVersion();
    }

    function getEnv () {
        return $this->env;
    }

    function updateEnv() {
        file_put_contents(__DIR__ . '/../../secure/env.json', json_encode($this->env));
    }

    function updateVersion() {
        file_put_contents(__DIR__ . '/../../secure/version.json', json_encode($this->version));
    }

    function checkVersion() {
        if ($this->api->getVersion() != $this->version && ($this->env->autoUpdate == true || $this->version->version == "Null")) {
            $prev = $this->version->version . ' ' . $this->version->lang;
            $this->version = $this->api->getVersion();
            $next = $this->version->version . ' ' . $this->version->lang;
            $this->view->render('update', [
                'prev' => $prev,
                'next' => $next,
                'title' => "LoL API - Updated Database"
            ]);
            $this->db->updateAllDb($this->api);
            $this->updateVersion();
            header("Refresh:3");
        }
        else {
            $this->route();
        }
    }

    function handleErrors() {
        if ($this->env->env == 'dev') {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
        else {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
    }

    function route() {
        if (empty($_POST) && empty($_GET)) {
            $this->view->render('index');
        }
    }
}