<?php
/**
 * Singleton.class.php file.
 * This file contains the sourcecode of the Singleton abstract class, which is
 * an implementation of the Singleton pattern.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Core;

/**
 * Singleton abstract class.
 * This class is an implementation of the Singleton pattern.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 * @abstract
 */
abstract class Singleton
{
    /**
     * @var array Array of singleton instances.
     * @access private
     * @static
     */
    private static $_instances = array();

    /**
     * Prevent direct object creation.
     * Instantiation of object by others classes violates the Singleton design
     * pattern.
     * @final
     * @access private
     */
    final private function __construct()
    {}

    /**
     * Prevent instance cloning.
     * Cloning of a singleton instance is forbidden because it can be used to
     * create a copy of the instance which violates the Singleton design 
     * pattern's objective.
     * @final
     * @access public
     */
    final public function __clone()
    {
        $msg = _('Cloning of singleton class \'%s\' is forbidden.');
        $val = array(get_called_class());
        Core::debug($msg, $val);
    }

    /**
     * Gets an instance of the calling class.
     * Create and return a new instance if no current instance of calling class
     * is found.
     * @access public
     * @static
     * @return class Current instance of calling class or a newly created one.
     */
    public static function getInstance()
    {
        $calledClassName = get_called_class();

        if (!isset(self::$_instances[$calledClassName])) {
            self::$_instances[$calledClassName] = new $calledClassName();
        }

        return self::$_instances[$calledClassName];
    }
}
?>
