<?php

class View {
    private $css = '';
    private $js = '';
    private $assetPath;
    private $assetFinalPath;

    function __construct () {
        $this->assetPath = __DIR__ . '/../../assets/';
        $this->assetFinalPath = str_replace('\\', '/', realpath(dirname($this->assetPath)));
        $this->assetFinalPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->assetFinalPath) . '/assets/';
        $this->getAssets();
    }

    function render ($name, $data = []) {
        $template = file_get_contents(__DIR__ . '/../../templates/header.html');
        $template .= file_get_contents(__DIR__ . '/../../templates/' . $name . '.html');
        $template .= file_get_contents(__DIR__ . '/../../templates/footer.html');
        preg_match_all('/\*{2}[^\*]*\*{2}/', $template, $includes);
        if (!empty($includes[0])) {
            foreach ($includes[0] as $tName) {
                $template = str_replace($tName, file_get_contents(__DIR__ . '/../../templates/' . trim($tName, '\*') . '.html'), $template);
            }
        }
        preg_match_all('/\{{2}media:[^\{\}]*\}{2}/', $template, $medias);
        if (!empty($medias[0])) {
            foreach ($medias[0] as $mName) {
                $template = str_replace($mName, $this->assetFinalPath . 'media/' . substr($mName, 8, -2), $template);
            }
        }
        if (empty($data['title'])) {
            $data['title'] = 'LoL API';
        }

        $template = str_replace('{{cssAssets}}', $this->css, $template);
        $template = str_replace('{{jsAssets}}', $this->js, $template);
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

    function getAssets() {
        
        foreach(glob($this->assetPath . 'css/*.css') as $file) {
            preg_match('/[^\/]+$/', $file, $match);
            $this->css .= '<link rel="stylesheet" href="' . $this->assetFinalPath . 'css/' . $match[0] . '">';
        }
        foreach(glob($this->assetPath . 'js/*.js') as $file) {
            preg_match('/[^\/]+$/', $file, $match);
            $this->js .= '<script src="' . $this->assetFinalPath . 'js/' .$match[0] . '"></script>';
        }
    }
}