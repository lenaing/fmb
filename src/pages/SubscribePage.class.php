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
class SubscribePage extends SitePage
{

    public function __construct()
    {
        parent::__construct();
        $this->title = _('Subscribe');
    }

    /**
     * Print subscribe form.
     * @param redirection Where to redirect if subscription is successful.
     */
    public function printSubscribeForm($redirection) {
        if (
            !empty($_REQUEST['login'])
            &&
            !empty($_REQUEST['password'])
            &&
            !empty($_REQUEST['passwordConf'])
            &&
            ($_REQUEST['password'] == $_REQUEST['passwordConf'])
        ) {
            $members = $this->db->query(
                'SELECT * ' .
                'FROM ogsmk_members ' .
                'WHERE mem_login = ?',
                array($_REQUEST['login']),
                DBPlugin::SQL_QUERY_FIRST
            ) ? $this->db->getSQLResult() : array(); 

            if (count($members) != 0) {
                $this->tpl->assign('fmbMemberAlreadyExistsError', true);
            } else if ($this->checkSubscription()) {
                $this->redirect($redirection,_('Inscription r&eacute;ussie!'));
                return;
            } else {
                $this->tpl->assign('fmbSubscribeError', true);
            }
        }

        $this->printHTMLHeader(_('Inscription'));
        $this->printHeader(_('Inscription'));
        $this->tpl->assign('fmbRequest', $_REQUEST);
        $this->tpl->display($this->style.'/site/fmb.subscription.tpl');
        $this->printFooter();
        $this->printHTMLFooter();
    }

    /**
     * Print unsubscribe form.
     * @param redirection Where to redirect if unsubscription is successful.
     */
    public function printUnsubscribeForm($redirection) {
        if (!empty($_REQUEST['password'])) {
            $members = $this->db->query(
                    'SELECT * ' .
                    'FROM ogsmk_members ' .
                    'WHERE mem_login = ? AND mem_passwd = ?',
                    array($_SESSION['usrLogin'], sha1($_REQUEST['password'])),
                    DBPlugin::SQL_QUERY_FIRST
            ) ? $this->db->getSQLResult() : array();

            if (count($members) == 0) {
                $this->tpl->assign('fmbNoSuchMemberError', true);
            } else if ($this->checkUnsubscription()) {
                $_SESSION = array();
                session_destroy();
                $this->redirect($redirection,
                                _('D&eacute;sinscription r&eacute;ussie!'));
                return;
            } else {
                $this->tpl->assign('fmbUnsubscribeError', true);
            }
        }

        $this->printHTMLHeader(_('D&eacute;sinscription'));
        $this->printHeader(_('D&eacute;sinscription'));
        $this->tpl->assign('fmbRequest', $_REQUEST);
        $this->tpl->display($this->style.'/site/fmb.unsubscription.tpl');
        $this->printFooter();
        $this->printHTMLFooter();
    }


    /**
     * Check subscription.
     * @return  <code>true</code> if subscription is successful,
     * 			<code>false</code> otherwise.
     */
    private function checkSubscription() {
        return $this->db->query(
            'INSERT INTO ogsmk_members ' .
            '(mem_login, mem_passwd, mem_rights) VALUES ' .
            '(?, ?, ?)',
            array($_REQUEST['login'], sha1($_REQUEST['password']), 2),
            DBPlugin::SQL_QUERY_MANIP
        );
    }

    /**
     * Check unsubscription.
     * @return  <code>true</code> if unsubscription is successful,
     * 			<code>false</code> otherwise.
     */	
    private function checkUnsubscription() {
        $success = $this->db->query(
            'DELETE FROM ogsmk_members ' .
            'WHERE mem_login = ? ',
            array($_SESSION['usrLogin']),
            DBPlugin::SQL_QUERY_MANIP
        );

        if ($success) {
            $_SESSION = array();
            session_destroy();
        }

        return $success;
    }
}
?>
