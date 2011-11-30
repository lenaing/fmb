<?php
require_once('../../src/base.inc.php');
use FMB\Core\Core;
use FMB\Pages\BlogPage;

Core::loadFile('src/pages/BlogPage.class.php');

$page =& new BlogPage();

// Retrieve asked page. Default : Last posts.
$action = (isset($_GET['page'])) ? $_GET['page'] : 'lastPosts';

// Print relevant page.
switch($action) {
    case 'archives' :
    {
        $pageTitle = _('Archives');
        $page->printHTMLHeader($pageTitle);
        $page->printHeader($pageTitle);
        $page->printArchives();
    } break;
    case 'post' :
    {
        $page->printPost($_GET['id']);
    } break;
    case 'posts' :
    {
        $page->printPosts();
    } break;
    case 'lastPosts' :
    default :
    {
        $page->printLastPosts();
    }
}

// Print everything else
$page->printMenu();
$page->printFooter();
$page->printHTMLFooter();
?>
