<?php

function parent_dir($dir, $up_number = 1) {
    $r = $dir;
    while ($up_number >= 1) {
        $r = dirname($r);
        $up_number -= 1;
    }
    return $r;
}

function controller($controller, $action, $prefix = "", $suffix = "Controller") {
    return "\\Hyroshut\\Controllers\\{$prefix}{$controller}{$suffix}:{$action}";
}