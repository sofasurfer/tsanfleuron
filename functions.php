<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

/**
 * Theme includes
 *
 * Includes all files from the library directory.
 */
$dir = plugin_dir_path(__FILE__) . 'components';
foreach(new DirectoryIterator($dir) as $fileinfo) {
  if(!$fileinfo->isDot() && !$fileinfo->isDir() && substr($fileinfo->getFilename(), 0, 1) != '.') {
    $file = basename(dirname($fileinfo->getRealPath())) . '/' . $fileinfo->getFilename();
    require_once $file;
  }
}
unset($dir, $fileinfo, $file);


