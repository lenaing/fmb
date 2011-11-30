<?php
require_once('../src/base.inc.php');
use FMB\Core\Core;
use FMB\Pages\LoginPage;

Core::loadFile('src/pages/LoginPage.class.php');

$page =& new LoginPage();

// Default action : Login from home page.
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'login';
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
    case 'logout' : {
        $_SESSION = array();
        session_destroy();
        $page->redirect($redirection, _('D&eacute;connexion r&eacuteussie!'));
    } break;
    case 'login' :
    default :
        $page->printLoginForm($redirection);
}
?>
