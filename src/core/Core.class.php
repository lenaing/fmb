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
 * Core.class.php file.
 * This file contains the sourcecode of the Core class, which is the heart of
 * the FMB project.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Core;

/**
 * Core class.
 * This file contains the heart of the FMB project.
 * It can load files and act as a main factory to create objects from a given
 * class file.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 * @abstract
 */
abstract class Core
{
    /**
     * @var int Point in time of FMB.
     * @access private
     * @static
     */
    private static $_time;

    private static $_int_time;

    /**
     * Set FMB's point in time.
     * Point in time is first set once this class is loaded.
     * @access public
     * @static
     */
    public static function setTime()
    {
        $time = explode(' ', microtime());
        self::$_time = $time[1] + $time[0];
    }

    /**
     * Get elapsed time since FMB's last point in time.
     * @access public
     * @static
     * @return int Elapsed time since FMB's last point in time.
     */
    public static function getTime()
    {
        $time = explode(' ', microtime());
        return (($time[1] + $time[0]) - (self::$_time));
    }

    public static function setIntTime()
    {
        $time = explode(' ', microtime());
        self::$_int_time = $time[1] + $time[0];
    }

    public static function getIntTime()
    {
        $time = explode(' ', microtime());
        return (($time[1] + $time[0]) - (self::$_int_time));
    }

    /**
     * Check if debug is enabled.
     * @access public
     * @static
     * @return bool <b>true</b> if debug is enabled, <b>false</b> otherwise.
     */
    public static function isDebugging()
    {
        global $fmbConf;
        return (isset($fmbConf['debug']) && (true === $fmbConf['debug']));
    }

    /**
     * Output debug message if debug is enabled.
     * If an array of values is given, the message will be formatted with these
     * values via {@link vsprintf vsprintf}.
     * @access public
     * @static
     * @param string $message Message format string.
     * @param array $values Array of arguments.
     * @uses vsprintf
     */
    public static function debug($message, $values = NULL)
    {
        if (self::isDebugging()) {
            if (NULL != $values && is_array($values)) {
                $output = vsprintf($message, $values);
            } else {
                $output = $message;
            }
            print '<b>[FMB]</b> '.$output.'<br/>';
        }
    }

    /**
     * Load a file from given filename into current context.
     * Path start from FMB_PATH.
     * @access public
     * @static
     * @param string $classfile Relative path to the file from {@link FMB_PATH}.
     * @param bool $critical If <b>true</b> will crash if it fails to load the
     *                       file.
     * @return bool     <b>true</b> if file is successfully loaded,
     *                  <b>false</b> otherwise.
     * @see FMB_PATH
     */
    public static function loadFile($filename, $critical = false)
    {
        if (!include_once(FMB_PATH.$filename)) {

            if (self::isDebugging()) {
                $debug = debug_backtrace();
                $caller = basename($debug[0]['file']);
                $msg = _('Failed to load file \'%s\' requested in file '
                     . '\'%s\'.');
                $val = array($filename, $caller);
                self::debug($msg, $val);
            }

            if (true === $critical) {
                $msg = _('<b>[FMB Critical failure]</b> '
                     . 'J\'ai not&eacute; ton nom, tu vas roter du sang : '
                     . 'd&eacute;fense de rire et d&eacute;fense de pleurer! '
                     . 'Je vais te mettre au pas moi, je vais te dresser !');
                die($msg);
            }
            return false;
        }
        return true;
    }

    /**
     * Load a class from given filename and return an instance of this class.
     * Class file filename must use the following scheme so that the Core can
     * find the name of the class to instantiate : 
     * - <i>classname</i>.whatever.you.want.php
     * 
     * For example to instantiate class <i>'SergeantHartman'</i>, you must have
     * the following filename :
     * - <i>SergeantHartman</i>.class.php
     * @access public
     * @static
     * @param string $classFile Path to the class file.
     * @param bool $critical If <b>true</b>, FMB will crash if it fails to load 
     *                       or instantiate class.
     * @return class|bool    Newly instantiated object of given class or 
     *                       <b>false</b> if failed to load class file or
     *                       instantiate class.
     */
    public static function factory($classFile, $critical = true)
    {
        if (include_once($classFile)) {
            $tokens = explode('.',basename($classFile));
            $className = $tokens[0];

            if (class_exists($className)) {
                return new $className;
            }

            if (self::isDebugging()) {
                $msg = _('Failed to instanciate class \'%s\'.');
                $val = array($className);
                self::debug($msg, $val);
            }

            if (true === $critical) {
                $msg = _('<b>[FMB Critical failure]</b> '
                     . 'Fini la branlette, &agrave; vos chaussettes!');
                die($msg);
            }
        } else {
            if (self::isDebugging()) {
                $msg = _('Failed to load class file \'%s\'.');
                $val = array($classFile);
                self::debug($msg, $val);
            }

            if (true === $critical) {
                $msg = _('<b>[FMB Critical failure]</b> '
                     . 'Trop beaucoup, trop trop beaucoup!');
                die($msg);
            }
        }
        return false;
    }

    /**
     * Check this FMB version against a given one.
     * @access public
     * @static
     * @param string $versionStr A version string.
     * @return bool    <b>true</b> if {@link FMB_VERSION} is greater or equal to
     *                 the given one, <b>false</b> otherwise.
     * @see FMB_VERSION
     * @see isVersionString
     */
    public static function checkFMBVersion($versionStr)
    {
        return self::compareVersionTo(FMB_VERSION, $versionStr);
    }

    /**
     * Check this server {@link phpversion PHP version} against a given one.
     * @access public
     * @static
     * @param string $versionStr A version string.
     * @return bool    <b>true</b> if {@link phpversion PHP version} is greater
     *                 or equal to the given one, <b>false</b> otherwise.
     * @see phpversion
     * @see isVersionString
     */
    public static function checkPHPVersion($versionStr)
    {
        $phpversion = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'
                    . PHP_RELEASE_VERSION;
        return self::compareVersionTo($phpversion, $versionStr);
    }

    /**
     * Compare two version strings.
     * @access public
     * @static
     * @param string $version1 Version string.
     * @param string $version2 Version string.
     * @return bool <b>true</b> if $version1 is greater or equal to $version2,
     *              <b>false</b> otherwise or if one of the version provided is
     *              not a version string.
     * @see isVersionString
     */
    public static function compareVersionTo($version1, $version2)
    {
        if (!self::isVersionString($version1)) {
            if (self::isDebugging()) {
                $msg = _('Invalid version string \'%s\' as first argument for '
                     . '\'%s\'.');
                $val = array($version1, __CLASS__.'::'.__FUNCTION__);
                Core::debug($msg, $val);
            }
            return false;
        }

        if (!self::isVersionString($version2)) {
            if (self::isDebugging()) {
                $msg = _('Invalid version string \'%s\' as second argument for '
                     . '\'%s\'.');
                $val = array($version1, __CLASS__.'::'.__FUNCTION__);
                Core::debug($msg, $val);
            }
            return false;
        }

        $version1A = self::versionToArray($version1);
        $version2A = self::versionToArray($version2);

        $majorA = intval($version1A['major']);
        $minorA = intval($version1A['minor']);
        $revisionA = intval($version1A['revision']);
        $kindA = $version1A['kind'];
        $bugfixA = intval($version1A['bugfix']);
        
        $majorB = intval($version2A['major']);
        $minorB = intval($version2A['minor']);
        $revisionB = intval($version2A['revision']);
        $kindB = $version2A['kind'];
        $bugfixB = intval($version2A['bugfix']);

        // Let's compare if you dare!
        if ($majorA < $majorB) {
            return false;
        }
        if ($majorA == $majorB) {
            if ($minorA < $minorB) {
                return false;
            }
            if ($minorA == $minorB) {
                if ($revisionA < $revisionB) {
                    return false;
                }
                if ($revisionA == $revisionB) {
                    $comp = strcmp(strtolower($kindA),strtolower($kindB));
                    if ($comp < 0) {
                        return false;
                    }
                    if ($comp == 0) {
                        if ($bugfixA < $bugfixB) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Convert a version string to an array of version components.
     * @access private
     * @static
     * @param string $versionStr A version string.
     * @return array A normalized array with the version components.
     * @see isVersionString
     */
    private static function versionToArray($versionStr) {
        $major = 0;
        $minor = 0;
        $revision = 0;
        $kind = '';
        $bugfix = 0;
        $regexp = '/^(?:(\d+)\.)?(?:(\d+)\.)?(\d+)(?:(a|A|b|B|rc|RC)(\d+)?)?$/';
        $matches = array();
        preg_match($regexp, $versionStr, $matches);

        if (!empty($matches)) {
            switch (count($matches)-1) {
                case 1 : {
                    $major = $matches[1];
                    break;
                }
                case 3 : {
                    $major = $matches[1];
                    if ($matches[2] != '') {
                        $minor = $matches[2];
                        $revision = $matches[3];
                    } else {
                        $minor = $matches[3];
                    }
                    break;
                }
                case 4 : {
                    $major = $matches[1];
                    $minor = $matches[2];
                    $revision = $matches[3];
                    $kind = $matches[4];
                    break;
                }
                case 5 : {
                    $major = $matches[1];
                    $minor = $matches[2];
                    $revision = $matches[3];
                    $kind = $matches[4];
                    $bugfix = $matches[5];
                    break;
                }
                default:
                    break;
            }
        }

        return array('major' => $major,
                     'minor' => $minor,
                     'revision' => $revision,
                     'kind' => $kind,
                     'bugfix' => $bugfix);
    }

    /**
     * Check a version string.
     * A version string follows the 'a.b.cXy' format where :
     * - a is the major version number.
     * - b is the minor version number.
     * - c is the release version number.
     * - X is the kind of version (Alpha, Beta, Release Candidate)
     * - y is the bugfix version number.
     * @access public
     * @static
     * @param string $versionStr Version string to check.
     * @return bool    <b>true</b> if given string is a version string,
     *                 <b>false</b> otherwise.
     */
    public static function isVersionString($versionStr) {
        $regexp = '/^(?:(\d+)\.)?(?:(\d+)\.)?(\d+)(?:(a|A|b|B|rc|RC)(\d+)?)?$/';
        $matches = array();
        preg_match($regexp, $versionStr, $matches);
        return (!empty($matches));
    }
}

Core::setTime();
?>
