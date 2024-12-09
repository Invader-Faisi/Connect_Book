<?php
function linkCSS($cssPath) {
    $url = BASE_URL . "/" . $cssPath; echo '<link rel="stylesheet" href="' . $url . '" type="text/css">';
}

function linkJS($jsPath){
    $url = BASE_URL. "/". $jsPath;
    echo '<script src="'. $url .'"></script>';
}