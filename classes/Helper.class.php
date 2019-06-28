<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class Helper {

    static public function escape($string) {
        return trim(htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8'));
    }

    static public function menu($page, $string) {
        return $page == $string ? ' class="active"':'';
    }

}