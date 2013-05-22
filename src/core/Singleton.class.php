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
 * Singleton.class.php file.
 * This file contains the sourcecode of the Singleton abstract class, which is
 * an implementation of the Singleton pattern.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Core;

/**
 * Singleton abstract class.
 * This class is an implementation of the Singleton pattern.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
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
