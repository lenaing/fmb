<?php
require_once('../../../src/base.inc.php');
use FMB\Core\Core;
use FMB\Core\User;
use FMB\Pages\BlogAdminPage;

Core::loadFile('src/pages/BlogAdminPage.class.php');

$admin =& new BlogAdminPage();

// Check authorization
if (!User::isLogged() || !User::isAdmin()) {
    $admin->redirect('../index.php', 'Droits insuffisants.');
    exit;
}

// Retrieve asked page
$page = (isset($_GET['page'])) ? $_GET['page'] : '';

$admin->printHTMLHeader(_('Administration'));
$admin->printHeader(_('Administration'));

// Default action : Add something.
if (!isset($_GET['action'])) {
    $action = 'add';
} else {
    $action = $_GET['action'];
}

// Print relevant page.
switch($page) {
    case 'post' : {
        switch($action) {
            case 'del' : {
                $admin->printDelPost();
            } break;
            case 'add' :
            case 'mod' :
            case 'upd' :
            default : {
                $admin->printAddPost($action);
            }
        }
    } break;
    case 'cat' : {
        switch($action) {
            case 'del' : {
                $admin->printDelCategory();
            } break;
            case 'add' :
            case 'mod' :
            case 'upd' :
            default : {
                $admin->printAddCategory($action);
            }
        }
    } break;
    case 'tag' : {
        switch($action) {
            case 'assign' : {
                $admin->printAssignTagToPost();
            } break;
            case 'del' : {
                $admin->printDelTag();
            } break;
            case 'add' :
            case 'mod' :
            case 'upd' :
            default : {
                $admin->printAddTag($action);
            }
        }
    } break;
    default : {
        $admin->printIntro();
    }
}

// Print everything else
$admin->printMenu();
$admin->printFooter();
$admin->printHTMLFooter();
?>
