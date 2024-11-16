<?php 
session_start();
if (!isset($_SESSION["language"])) $_SESSION["language"] = "ru";
if (!isset($_SESSION["theme"])) $_SESSION["theme"] = 0;
if (!isset($_SESSION["scale"])) $_SESSION["scale"] = 1.0;
if (!isset($_SESSION["user"])) $_SESSION["user"] = isset($_SERVER["REMOTE_USER"]) ? $_SERVER["REMOTE_USER"] : null;

$language = $_SESSION["language"];
$theme = $_SESSION["theme"]; //1 - темная
$scale = $_SESSION["scale"];

function applyStyle() {
    global $theme, $scale;
    $style = "<style>body {";
    if ($theme) {
        $style = $style . "background-color: #222; color: #ddd;";
    }
    $style = $style . "font-size: " . ($scale * 16) . "px;";
    if ($theme) {
        $style = $style . "table { border-color: #fff; } a { color: #ff0; } a:visited { color: #880; } a:hover { color: #fff; } ";
    }
    else {
        $style = $style . "a { color: #00f; } a:visited { color: #808; } a:hover { color: #888; }";
    }
    $style = $style . "}</style>";
    echo $style;
}
?>