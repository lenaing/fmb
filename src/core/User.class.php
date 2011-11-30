<?php
/**
 * User.class.php file.
 * This file contains the sourcecode of the User abstract class.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Core;

/**
 * User abstract class.
 * This class is used to get information about the current connected user.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
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
