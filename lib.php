<?php
defined('MOODLE_INTERNAL') || die();

function theme_neorex_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();
    $context = context_system::instance();

    // Preset loading logic
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_neorex', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    } else {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    // Load your custom SCSS
    $pre = file_get_contents($CFG->dirroot . '/theme/neorex/scss/pre.scss');
    $post = file_get_contents($CFG->dirroot . '/theme/neorex/scss/post.scss');

    // Force the image onto the login layout exactly how Boost does it
    $loginbgurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    $imagecss = '';
    if (!empty($loginbgurl)) {
        $imagecss .= 'body.pagelayout-login #page .login-layout-left { ';
        $imagecss .= "background-image: url('$loginbgurl'); ";
        $imagecss .= 'background-size: cover; position: relative; }';
    }

    return $pre . "\n" . $scss . "\n" . $post . "\n" . $imagecss;
}

function theme_neorex_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) return false;
    if ($filearea === 'preset' || $filearea === 'loginbackgroundimage') {
        $theme = theme_config::load('neorex');
        $fs = get_file_storage();
        $file = $fs->get_file($context->id, 'theme_neorex', $filearea, 0, '/', array_pop($args));
        if (!$file) return false;
        send_stored_file($file, 86400, 0, $forcedownload, $options);
        return true;
    }
    return false;
}
