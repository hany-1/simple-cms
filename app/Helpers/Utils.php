<?php

if (!function_exists('slugify')) {
    /**
     * Function that return text a slugify 
     * 
     */
    function slugify($text = null)
    {
        return str_replace(' ', '-', strtolower($text));
    }
}
