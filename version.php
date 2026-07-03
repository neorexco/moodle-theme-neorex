<?php
defined('MOODLE_INTERNAL') || die();

// Your theme build version
$plugin->version   = '2026060100'; 

// Matched perfectly to your Moodle 5.1.5+ engine core
$plugin->requires  = '2025100605'; 

$plugin->component = 'theme_infinityrex'; 

// Matched perfectly to your server's Boost core version
$plugin->dependencies = [
    'theme_boost' => '2025100600'
];
