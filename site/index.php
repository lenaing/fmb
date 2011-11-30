<?php
require_once('../src/base.inc.php');
use FMB\Core\Core;
use FMB\Pages\SitePage;

Core::loadFile('src/pages/SitePage.class.php');

$page =& new SitePage();
$page->redirect("blog/index.php", 'Oh hai!');

?>
