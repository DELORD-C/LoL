<?php

class Api {
    private $version;
    private $data;
    private $url;
    private $test;

    function __construct (String $lang, Bool $test = false) {
        $this->version = (object) [
            'version' => json_decode(file_get_contents("https://ddragon.leagueoflegends.com/api/versions.json"))[0],
            'lang' => $lang
        ];
        $this->url = "https://ddragon.leagueoflegends.com/cdn/" . $this->version->version . "/data/" . $this->version->lang . "/";
        $this->test = $test;
    }

    function getVersion() {
        return $this->version;
    }

    function getChampions() {
        $champions = json_decode(file_get_contents($this->url . "champion.json"))->data;
        foreach ($champions as $key => $champion) {
            $details = json_decode(file_get_contents($this->url . "champion/" . $champion->id . ".json"))->data;
            $champions->$key = $details->{$champion->id};
            if ($this->test && $champion->key == 84) {
                break;
            }
        }
        return $champions;
    }

    function getItems() {
        return json_decode(file_get_contents($this->url . "item.json"))->data;
    }
}