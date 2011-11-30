<?php
/**
 * TODO
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 * TODO : Cache SQL / Template Queries
 */
namespace FMB\Pages;
use FMB\Core\Core;
use FMB\Core\User;
use FMB\Pages\Page;
use FMB\Plugins\DBPlugin;
use FMB\Plugins\PluginEngine;

Core::loadFile('src/pages/SitePage.class.php');

/**
 * TODO
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
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

        $this->printHTMLHeader(_('Connexion'));
        $this->printHeader(_('Connexion'));
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
