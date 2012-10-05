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
 * BlogPage.class.php file.
 * This file contains the sourcecode of the Blog Page class.
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
 * BlogPage class.
 * This class is the public blog view controller.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
class BlogPage extends Page
{

    public function __construct()
    {
        parent::__construct('blog');
        $this->title = _('Blog');
    }

    // Page interface methods.--------------------------------------------------
    public function printHTMLHeader($pageTitle = NULL, $redirectURL = NULL)
    {
        global $fmbConf;

        if (is_null($pageTitle)) {
            $pageTitle = $this->title;
        }

        $this->tpl->assign('fmbTitle', $fmbConf['blog']['title']);
        $this->tpl->assign('fmbPageTitle', $pageTitle);
        $this->tpl->assign('fmbSiteUrl', $fmbConf['site']['url']);
        $this->tpl->assign('fmbTemplatesUrl', $fmbConf['themes_url']);
        $this->tpl->assign('fmbStyle', $this->style);
        if (!is_null($redirectURL)) {
            $this->tpl->assign('fmbRedirect', $redirectURL);
        }
        $this->tpl->display($this->style.'/blog/fmb.htmlHeader.tpl');
    }

    public function printHeader($pageTitle = NULL)
    {
        global $fmbConf;

        if (is_null($pageTitle)) {
            $pageTitle = $this->title;
        }

        $this->tpl->assign('fmbSlogan', $fmbConf['blog']['slogan']);
        $this->tpl->assign('fmbPageTitle', $pageTitle);
        $this->tpl->display($this->style.'/blog/fmb.header.tpl');
    }

    public function printFooter()
    {
        $sqlQueriesCount = $this->db->getSQLQueriesCount();
        $this->tpl->assign('fmbSQLQueriesCount', $sqlQueriesCount);
        $this->tpl->assign('fmbGenerationTime', Core::getTime());
        $this->tpl->display($this->style.'/blog/fmb.footer.tpl');
    }

    public function printHTMLFooter()
    {
        $this->tpl->display($this->style.'/blog/fmb.htmlFooter.tpl');
    }

    // Blog page methods.-------------------------------------------------------
    /**
     * Print blog menu.
     * @access public
     */
    public function printMenu()
    {
        print($this->getMenu());
    }

    /**
     * Fetch blog menu.
     * @access public
     * @return string Current blog menu.
     */
    public function getMenu()
    {
        $categories = $this->db->query(
            'SELECT * '.
            'FROM fmb_blog_categories '.
            'ORDER BY cat_id',
            array(),
            DBPlugin::SQL_QUERY_ALL
        ) ? $this->db->getSQLResult() : array();

        $links = $this->tpl->fetch($this->style.'/blog/fmb.links.tpl');

        $this->tpl->assign('fmbIsLogged', User::isLogged());
        $this->tpl->assign('fmbIsAdmin', User::isAdmin());
        $this->tpl->assign('fmbBlogCategories', $categories);
        $this->tpl->assign('fmbBlogLinks', $links);

        return $this->tpl->fetch($this->style.'/blog/fmb.menu.tpl');
    }

    /**
     * Print blog archives.
     * @access public
     */
    public function printArchives()
    {
        $yearExtract = $this->db->getSQLExtractString('year', 'post_time');
        $monthExtract = $this->db->getSQLExtractString('month', 'post_time');

        $queryString = 'SELECT '.$yearExtract.' AS year, '.
                        '      '.$monthExtract.' AS month, '.
                        '       post_time '.
                        'FROM fmb_blog_posts '.
                        'WHERE post_draft = false '.
                        'ORDER BY year DESC, month ASC';

        $archives = $this->db->query(
            $queryString,
            array(),
            DBPlugin::SQL_QUERY_ALL
        ) ? $this->db->getSQLResult() : array();

        $this->tpl->assign('fmbBlogArchives', $archives);
        $this->tpl->display($this->style.'/blog/fmb.archives.tpl');
    }

    /**
     * Print no post information.
     * @access public
     * @param string cause What caused the absence of post.
     */
    public function printNoPost($cause = NULL)
    {
        if (is_null($cause)) {
            $cause = _('No post due to unknown cause.');
        }

        $this->printHTMLHeader($cause);
        $this->printHeader();
        $this->tpl->assign('fmbNoPostCause', $cause);
        $this->tpl->display($this->style.'/blog/fmb.noPost.tpl');
    }

    /**
     * Print specified blog post.
     * @access public
     * @param int postID Post to print ID.
     */
    public function printPost($postID)
    {
        if (is_numeric($postID)) {
            $query = 'SELECT P.*, C.cat_title, M.mem_login, T.nb_comments '.
                     'FROM fmb_blog_posts AS P '.
                     'LEFT JOIN fmb_blog_categories AS C '.
                     '          ON C.cat_id = P.post_cat '.
                     'LEFT JOIN fmb_members AS M '.
                     '          ON M.mem_id = P.post_mem '.
                     'LEFT JOIN ( '.
                     '    SELECT COUNT(*) AS nb_comments, com_post '.
                     '    FROM fmb_blog_comments '.
                     '    GROUP BY com_post'.
                     ') AS T on T.com_post = P.post_id '.
                     'WHERE P.post_draft = FALSE AND P.post_id = ?';
            $values = array($postID);
            $this->retrievePosts(
                $query,
                $values,
                DBPlugin::SQL_QUERY_FIRST
            );
        } else {
            // Invalid post query
            $this->printNoPost(_('Invalid post ID.'));
        }
    }

    /**
     * Print last blog posts. Last blog posts count can be configured through
     * $fmbConf['blog']['lastposts'].
     * @access public
     */
    public function printLastPosts()
    {
        global $fmbConf;

        if (isset($fmbConf['blog']['lastposts'])
            && is_numeric($fmbConf['blog']['lastposts'])) {
            $lastPosts = $fmbConf['blog']['lastposts'];
        } else {
            $lastPosts = 3;
        }

        $query = 'SELECT P.*, C.cat_title, M.mem_login, T.nb_comments '.
                 'FROM fmb_blog_posts AS P '.
                 'LEFT JOIN fmb_blog_categories AS C '.
                 '           ON C.cat_id = P.post_cat '.
                 'LEFT JOIN fmb_members AS M '.
                 '           ON M.mem_id = P.post_mem '.
                 'LEFT JOIN ( '.
                 '    SELECT COUNT(*) AS nb_comments, com_post '.
                 '    FROM fmb_blog_comments '.
                 '    GROUP BY com_post'.
                 ') AS T on T.com_post = P.post_id '.
                 'WHERE P.post_draft = FALSE '.
                 'ORDER BY P.post_time DESC '.
                 'LIMIT '.$lastPosts;
        $values = array();
        $this->retrievePosts($query, $values);
    }

    /**
     * Print posts after search, categories or archives browsing.
     * @access public
     */
    public function printPosts()
    {
        global $fmbConf;
        $restrictedQuery = false;
        $query = 'SELECT P.*, C.cat_title, M.mem_login, T.nb_comments '.
                 'FROM fmb_blog_posts AS P '.
                 'LEFT JOIN fmb_blog_categories AS C '.
                 '           ON C.cat_id = P.post_cat '.
                 'LEFT JOIN fmb_members AS M '.
                 '           ON M.mem_id = P.post_mem '.
                 'LEFT JOIN ( '.
                 '    SELECT COUNT(*) AS nb_comments, com_post '.
                 '    FROM fmb_blog_comments '.
                 '    GROUP BY com_post'.
                 ') AS T on T.com_post = P.post_id '.
                 'WHERE P.post_draft = FALSE ';
        $values = array();

        // Category?
        if (isset($_GET['cat']) && is_numeric($_GET['cat'])) {
            $query .= 'AND p.post_cat = ? ';
            array_push($values, $_GET['cat']);
            $restrictedQuery = true;
        }

        // Tag?
        if (isset($_GET['tag']) && is_numeric($_GET['tag'])) {
            $query .= 'AND p.post_id IN ('.
                      '   SELECT DISTINCT post_id '.
                      '   FROM fmb_blog_tags_rel '.
                      '   WHERE tag_id = ?'.
                      ') ';
            array_push($values, $_GET['tag']);
            $restrictedQuery = true;
        }

        // Specific period?
        if (
            isset($_GET['y'])
            && isset($_GET['m'])
            && is_numeric($_GET['y'])
            && is_numeric($_GET['m'])
        ) {
            $startEpoch = mktime(0, 0, 0, $_GET['m'], 1, $_GET['y']);
            $endEpoch = mktime(0, 0, 0, ($_GET['m'] + 1), 1, $_GET['y']); 
            $query .= 'AND p.post_time ';
            $query .= $this->db->getSQLIntervalString($startEpoch, $endEpoch);
            $restrictedQuery = true;
        }

        // Search?
        if (!empty($_GET['q'])) {
            $cols = 'p.post_body,p.post_more,p.post_title';
            $searchQueryStr = $this->db->getSQLSearchString($cols, $_GET['q']);
            $query .=  $searchQueryStr;
            $restrictedQuery = true;
        }

        $query .= ' ORDER BY P.post_time DESC';

        if (! $restrictedQuery) {
            if (isset($fmbConf['blog']['lastposts'])
                && is_numeric($fmbConf['blog']['lastposts'])) {
                    $lastPosts = $fmbConf['blog']['lastposts'];
            } else {
                $lastPosts = 3;
            }
            $query .= ' LIMIT '.$lastPosts;
        }

        $this->retrievePosts($query, $values);
    }

    /**
     * Retrieve posts matching given SQL query.
     * @access private
     * @param string query SQL query to fetch posts.
     * @param array values Values for SQL query.
     * @param int mode Fetch mode for SQL query.
     */
    private function retrievePosts(
        $query,
        $values,
        $mode = DBPlugin::SQL_QUERY_ALL
    )
    {
        // TODO : check params.

        $posts = ($this->db->query($query, $values, $mode))
                    ? $this->db->getSQLResult()
                    : array();

        if ($mode != DBPlugin::SQL_QUERY_ALL) {
            $posts = array($posts);
        }

        $this->showPosts($posts);
    }

    /**
     * Print given posts.
     * @access private
     * @param array postsArray Array of posts.
     */
    private function showPosts($postsArray)
    {
        // TODO : Check params.
        global $fmbConf;

        // Search ?
        if (!empty($_GET['q'])) {
            $this->tpl->assign('fmbSearch', $_GET['q']);
            $this->tpl->assign('fmbSearchResultsCnt', count($postsArray));
            $this->tpl->assign('fmbDisplaySearch', true);
        } else {
            $this->tpl->assign('fmbDisplaySearch', false);
        }

        if ((count($postsArray) == 0) || ($postsArray[0] == NULL)) {
            // No post with this ID
            $this->printNoPost(_('No matching post.'));
            return;
        }

        if (count($postsArray) == 1) {
            // Only one post. Print comments.
            $post = $postsArray[0];

            $this->tpl->assign('fmbPostID', $post['post_id']);
            $commentFormTPL = $this->style;

            if (! $this->db->getBooleanValueFromSQL($post['post_closed'])) {

                $commentFormTPL .= '/blog/fmb.commentForm.tpl';
                $this->checkComment();
                $this->tpl->assign('fmbUserID', User::getUserID());
                $this->tpl->assign('fmbUserLogin', User::getUserLogin());

            } else {
                $commentFormTPL .= '/blog/fmb.commentsClosed.tpl';
            }

            $this->printHTMLHeader($post['post_title']);

            $comments = $this->getPostComments($post['post_id']);
            $commentForm = $this->tpl->fetch($commentFormTPL);

            $this->tpl->assign('fmbComments', $comments);
            $this->tpl->assign('fmbCommentForm', $commentForm);
            $this->tpl->assign('fmbDisplayMore', true);
        } else {
            // More than one post. Don't print comments.
            $this->printHTMLHeader();
        }

        $this->printHeader();

        // Fetch posts and assign them to template
        $postsRes = array();
        $postTPL = $this->style.'/blog/fmb.post.tpl';

        foreach ($postsArray as $post) {
            $query = 'SELECT T.* '.
                     'FROM fmb_blog_tags_rel R '.
                     'LEFT JOIN fmb_blog_tags T '.
                     '           ON R.tag_id = T.tag_id '.
                     'WHERE post_id = ?';

            $postTags = $this->db->query(
                $query,
                array(intval($post['post_id'])),
                DBPlugin::SQL_QUERY_ALL
            ) ? $this->db->getSQLResult() : array();

            // Format post
            if ($this->plugEng->existPluginOfType('formatting')) {
                $tmpArray = array($post['post_body'], true);
                $tmpText = $this->plugEng->doHookFunction('format', $tmpArray);
                $post['post_body'] = $tmpText;
                
                $tmpArray = array($post['post_more'], true);
                $tmpText = $this->plugEng->doHookFunction('format', $tmpArray);
                $post['post_more'] = $tmpText;
            }

            $this->tpl->assign('fmbPost', $post);
            $this->tpl->assign('fmbPostTags', $postTags);

            $date = strftime('%d %B', strtotime($post['post_time']));
            $contents = $this->tpl->fetch($postTPL);

            array_push(
                $postsRes, 
                array ('timestamp' => $date, 'contents' => $contents)
            );
        }
        $this->tpl->assign('fmbPosts', $postsRes);

        // Display posts
        $this->tpl->display($this->style.'/blog/fmb.posts.tpl');
    }

    /**
     * Fetch comments for given post ID.
     * @access private
     * @param int postID ID of the post to fetch comments for.
     * @return string Comments for this post.
     */
    private function getPostComments($postID)
    {
        // TODO : Check params.
        $comments = $this->db->query(
            'SELECT * '.
            'FROM fmb_blog_comments '.
            'WHERE com_post = ?',
            array($postID),
            DBPlugin::SQL_QUERY_ALL
        ) ? $this->db->getSQLResult() : array();

        $this->tpl->assign('fmbPostComments', $comments);
        return $this->tpl->fetch($this->style.'/blog/fmb.comments.tpl');
    }

    /**
     * Check posted comment.
     * @access private
     */
    private function checkComment()
    {

        if (isset($_POST['action']) && ($_POST['action'] == 'addComment')) {
            $errorUID = false;
            $errorBody = false;

            // Check uid for tampering
            if (empty($_POST['user_id']) || ($_POST['user_id'] != User::getUserID())) {
                $errorUID = true;
                $this->tpl->assign('fmbCommentUIDError', $errorUID);
            }

            // Anonymous comment posting
            if (empty($_POST['com_name'])) {
                if (-1 == User::getUserID()) {
                    $_POST['com_name'] = _('Anonymous');
                } else {
                    $_POST['com_name'] = User::getUserLogin();
                }
            }

            // No body
            if (empty($_POST['com_body'])) {
                $errorBody = true;
                $this->tpl->assign('fmbCommentBodyError', $errorBody);
            }

            // Remember comment name
            if (isset($_POST['remember'])) {
                $_SESSION['usrLogin'] = $_POST['com_name'];
            }

            if (!$errorUID && !$errorBody) {

                // Everything is fine, entering the comment in the DB
                $ip = getenv('REMOTE_ADDR');
                $host = gethostbyaddr($ip);
                $query ='INSERT INTO fmb_blog_comments '.
                        '(com_body, com_name, com_mail, com_time, '.
                        'com_host, com_ip, com_post, com_mem) VALUES ' .
                        '(?, ?, ?, ?, ?, ?, ?, ?)';
                $commentOK = $this->db->query(
                    $query,
                    array(
                        $_POST['com_body'],
                        $_POST['com_name'],
                        $_POST['com_mail'],
                        date('Y-m-d H:i:s', time()),
                        $host,
                        $ip,
                        $_POST['post_id'],
                        $_POST['user_id']
                    ),
                    DBPlugin::SQL_QUERY_MANIP
                );

                $this->tpl->assign('fmbCommentOk', $commentOK);
            }
        }
    }
}
?>
