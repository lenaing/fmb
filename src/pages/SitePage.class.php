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
 * SitePage.class.php file.
 * This file contains the sourcecode of the Site Page class.
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

Core::loadFile('src/pages/Page.class.php');

/**
 * SitePage class.
 * This class is the public site view controller.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
class SitePage extends Page
{

    public function __construct()
    {
        parent::__construct('site');
        $this->title = _('Home');
    }

    // Page interface methods.--------------------------------------------------
    public function printHTMLHeader($pageTitle = NULL, $redirectURL = NULL)
    {
        global $fmbConf;

        if (NULL == $pageTitle) {
            $pageTitle = $this->title;
        }

        $this->tpl->assign('fmbUrl', $fmbConf['url']);
        $this->tpl->assign('fmbTitle', $fmbConf['site']['title']);
        $this->tpl->assign('fmbPageTitle', $pageTitle);
        $this->tpl->assign('fmbSiteUrl', $fmbConf['site']['url']);
        $this->tpl->assign('fmbBlogUrl', $fmbConf['blog']['url']);
        $this->tpl->assign('fmbTemplatesUrl', $fmbConf['themes_url']);
        $this->tpl->assign('fmbStyle', $this->style);
        if (!is_null($redirectURL)) {
            $this->tpl->assign('fmbRedirect', $redirectURL);
        }
        $this->tpl->display($this->style.'/site/fmb.htmlHeader.tpl');
    }

    public function printHeader($pageTitle = NULL)
    {
        global $fmbConf;

        if (NULL == $pageTitle) {
            $pageTitle = $this->title;
        }

        $this->tpl->assign('fmbSlogan', $fmbConf['site']['slogan']);
        $this->tpl->assign('fmbPageTitle', $pageTitle);
        $this->tpl->display($this->style.'/site/fmb.header.tpl');
    }

    public function printFooter()
    {
        $this->tpl->assign('fmbGenerationTime', Core::getTime());
        $this->tpl->display($this->style.'/site/fmb.footer.tpl');
    }

    public function printHTMLFooter()
    {
        $this->tpl->display($this->style.'/site/fmb.htmlFooter.tpl');
    }
}
?>
