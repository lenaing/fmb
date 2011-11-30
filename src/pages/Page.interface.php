<?php
/**
 * Page.interface.php file.
 * This file contains the sourcecode of the Page interface, which all FMB 
 * pages inherits.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Pages;

/**
 * Page interface.
 * This is the Page interface, which all FMB pages inherits.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
interface PageInterface
{

    /**
     * Print HTML Header with given page title.
     * May redirect to somewhere else.
     * @access public
     * @param string pageTitle Title of the page.
     * @param string redirectURL URL to redirect to.
     */
    public function printHTMLHeader($pageTitle = NULL, $redirectURL = NULL);

    /**
     * Print HTML footer.
     * @access public
     */
    public function printHTMLFooter();

    /**
     * Print FMB header with given page title.
     * @access public
     * @param page_title Title of the page.
     */
    public function printHeader($pageTitle);

    /**
     * Print FMB footer.
     * @access public
     */
    public function printFooter();

}
?>
