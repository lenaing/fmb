<?php

// Check if FMB is configured.
if (! file_exists('config/config.inc.php')) {
    print '<html>'
        . '<title>'
        . '    Error - Full Metal Blog'
        . '</title>'
        . '<body>'
        . '    <p><b>Error :</b> Configuration file not found.'
        . '    You have to configure Full Metal Blog before using it.'
        . '    </p>'
        . '</body>'
        . '</html>';
    exit;
}

// Here we gooooo!
header('Location: site/index.php');

?>
