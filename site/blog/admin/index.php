<?php
/*
 Copyright 2009 - 2012 - Etienne 'lenaing' GIRONDEL <lenaing@gmail.com>
 
 FMB :
 ------------
 This software is an homemade PHP Blog engine.
 
 This software is governed by the CeCILL license under French law and
 abiding by the rules of distribution of free software.  You can  use, 
 modify and/ or redistribute the software under the terms of the CeCILL
 license as circulated by CEA, CNRS and INRIA at the following URL
 "http://www.cecill.info". 
 
 As a counterpart to the access to the source code and  rights to copy,
 modify and redistribute granted by the license, users are provided only
 with a limited warranty  and the software's author,  the holder of the
 economic rights,  and the successive licensors  have only  limited
 liability. 
 
 In this respect, the user's attention is drawn to the risks associated
 with loading,  using,  modifying and/or developing or reproducing the
 software by the user in light of its specific status of free software,
 that may mean  that it is complicated to manipulate,  and  that  also
 therefore means  that it is reserved for developers  and  experienced
 professionals having in-depth computer knowledge. Users are therefore
 encouraged to load and test the software's suitability as regards their
 requirements in conditions enabling the security of their systems and/or 
 data to be ensured and,  more generally, to use and operate it in the 
 same conditions as regards security. 
 
 The fact that you are presently reading this means that you have had
 knowledge of the CeCILL license and that you accept its terms.
*/
require_once('../../../src/base.inc.php');
use FMB\Core\Core;
use FMB\Core\User;
use FMB\Pages\BlogAdminPage;

Core::loadFile('src/pages/BlogAdminPage.class.php');

$admin =& new BlogAdminPage();

// Check authorization
if (!User::isLogged() || !User::isAdmin()) {
    $admin->redirect('../index.php', _('Access denied.'));
    exit;
}

// Retrieve asked page
$page = (isset($_GET['page'])) ? $_GET['page'] : '';

$admin->printHTMLHeader();
$admin->printHeader();

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
