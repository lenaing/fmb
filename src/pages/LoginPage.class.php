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

/**
 * LoginPage.class.php file.
 * This file contains the sourcecode of the Login Page class.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Pages;
use FMB\Core\Core;
use FMB\Core\User;
use FMB\Pages\Page;
use FMB\Plugins\DBPlugin;
use FMB\Plugins\PluginEngine;

Core::loadFile('src/pages/SitePage.class.php');

/**
 * LoginPage class.
 * This class is the login view controller.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
class LoginPage extends SitePage
{

    public function __construct()
    {
        parent::__construct();
        $this->title = _('Login');
    }

    /**
     * Print login form.
     * @param redirection Where to redirect if successfully logged in.
     */
    public function printLoginForm($redirection){
        if (!empty($_REQUEST['login']) && !empty($_REQUEST['password'])) {

            if ($this->checkLogin()) {
                $this->redirect($redirection,_('Connexion r&eacute;ussie!'));
                return;
            } else {
                $this->tpl->assign('fmbLoginError', true);
            }
        }

        $this->printHTMLHeader();
        $this->printHeader();
        $this->tpl->assign('fmbRequest',$_REQUEST);
        $this->tpl->display($this->style.'/site/fmb.login.tpl');
        $this->printFooter();
        $this->printHTMLFooter();
    }

    /**
     * Check for user login.
     * @return <code>true</code> if allowed, <code>false</code> otherwise.
     */
    private function checkLogin() {
        $user = $this->db->query(
                'SELECT * ' .
                'FROM ogsmk_members ' .
                'WHERE mem_login = ? AND mem_passwd = ?',
                array($_REQUEST['login'], sha1($_REQUEST['password'])),
                DBPlugin::SQL_QUERY_FIRST
        ) ? $this->db->getSQLResult() : array();

        if ($user != array()) {
            $_SESSION['usrID'] = $user['mem_id'];
            $_SESSION['usrLogin'] = $user['mem_login'];
            $_SESSION['usrRights'] = $user['mem_rights'];
            return true;
        }

        return false;
    }
}
?>
