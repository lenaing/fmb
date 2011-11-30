<?php
require_once('../src/base.inc.php');
use FMB\Core\Core;
use FMB\Pages\SubscribePage;

Core::loadFile('src/pages/SubscribePage.class.php');

$page =& new SubscribePage();

// Default action : Subscribe from home page.
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'subscribe';
$redirection = (isset($_REQUEST['from'])) ? $_REQUEST['from'] : 'home'; 

// Prepare redirection
switch ($redirection) {
    case 'blog' : {
        $redirection = 'blog/index.php';
    } break;
    default :
        $redirection = 'index.php';
}

// Execute action
switch($action) {
    case 'unsubscribe' : {
        $page->printUnsubscribeForm($redirection);
    } break;
    case 'subscribe' :
    default :
        $page->printSubscribeForm($redirection);
}
?>
