<?php

class App {
    private $env;
    private $db;

    function __construct () {
        $this->env = json_decode(file_get_contents(__DIR__ . '/../../secure/env.json'));
        $this->db = new Db($this->env->db);
    }

    function getEnv () {
        return $this->env;
    }
}