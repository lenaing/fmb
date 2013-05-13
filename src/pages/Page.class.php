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
 * Page.class.php file.
 * This file contains the sourcecode of the Page abstract class.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
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
 * @version 0.1b
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

        if (null != $this->tpl && $this->plugEng->existPluginOfType('template_extend')) {
            $tmpArray = array(&$this->tpl);
            $this->plugEng->doHookFunction('extend', $tmpArray);
        }

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
