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
 * User.class.php file.
 * This file contains the sourcecode of the User abstract class.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Core;

/**
 * User abstract class.
 * This class is used to get information about the current connected user.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 * @abstract
 */
abstract class User
{
    /**
     * Check if user is logged in.
     * @access public
     * @static
     * @return bool <code>true</code> if user is logged in,
     *              <code>false</code> otherwise.
     */
    public static function isLogged()
    {
        return (
                !empty($_SESSION['usrLogin'])
                &&
                isset($_SESSION['usrRights'])
        );
    }

    /**
     * Check if user is admin.
     * @access public
     * @static
     * @return bool <code>true</code> if user is admin,
     *              <code>false</code> otherwise.
     */
    public static function isAdmin()
    {
        return (
                isset($_SESSION['usrRights'])
                &&
                ($_SESSION['usrRights'] == 1)
        );
    }

    /**
     * Retrieve user login.
     * @access public
     * @static
     * @return string Current user login or an empty string if not logged in.
     */
    public static function getUserLogin()
    {
        return (isset($_SESSION['usrLogin']))
                ? $_SESSION['usrLogin']
                : '';
    }

    /**
     * Retrieve user ID.
     * @access public
     * @static
     * @return int Current user ID or -1 if not logged in.
     */
    public static function getUserID()
    {
        return (isset($_SESSION['usrID']))
                ? $_SESSION['usrID']
                : -1;
    }
}
?>
