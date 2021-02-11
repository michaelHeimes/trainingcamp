<?php
function trainingcamp_images_uri($filename) {
    return sprintf('%s/slice/dist/images/%s', get_template_directory_uri(), $filename);
}
function trainingcamp_get_css_uri($filename) {
    return sprintf('%s/slice/dist/css/%s.min.css', get_template_directory_uri(), $filename);
}
function trainingcamp_get_js_uri($filename) {
    return sprintf('%s/slice/dist/js/%s.min.js', get_template_directory_uri(), $filename);
}

function trainingcamp_get_custom_css_uri($filename) {
    return sprintf('%s/css/%s.css', get_template_directory_uri(), $filename);
}
function trainingcamp_get_custom_min_css_uri($filename) {
    return sprintf('%s/css/%s.min.css', get_template_directory_uri(), $filename);
}
