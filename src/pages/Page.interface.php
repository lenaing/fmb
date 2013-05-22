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
 * Page.interface.php file.
 * This file contains the sourcecode of the Page interface, which all FMB 
 * pages inherits.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Pages;

/**
 * Page interface.
 * This is the Page interface, which all FMB pages inherits.
 * @package FMB
 * @subpackage Pages
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
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
