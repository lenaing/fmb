<?php
/**
 * Page.class.php file.
 * This file contains the sourcecode of the Page abstract class.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Pages;
use FMB\Core\Core;
use FMB\Pages\PageInterface;
use FMB\Plugins\PluginEngine;

// Loading required files.
Core::loadFile('src/pages/Page.interface.php', true);

/**
 * Page abstract class.
 * This class is the master class of all FMB site pages.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 * @abstract
 */
abstract class Page implements PageInterface
{
    /**
     * @var string Page type.
     * @access public
     */
    public $type;

    /**
     * @var string Page title.
     * @access public
     */
    public $title;

    /**
     * @var class Plugin engine instance.
     * @access public
     */
    public $plugEng;

    /**
     * @var class Template plugin instance.
     * @access public
     */
    public $tpl;

    /**
     * @var class Database plugin instance.
     * @access public
     */
    public $db;

    /**
     * @var string Current template style.
     * @access public
     */
    public $style;

    public function __construct($type)
    {
        // TODO : Check params.
        global $fmbConf;

        $this->type = $type;

        $fmbPluginEngine = PluginEngine::getInstance();
        $this->tpl = $fmbPluginEngine->getTemplatePlugin();
        $this->db = $fmbPluginEngine->getDatabasePlugin();
        $this->plugEng = $fmbPluginEngine;

        if (isset($fmbConf['style']) && !empty($fmbConf['style'])) {
            $this->style = $fmbConf['style'];
        } else {
            $this->style = 'default';
        }
    }

    /**
     * Redirect to given url with specified message.
     * @access public
     * @param string redirectURL Url to redirect to.
     * @param string redirectMessage Informational message.
     */
    public function redirect($redirectURL, $redirectMessage)
    {
        // TODO : Check params.
        $redirectTitle = _('Redirection');
        $this->printHTMLHeader($redirectTitle, $redirectURL);
        $this->printHeader($redirectTitle);
        $this->tpl->assign('fmbRedirect', $redirectURL);
        $this->tpl->assign('fmbMessage', $redirectMessage);
        $this->tpl->display($this->style.'/'.$this->type.'/fmb.redirect.tpl');
        $this->printFooter();
        $this->printHTMLFooter();
    }
}
?>
