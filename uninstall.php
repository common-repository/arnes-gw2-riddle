<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit ();

$upload_dir = wp_upload_dir();
$basedir = $upload_dir['basedir'];

// Optionen

delete_option( 'arne_raetsel_version' );
delete_option( 'arne_riddle' );

// Rätselbilder

@unlink($basedir.'/arne_riddle/source/upload.jpg');
@unlink($basedir.'/arne_riddle/source/.htaccess');
@rmdir($basedir.'/arne_riddle/source');

@unlink($basedir.'/arne_riddle/riddle.jpg');
@unlink($basedir.'/arne_riddle/riddle-klein.jpg');

// Galeriebilder

if (file_exists($basedir.'/arne_riddle/gallery/thumbs')) {
    $files = glob($basedir.'/arne_riddle/gallery/thumbs/*.jpg');
    foreach ($files as $file) {
        if (is_file($file)) @unlink($file);
    }
    @rmdir($basedir.'/arne_riddle/gallery/thumbs');
}

if (file_exists($basedir.'/arne_riddle/gallery')) {
    $files = glob($basedir.'/arne_riddle/gallery/*.jpg');
    foreach ($files as $file) {
        if (is_file($file)) @unlink($file);
    }
    @rmdir($basedir.'/arne_riddle/gallery');
}

@rmdir($basedir.'/arne_riddle');
    
?>