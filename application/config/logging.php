<?php

// Sample configuration for the logging library

$config = array(
    'simple' => array(
        'level' => 'INFO',
        'type' => 'file',
        'format' => "{message}",
        'file_path' => ''
    ),
    'email_criticals' => array(
        'level' => 'CRITICAL',
        'type' => 'email',
        'format' => "{date} - {level}: {message}",
        'to' => 'descargas@unica.cu',
        'from' => 'descargas@unica.cu',
        'subject' => 'New critical logging message'
    )
);