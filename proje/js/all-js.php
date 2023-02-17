<?php
require_once('../include/session.php');
ini_set('display_errors', '0');
/*
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')){
    header('Content-Encoding: gzip');
    ob_start('ob_gzhandler');
}
else
*/
    header("Content-type: text/javascript; charset: utf-8");
header("Cache-Control: must-revalidate");

$offset = 60 * 60 * 3;
$ExpStr = "Expires: " .
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);
include('jquery.corner.js');
include('jquery.elevateZoom-3.0.8.min.js');
include('../include/3rdparty/fancybox/jquery.fancybox.pack.js');
include('jquery.autocomplete.pack.js');
include('jquery.tooltipster.min.js');
include('passrev.js');
include('jquery.keypad.pack.js');
include('jquery.keypad-tr.js');
include('jquery.mask.min.js');
include('alerter.min.js');
include('site.js');
include('../include/langJS.php');
?>