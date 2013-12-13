<?php
    
namespace FMB\Pages;
use FMB\Core\Core;
use FMB\Core\User;
use FMB\Pages\Page;
use FMB\Plugins\DBPlugin;
use FMB\Plugins\PluginEngine;

Core::loadFile('src/pages/Page.class.php');

/**
 * BlogRss class.
 * This class is the public rss view controller.
 * @package FMB
 * @subpackage Pages
 * @author Ziirish <ziirish@ziirish.info>
 * @version 0.1b
 */
class BlogRss extends Page
{

    public function __construct()
    {   
        parent::__construct('rss');
        $this->title = _('RSS');
    }

    public function sendRSS($type){
        global $fmbConf;

        header("Content-Type: application/rss+xml");

        $mem = PluginEngine::getCachingPlugin();
        if (null !== $mem) {
	    $key = md5('fmb_blog_rss_'.$type);
	    $res = $mem->get($key);
            if (null !== $res) {
	        $this->tpl->assign('fmbTitle', $fmbConf['blog']['title']);
        	$this->tpl->assign('fmbBlogUrl', $fmbConf['blog']['url']);
	        $this->tpl->assign("fmb_rss_type",$type);
        	$this->tpl->assign("fmb_rss_items",$res);
	        $this->tpl->display($this->style."/blog/fmb.rss.tpl");
                exit;
            }   
        }
 
    	if ($type == "comments") {
    	    // Comments
            $comments = ($this->db->query(
                "SELECT * ".
                "FROM fmb_blog_comments ".
                "ORDER BY com_time ".
                "DESC LIMIT 7",
                array(),
                DBPlugin::SQL_QUERY_ALL)
            )
            ? $this->db->getSQLResult()
            : array();
    
            $items = array();
            foreach ($comments as $comment){
                /*if (!substr($comment["com_mail"],0,4)=="http") {
                $comment["com_mail"] = str_replace(".","[dot]", $comment["com_mail"]);
                $comment["com_mail"] = str_replace("@","[at]",$comment["com_mail"]);
                }
                $comment["com_body"] = str_replace("<","&lt;",$comment["com_body"]);
                $comment["com_body"] = str_replace(">","&gt;",$comment["com_body"]);*/
                array_push($items, $comment);
            }
        } else {
            // Posts
            $posts = ($this->db->query(
                "SELECT P.*, C.cat_title, M.mem_login, T.nb_comments " .
                "FROM fmb_blog_posts AS P " .
                "LEFT JOIN fmb_blog_categories AS C ON C.cat_id = P.post_cat " .
                "LEFT JOIN fmb_members AS M ON M.mem_id = P.post_mem " .
                "LEFT JOIN ( " .
                "	SELECT COUNT(*) AS nb_comments, com_post " .
                "	FROM fmb_blog_comments " .
                "	GROUP BY com_post" .
                ") AS T on T.com_post = P.post_id " .
                "WHERE P.post_draft = FALSE " .
                "ORDER BY P.post_time DESC " .
                "LIMIT 7",
                array(),
                DBPlugin::SQL_QUERY_ALL)
            )
            ? $this->db->getSQLResult()
            : array();
            $items = array();
            foreach ($posts as $post){
                $post["post_title"] = str_replace("<","&lt;",$post["post_title"]);
		$post["post_title"] = str_replace(">","&gt;",$post["post_title"]);
		$sav = $post['post_body'];
		$tmpArray = array($post['post_body'], true, true);
		$tmpText = $this->plugEng->doHookFunction('format', $tmpArray);
		$post['post_body'] = '<![CDATA['.$tmpText.']]>';
                array_push($items, $post);
            }
        }

	if (null !== $mem) {
	    $key = md5('fmb_blog_rss_'.$type);
	    $mem->set($key, $items, null, 12*60*60);
	}

        $this->tpl->assign('fmbTitle', $fmbConf['blog']['title']);
	$this->tpl->assign('fmbBlogUrl', $fmbConf['blog']['url']);
        $this->tpl->assign("fmb_rss_type",$type);
        $this->tpl->assign("fmb_rss_items",$items);
	$this->tpl->display($this->style."/blog/fmb.rss.tpl");
    }

    /** 
     * Print HTML Header with given page title.
     * May redirect to somewhere else.
     * @access public
     * @param string pageTitle Title of the page.
     * @param string redirectURL URL to redirect to.
     */
    public function printHTMLHeader($pageTitle = NULL, $redirectURL = NULL) { return; }

    /** 
     * Print HTML footer.
     * @access public
     */
    public function printHTMLFooter() { return; }

    /**
     * Print FMB header with given page title.
     * @access public
     * @param page_title Title of the page.
     */
    public function printHeader($pageTitle) { return; }

    /**
     * Print FMB footer.
     * @access public
     */
    public function printFooter() { return; }
}
?>
