<?php

class View {
    function render ($name, $data = []) {
        $template = file_get_contents(__DIR__ . '/../../templates/' . $name . '.html');
        preg_match_all('/\*{2}[^\*]*\*{2}/', $template, $includes);
        if (!empty($includes[0])) {
            foreach ($includes[0] as $tName) {
                $template = str_replace($tName, file_get_contents(__DIR__ . '/../../templates/' . trim($tName, '\*') . '.html'), $template);
            }
        }
        if (empty($data['title'])) {
            $data['title'] = 'LoL API';
        }
        preg_match_all('/\{{2}[^\{\}]*\}{2}/', $template, $vars);
        if (!empty($vars[0])) {
            foreach ($vars[0] as $vNameFull) {
                $vName = trim($vNameFull, '\{\}');
                if (!empty($data[$vName])) {
                    $template = str_replace($vNameFull, $data[$vName], $template);
                }
            }
        }
        echo $template;
    }
}