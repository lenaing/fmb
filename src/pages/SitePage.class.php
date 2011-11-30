<?php
/**
 * SitePage.class.php file.
 * This file contains the sourcecode of the Site Page class.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 * TODO : Cache SQL / Template Queries
 * TODO : Enhance site page
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
 * @version 0.1a
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
