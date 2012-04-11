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
class BlogAdminPage extends Page
{

    public function __construct()
    {
        parent::__construct('blog');
        $this->title = _('Administration');
    }

    // Page interface methods.--------------------------------------------------
    public function printHTMLHeader($pageTitle = NULL, $redirectURL = NULL)
    {
        global $fmbConf;

        if (NULL == $pageTitle) {
            $pageTitle = $this->title;
        }

        $this->tpl->assign('fmbUrl', $fmbConf['url']);
        $this->tpl->assign('fmbTitle', $fmbConf['blog']['title']);
        $this->tpl->assign('fmbPageTitle', $pageTitle);
        $this->tpl->assign('fmbSiteUrl', $fmbConf['site']['url']);
        $this->tpl->assign('fmbBlogUrl', $fmbConf['blog']['url']);
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

        if (NULL == $pageTitle) {
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

    // Blog Admin page methods.-------------------------------------------------

    /**
     * Print Blog admin intro.
     */
    public function printIntro()
    {
        $this->tpl->display($this->style.'/blog/admin/fmb.intro.tpl');
    }

    /**
     * Print Blog menu.
     */
    public function printMenu()
    {
        print($this->getMenu());
    }

    /**
     * Fetch Blog admin menu.
     */
    public function getMenu()
    {
        return $this->tpl->fetch($this->style.'/blog/admin/fmb.menu.tpl');
    }

    /*--------------------------------------------------------------
     * Categories
     *--------------------------------------------------------------
     */
 
    /**
     * Show form to add or update a category, or
     * a list to choose category to modify.
     * @param action Either add, mod, or upd.
     */
    public function printAddCategory($action)
    {
        /*
         * Show category list only for choosing
         * a category to modify.
         */ 
        $showList = ($action == 'mod');
        
        if (isset($_POST['actionDB'])) {
            if ($_POST['actionDB'] == 'addCategory') {
                // Adding a category
                $this->tpl->assign('fmbCatUpdOk',
                                   $this->checkCategoryAdd(false));
            } else if ($_POST['actionDB'] == 'updCategory') {
                // Updating a category
                $this->tpl->assign('fmbCatUpdOk',
                                   $this->checkCategoryAdd(true));
            } else if ($_POST['actionDB'] == 'modCategory') {
                // Choosing a category to modify
                if (!isset($_POST['id']) or ($_POST['id'] == '0')) {
                    // No catagory selected.
                    $this->tpl->assign('fmbCatModErr', true);
                } else {
                    // Correct category selected, show form to modify it.
                    $showList = false;
                    $action = 'upd';
                }
            }
        }

        $this->tpl->assign('fmbAction', $action);
        if ($showList) {

            // Modifying a category
            $categories = $this->getCategories(-1);
            $this->tpl->assign('fmbCategories', $categories);
            $this->tpl->display($this->style.'/blog/admin/fmb.categoryMod.tpl');

        } else {

            // Adding or Updating a category
            if (!empty($_POST['id'])) {
                // Modifying
                $category = $this->getCategories($_POST['id']);
            } else {
                // Adding
                $title = empty($_POST['title']) ? '' : $_POST['title'];
                $desc = empty($_POST['desc']) ? '' : $_POST['desc'];
                $category = array ('cat_title' => $title, 'cat_desc' => $desc);
            }

            $this->tpl->assign('fmbCategory', $category);
            $this->tpl->display($this->style.'/blog/admin/fmb.categoryAdd.tpl');

        }
    }

    /**
     * Print category list for deletion.
     * Delete a category if asked to.
     */
    public function printDelCategory()
    {
        if (isset($_POST['actionDB'])
            && ($_POST['actionDB'] == 'delCategory')) {

            // No catagory selected.
            if (!isset($_POST['id']) || ($_POST['id'] == '0')) {
                $delErr = true;
                $this->tpl->assign('fmbCatDelErr', $delErr);
            }

            // No error, deleting in the database!
            if (!isset($delErr)) {

                // Putting all post in this category to the general one.
                $this->db->query(
                    'UPDATE ogsmk_blog_posts ' .
                    'SET post_cat = ? ' .
                    'WHERE post_cat = ?',
                    array(0, $_POST['id']),
                    DBPlugin::SQL_QUERY_MANIP
                );

                // FIXME check previous call rather than assuming it's true.

                // Deleting this category.
                $delOk = $this->db->query(
                    'DELETE FROM ogsmk_blog_categories ' .
                    'WHERE cat_id = ?',
                    array($_POST['id']),
                    DBPlugin::SQL_QUERY_MANIP
                );

                $this->tpl->assign('fmbCatDelOk', $delOk);

            }
        }

        $categories = $this->getCategories(-1);
        $this->tpl->assign('fmbCategories', $categories);
        $this->tpl->display($this->style.'/blog/admin/fmb.categoryDel.tpl');
    }

    /**
     * Select one or more categories.
     * @param id If &lt; 0 Select all categories,
     *           else select category with given
     *           id.
     */
    private function getCategories($selection)
    {
        if ($selection < 0) {
            return (
                $this->db->query(
                    'SELECT * ' .
                    'FROM ogsmk_blog_categories ' .
                    'ORDER BY cat_id',
                    array(),
                    DBPlugin::SQL_QUERY_ALL
                )
            ) ? $this->db->getSQLResult() : array();
        } else {
            return (
                $this->db->query(
                    'SELECT * '.
                    'FROM ogsmk_blog_categories ' .
                    'WHERE cat_id = ?',
                    array($selection),
                    DBPlugin::SQL_QUERY_FIRST
                )
            ) ? $this->db->getSQLResult() : array();
        }
    }

    /**
     * Check adding or updating a category.
     * @param update Wether we are updating a category
     *               rather than adding one.
     * @return  1 : Missing parameters.
     *          2 : Added/Updated with success.
     *         -1 : Failed to add/update.
     */
    private function checkCategoryAdd($update)
    {
        if (!isset($_POST['title']) 
            || !isset($_POST['desc'])
            || ($_POST['title'] == '') 
            || ($_POST['desc'] == '')) {
            // Missing parameters
            return 1;
        } else {
            if ($update) {
                // Updating a category.
                return (
                    $this->db->query(
                        'UPDATE ogsmk_blog_categories ' .
                        'SET cat_title = ?, cat_desc = ? ' .
                        'WHERE cat_id = ?',
                        array($_POST['title'], $_POST['desc'], $_POST['id']),
                        DBPlugin::SQL_QUERY_MANIP
                    )
                ) ? 2 : -1;
            } else {
                // Adding a category.
                return (
                    $this->db->query(
                        'INSERT INTO ogsmk_blog_categories ' .
                        '(cat_title, cat_desc) VALUES '.
                        '(?, ?)',
                        array($_POST['title'], $_POST['desc']),
                        DBPlugin::SQL_QUERY_MANIP
                    )
                ) ? 2 : -1;
            }
        }
    }

    /*--------------------------------------------------------------
     * Tags
     *--------------------------------------------------------------
     */
 
    /**
     * Show form to add or update a tag, or
     * a list to choose tag to modify.
     * @param action Either add, mod, or upd.
     */
    public function printAddTag($action)
    {
        /* Show tag list only for choosing a tag to modify. */ 
        $showList = ($action == 'mod');

        if (isset($_POST['actionDB'])) {
            if ($_POST['actionDB'] == 'addTag') {
                // Adding a tag
                $this->tpl->assign('fmbTagUpdOk', $this->checkTagAdd(false));
            } else if ($_POST['actionDB'] == 'updTag') {
                // Updating a tag
                $this->tpl->assign('fmbTagUpdOk', $this->checkTagAdd(true));
            } else if ($_POST['actionDB'] == 'modTag') {
                // Choosing a tag to modify
                if (!isset($_POST['id']) or ($_POST['id'] == '0')) {
                    // No tag selected.
                    $this->tpl->assign('fmbTagModErr', true);
                } else {
                    // Correct tag selected, show form to modify it.
                    $showList = false;
                    $action = 'upd';
                }
            }
        }

        $this->tpl->assign('fmbAction', $action);
        if ($showList) {
            // Modifying a tag
            $tags = $this->getTags(-1);
            $this->tpl->assign('fmbTags', $tags);
            $this->tpl->display($this->style.'/blog/admin/fmb.tagMod.tpl');
        } else {
            // Adding or Updating a tag
            if (!empty($_POST['id'])) {
                // Modifying
                $tag = $this->getTags($_POST['id']);
            } else {
                // Adding
                $title = empty($_POST['title']) ? '' : $_POST['title'];
                $desc = empty($_POST['desc']) ? '' : $_POST['desc'];
                $tag = array('tag_title' => $title, 'tag_desc' => $desc);
            }
            $this->tpl->assign('fmbTag', $tag);
            $this->tpl->display($this->style.'/blog/admin/fmb.tagAdd.tpl');
        }
    }

    /**
     * Print tag list for deletion.
     * Delete a tag if asked to.
     */
    public function printDelTag()
    {
        if (isset($_POST['actionDB']) && ($_POST['actionDB'] == 'delTag')) {
            // No tag selected.
            if (!isset($_POST['id']) or ($_POST['id'] == '0')) {
                $delErr = true;
                $this->tpl->assign('fmbTagDelErr', $delErr);
            }

            // No error, deleting in the database!
            if (!isset($delErr)) {
                // Deleting this tag.
                $delOk = $this->db->query(
                    'DELETE FROM ogsmk_blog_tags ' .
                    'WHERE tag_id = ?',
                    array($_POST['id']),
                    DBPlugin::SQL_QUERY_MANIP
                );
                $this->tpl->assign('fmbTagDelOk', $delOk);
            }
        }
        $tags = $this->getTags(-1);
        $this->tpl->assign('fmbTags', $tags);
        $this->tpl->display($this->style.'/blog/admin/fmb.tagDel.tpl');
    }

    /**
     * Select one or more categories.
     * @param id If &lt; 0 Select all categories,
     *           else select category with given
     *           id.
     */
    private function getTags($selection)
    {
        if ($selection < 0) {
            return (
                $this->db->query(
                    'SELECT * ' .
                    'FROM ogsmk_blog_tags',
                    array(),
                    DBPlugin::SQL_QUERY_ALL
                )
            ) ? $this->db->getSQLResult() : array();
        } else {
            return (
                $this->db->query(
                    'SELECT * ' .
                    'FROM ogsmk_blog_tags ' .
                    'WHERE tag_id = ?',
                    array($selection),
                    DBPlugin::SQL_QUERY_FIRST
                )
            ) ? $this->db->getSQLResult() : array();
        }
    }

    /**
     * Check adding or updating a tag.
     * @param update Wether we are updating a tag
     *               rather than adding one.
     * @return  1 : Missing parameters.
     *          2 : Added/Updated with success.
     *         -1 : Failed to add/update.
     */
    private function checkTagAdd($update)
    {
        if (!isset($_POST['title']) 
            || !isset($_POST['desc'])
            || ($_POST['title'] == '') 
            || ($_POST['desc'] == '')) {
            // Missing parameters
            return 1;
        } else {
            if ($update) {
                // Updating a tag.
                return (
                    $this->db->query(
                        'UPDATE ogsmk_blog_tags ' .
                        'SET tag_title = ?, tag_desc = ? ' .
                        'WHERE tag_id = ?',
                        array($_POST['title'],$_POST['desc'], $_POST['id']),
                        DBPlugin::SQL_QUERY_MANIP
                    )
                ) ? 2 : -1;
            } else {
                // Adding a tag.
                return (
                    $this->db->query(
                        'INSERT INTO ogsmk_blog_tags ' .
                        '(tag_title, tag_desc) VALUES '.
                        '(?, ?)',
                        array($_POST['title'], $_POST['desc']),
                        DBPlugin::SQL_QUERY_MANIP
                    )
                ) ? 2 : -1;
            }
        }
    }


    /*--------------------------------------------------------------
     * Posts
     *--------------------------------------------------------------
     */
 
    /**
     * Show form to add or update a post, or
     * a list to choose post to modify.
     * @param action Either add, mod, or upd.
     */
    public function printAddPost($action)
    {
        /*
         * Show post list only for choosing
         * a post to modify.
         */ 
        $showList = ($action == 'mod');
        
        if (isset($_POST['actionDB'])) {
            if ($_POST['actionDB'] == 'addPost') {
                // Adding a post
                $this->tpl->assign('fmbPostUpdOk', $this->checkPostAdd(false));
            } else if ($_POST['actionDB'] == 'updPost') {
                // Updating a post
                $this->tpl->assign('fmbPostUpdOk', $this->checkPostAdd(true));
            } else if ($_POST['actionDB'] == 'modPost') {
                // Choosing a post to modify
                if (!isset($_POST['id']) or ($_POST['id'] == '0')) {
                    // No post selected.
                    $this->tpl->assign('fmbPostModErr', true);
                } else {
                    // Correct post selected, show form to modify it.
                    $showList = false;
                    $action = 'upd';
                }
            }
        }
    
        $this->tpl->assign('fmbAction', $action);
        if ($showList) {
            // Modifying a post
            $this->tpl->assign('fmbPosts', $this->getPosts(-1));
            $this->tpl->display($this->style.'/blog/admin/fmb.postMod.tpl');
        } else {
            // Adding or Updating a post
            if (!empty($_POST['id'])) {
                // Modifying
                $fmbPost = $this->getPosts($_POST['id']);
            } else {
                // Adding

                $title = empty($_POST['title']) ? '' : $_POST['title'];
                $body = empty($_POST['body']) ? '' : $_POST['body'];
                $more = empty($_POST['more']) ? '' : $_POST['more'];
                $year = empty($_POST['year']) ? '' : $_POST['year'];
                $month = empty($_POST['month']) ? '' : $_POST['month'];
                $day = empty($_POST['day']) ? '' : $_POST['day'];
                $h = empty($_POST['h']) ? '' : $_POST['h'];
                $m = empty($_POST['m']) ? '' : $_POST['m'];
                $s = empty($_POST['s']) ? '' : $_POST['s'];
                $closed = (isset($_POST['closed']) && ($_POST['closed'])) ? 't' : 'f';
                $draft = (isset($_POST['draft']) && ($_POST['draft'])) ? 't' : 'f';
                $category = empty($_POST['cat']) ? '' : $_POST['cat'];
                $userID = User::getUserID();

                $fmbPost = array ('post_title' => $title,
                                  'post_body' => $body,
                                  'post_more' => $more,
                                  'post_time' => $year.'-'.$month.'-'.$day.' '.
                                                    $h.':'.$m.':'.$s,
                                  'post_closed' => $closed,
                                  'post_draft' => $draft,
                                  'post_cat' => $category,
                                  'post_mem' => $userID);
            }
            $this->tpl->assign('fmbPost', $fmbPost);
            $this->tpl->assign('fmbCategories', $this->getCategories(-1));
            $this->tpl->display($this->style.'/blog/admin/fmb.postAdd.tpl');
        }
    }

    /**
     * Print post list for deletion.
     * Delete a post if asked to.
     */
    public function printDelPost()
    {
        if (isset($_POST['actionDB']) && ($_POST['actionDB'] == 'delPost')) {
            // No post selected.
            if (!isset($_POST['id']) or ($_POST['id'] == '0')) {
                $delErr = true;
                $this->tpl->assign('fmbPostDelErr', $delErr);
            }

            // No error, deleting in the database!
            if (!isset($delErr)) {
                
                // Deleting this post.
                $delOk = $this->db->query(
                    'DELETE FROM ogsmk_blog_posts ' .
                    'WHERE post_id = ?',
                    array($_POST['id']),
                    DBPlugin::SQL_QUERY_MANIP
                );
                $this->tpl->assign('fmbPostDelOk', $delOk);
            }
        }

        $posts = $this->getPosts(-1);
        $this->tpl->assign('fmbPosts', $posts);
        $this->tpl->display($this->style.'/blog/admin/fmb.postDel.tpl');
    }

    /**
     * Print post list for deletion.
     * Delete a post if asked to.
    */
    public function printAssignTagToPost()
    {
        if (isset($_POST['actionDB'])) {
            if ($_POST['actionDB'] == 'assignTag') {
                // No post selected.
                if (!isset($_POST['id']) or ($_POST['id'] == '0')) {
                    $assignErr = true;
                    $this->tpl->assign('fmbTagAssignErr', $assignErr);
                }
            } else if ($_POST['actionDB'] == 'assignTagToPost') {
                $this->db->query(
                    'DELETE FROM ogsmk_blog_tags_rel ' .
                    'WHERE post_id = ?',
                    array($_POST['id']),
                    DBPlugin::SQL_QUERY_MANIP
                );

                if ($_POST['tags'][0] != '-1') {
                    $query = 'INSERT INTO ogsmk_blog_tags_rel ' .
                             '(post_id, tag_id) VALUES ';
                    $values = array();

                    foreach($_POST['tags'] as $tag) {
                        $query .= '(?,?),';
                        array_push($values, $_POST['id'], $tag);
                    }

                    $query = substr($query, 0, strlen($query)-1);
                    $this->db->query(
                        $query,
                        $values,
                        DBPlugin::SQL_QUERY_MANIP
                    );
                }
                $this->tpl->assign('fmbTagAssignOk', true);
            }
            
            if (!isset($assignErr)) {
                $postTags = (
                    $this->db->query(
                        'SELECT tag_id '.
                        'FROM ogsmk_blog_tags_rel '.
                        'WHERE post_id = ?',
                        array($_POST['id']),
                        DBPlugin::SQL_QUERY_ALL
                    )
                ) ? $this->db->getSQLResult() : array();
                $postTagsStack = array();
                foreach ($postTags as $tag)
                    array_push($postTagsStack, $tag['tag_id']);
                $this->tpl->assign('fmbPost', $this->getPosts($_POST['id']));
                $this->tpl->assign('fmbPostTags', $postTagsStack);
                $this->tpl->assign('fmbTags', $this->getTags(-1));
                $this->tpl->display($this->style.'/blog/admin/fmb.tagPost.tpl');
                return;
            }
          }
        $this->tpl->assign('fmbPosts', $this->getPosts(-1));
        $this->tpl->display($this->style.'/blog/admin/fmb.assignTag.tpl');
    }

    /**
     * Select one or more posts.
     * @param id If &lt; 0 Select all posts,
     *           else select post with given
     *           id.
     */
    private function getPosts($selection)
    {
        if ($selection < 0) {
            return (
                $this->db->query(
                    'SELECT post_id, post_title, post_time '.
                    'FROM ogsmk_blog_posts '.
                    'ORDER BY post_time DESC',
                    array(),
                    DBPlugin::SQL_QUERY_ALL
                )
            ) ? $this->db->getSQLResult() : array();
        } else {
            return (
                $this->db->query(
                    'SELECT * '.
                    'FROM ogsmk_blog_posts '.
                    'WHERE post_id = ?',
                    array($selection),
                    DBPlugin::SQL_QUERY_FIRST
                )
            ) ? $this->db->getSQLResult() : array();
        }
    }

    /**
     * Check adding or updating a post.
     * @param update Wether we are updating a post
     *               rather than adding one.
     * @return  1 : Missing parameters.
     *          2 : Added/Updated with success.
     *          3 : Invalid time or date.
     *         -1 : Failed to add/update.
     */
    private function checkPostAdd($update)
    {
        if (empty($_POST['title'])
            || empty($_POST['body'])
            || empty($_POST['year'])
            || empty($_POST['month'])
            || empty($_POST['day'])
            || empty($_POST['h'])
            || empty($_POST['m'])
            || empty($_POST['s'])
            || !isset($_POST['cat'])
            || ($_POST['cat']=='-1')
           ) {
            // Missing parameters
            return 1;
        } else if (!is_numeric($_POST['h'])
                   || !is_numeric($_POST['m'])
                   || !is_numeric($_POST['s'])
                   || !is_numeric($_POST['month'])
                   || !is_numeric($_POST['day'])
                   || !is_numeric($_POST['year'])
                   || !$this->checktime($_POST['h'], $_POST['m'], $_POST['s']) 
                   || !checkdate($_POST['month'], $_POST['day'], $_POST['year'])
                  ) {
            // Invalid date or hour
            return 3;
        } else {

            $title = $_POST['title'];
            $body = $_POST['body'];
            $more = $_POST['more'];
            $date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'].' ';
            $date .= $_POST['h'].':'.$_POST['m'].':'.$_POST['s'];
            $closed = (isset($_POST['closed']) && ($_POST['closed'])) ? 't' : 'f';
            $draft = (isset($_POST['draft']) && ($_POST['draft'])) ? 't' : 'f';
            $category = $_POST['cat'];
            $userID = User::getUserID();
            $postID = $_POST['id'];

            if ($update) {
                // Updating a category.
                return (
                    $this->db->query(
                        'UPDATE ogsmk_blog_posts ' .
                        'SET post_title = ?, post_body = ? ,' .
                        'post_more = ?, post_time = ?,' .
                        'post_closed = ?, post_draft = ?,' .
                        'post_cat = ?, post_mem = ?'.
                        'WHERE post_id = ?',
                        array($title,
                              $body,
                              $more,
                              $date,
                              $closed,
                              $draft,
                              $category,
                              $userID,
                              $postID),
                        DBPlugin::SQL_QUERY_MANIP
                    )
                ) ? 2 : -1;
            } else {
                // Adding a category.
                return (
                    $this->db->query(
                        'INSERT INTO ogsmk_blog_posts ' .
                        '(post_title, post_body, ' .
                        ' post_more, post_time, ' .
                        ' post_closed, post_draft, ' .
                        ' post_cat, post_mem) VALUES '.
                        '(?, ?, ?, ?, ?, ?, ?, ?)',
                        array($title,
                              $body,
                              $more,
                              $date,
                              $closed,
                              $draft,
                              $category,
                              $userID),
                        DBPlugin::SQL_QUERY_MANIP
                    )
                ) ? 2 : -1;
            }
        }
    }

    /**
     * 
     */
    private function checktime($hours, $minutes, $seconds)
    {
        return (
            ($hours > -1) && ($hours < 24) &&
            ($minutes > -1) && ($minutes < 60) &&
            ($seconds > -1) && ($seconds < 60)
        );
    }

}
?>
