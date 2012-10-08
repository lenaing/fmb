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
 * PluginEngine.class.php file.
 * This file contains the sourcecode of the PluginEngine class, which handle
 * plugin managment in FMB.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Plugins;
use FMB\Core\Core;
use FMB\Core\Singleton;

/**
 * PluginEngine class.
 * This class handle plugin managment in FMB.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
class PluginEngine extends Singleton
{
    /**
     * @var array Array of loaded plugins.
     * @access private
     * @static
     */
    private static $_plugins = array();

    /**
     * @var array Array of loaded hooks.
     * @access private
     * @static
     */
    private static $_pluginsHooks = array();

    /**
     * Load plugin Class from the given class file.
     * There can be only one plugin of type 'database' or 'template' to prevent
     * race conditions.
     * @access private
     * @param string $name Plugin name.
     * @param string $file Class file containing the plugin class.
     * @param string $type Type of the plugin ('database', 'template', ...)
     * @return bool <b>true</b> if plugin is successfully loaded, <b>false</b>
     *              otherwise.
     */
    private function loadPlugin($name, $file, $type)
    {
        if (Core::isDebugging()) {
            $msg = _('Loading plugin : \'%s\'.');
            $val = array($name);
            Core::debug($msg, $val);
        }

        // Check for unique plugins.
        switch ($type) {
            case 'database' : 
            case 'template' : {
                if (isset(self::$_plugins["$type"])
                    && is_array(self::$_plugins["$type"][0])) {

                    if (Core::isDebugging()) {
                        $msg = _('Only one \'%s\' plugin can be loaded.');
                        $val = array($type);
                        Core::debug($msg, $val);
                    }

                    return false;
                }
            } break;
            default :
                        break;
        }

        // Create plugin instance.
        $instance = Core::factory($file, false);
        if (false === $instance) {
            if (Core::isDebugging()) {
                $msg = _('Failed to load \'%s\' plugin \'%s\'.');
                $val = array($type, $name);
                Core::debug($msg, $val);
            }
            return false;
        }

        // Try to initialize plugin.
        if (false === $instance->init()) {
            if (Core::isDebugging()) {
                $msg = _('Failed to init \'%s\' plugin \'%s\'.');
                $val = array($type, $name);
                Core::debug($msg, $val);
            }
            return false;
        }

        // Check required version of FMB for plugin
        $fmbRequired = $this->checkPluginRequiredFMBVersion($instance);
        if ('' != $fmbRequired){
            if (Core::isDebugging()) {
                $msg = _('Plugin \'%s\' needs at least version \'%s\' of FMB.');
                $val = array($name, $fmbRequired);
                Core::debug($msg, $val);
            }
            return false;
        }

        // Check required version of PHP for plugin
        $fmbRequired = $this->checkPluginRequiredPHPVersion($instance);
        if ('' != $fmbRequired){
            if (Core::isDebugging()) {
                $msg = _('Plugin \'%s\' needs at least version \'%s\' of PHP.');
                $val = array($name, $fmbRequired);
                Core::debug($msg, $val);
            }
            return false;
        }

        // Create array if no plugin of this kind is registered.
        if (!isset(self::$_plugins["$type"]))
            self::$_plugins["$type"] = array();

        // Register plugin.
        $plugin = array('name' => $name, 'instance' => $instance);
        if (! in_array($plugin, self::$_plugins["$type"])) {
            array_push(self::$_plugins["$type"], $plugin);
        }  elseif (Core::isDebugging()) {
            $msg = _('Plugin \'%s\' already loaded.');
            $val = array($name);
            Core::debug($msg, $val);
        }
        return true;
    }

    /**
     * Load every enabled plugins.
     * Dies if no database or no template plugin is set.
     * @access public
     */
    public function loadPlugins()
    {
        global $fmbConf;

        // Get plugins path
        $pluginsPath = FMB_PATH.'plugins/';

        // Load every enabled plugins.
        foreach ($fmbConf['plugins'] as $pluginType => $plugins) {
            foreach ($plugins as $plugin) {
                $file = $pluginsPath.$plugin.'/'.$plugin.'.plugin.php';
                $this->loadPlugin($plugin, $file, $pluginType);
            }
        }
        
        // Check that required plugins are up and running
        if (!isset(self::$_plugins['database'])
            || !isset(self::$_plugins['template'])) {
            $msg = _('<b>[FMB Critical failure]</b> '
                 . 'T\'as une gueule de guerrier ? Aaaaarrrrrrrhhh ! '
                 . '&Ccedil;a c\'est une gueule de guerrier ! '
                 . 'L&agrave, fais-moi voir ta gueule de guerrier !');
            die($msg);
        }
    }

    /**
     * Get plugin instance of given name.
     * @access public
     * @param string $pluginName Plugin instance name.
     * @return class Plugin instance if found, <b>NULL</b> otherwise.
     */
    public function getPlugin($pluginName)
    {
        // Will only allow unique plugin name, as this return first plugin
        // with according name without checking plugin type.
        // Anyway, there can be only one plugin with the same class name...
        foreach (self::$_plugins as $pluginType => $plugins) {
            foreach ($plugins as $plugin) {
                if ($plugin['name'] == $pluginName) {
                    return $plugin['instance'];
                }
            }
        }
        return NULL;
    }

    /**
     * Get all loaded plugins.
     * @access public
     * @return array Array of loaded plugins.
     */
    public function getPlugins()
    {
        return self::$_plugins;
    }

    /**
     * 
     */
    public function existPluginOfType($type)
    {
        return (count(self::$_plugins[$type]) > 0);
    }

    /**
     * Get loaded template plugin.
     * @access public
     * @return class Instance of template plugin.
     */
    public function getTemplatePlugin()
    {
        return self::$_plugins['template'][0]['instance'];
    }

    /**
     * Get loaded database plugin.
     * @access public
     * @return class Instance of database plugin.
     */
    public function getDatabasePlugin()
    {
        return self::$_plugins['database'][0]['instance'];
    }

    /**
     * Set a plugin and method for a given hook.
     * @access public
     * @param string $hookName Name of the hook.
     * @param string $pluginName Name of the plugin which will execute the hook.
     * @param string $methodName Name of the method which will be called.
     * @return bool <b>true</b> if correctly hooked, <b>false</b> otherwise.
     */
    public function setHook($hookName, $pluginName, $methodName)
    {
        $result = false;

        // Create array if no plugin of this kind is registered.
        if (!isset(self::$_pluginsHooks["$hookName"]))
            self::$_pluginsHooks["$hookName"] = array();

        $hook = array('pluginName' => $pluginName,
                      'pluginMethod' => $methodName);

        // Add hook if inexistant.
        if (! in_array($hook, self::$_pluginsHooks["$hookName"])) {
            array_push(self::$_pluginsHooks["$hookName"], $hook);
            $result = true;

            if (Core::isDebugging()) {
                $msg = _('Hooked \'%s->%s\' for \'%s\'.');
                $val = array($pluginName, $methodName, $hookName);
                Core::debug($msg, $val);
            }
        } elseif (Core::isDebugging()) {
            $msg = _('\'%s->%s\' already hooked for \'%s\'.');
            $val = array($pluginName, $methodName, $hookName);
            Core::debug($msg, $val);
        }

        return $result;
    }

    /**
     * Execute given hook.
     * @access public
     * @param string $hookName Name of the hook to execute.
     */
    public function doHook($hookName)
    {
        if (isset(self::$_pluginsHooks["$hookName"])
                && is_array(self::$_pluginsHooks["$hookName"])) {

            foreach (self::$_pluginsHooks["$hookName"] as $hook) {

                $plugin = self::getPlugin($hook['pluginName']);
                if (NULL != $plugin) {
                    if (method_exists($plugin, $hook['pluginMethod'])) {
                        $plugin->$hook['pluginMethod'](func_get_args());
                    }
                }
            }
        }
    }

    /**
     * Execute given hook with eventual parameters and returns the last result.
     * @access public
     * @param string $hookName Name of the hook to execute.
     * @param array $parameters Parameters to pass to plugins methods.
     * @return string The last answer of all plugins to this hook.
     */
    public function doHookFunction($hookName, $parameters = NULL)
    {
        $result = NULL;

        if (isset(self::$_pluginsHooks["$hookName"])
                && is_array(self::$_pluginsHooks["$hookName"])) {

            foreach (self::$_pluginsHooks["$hookName"] as $hook) {

                $plugin = self::getPlugin($hook['pluginName']);
                if (NULL != $plugin) {
                    if (method_exists($plugin, $hook['pluginMethod'])) {
                        $result = $plugin->$hook['pluginMethod']($parameters);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Execute given hook with eventual parameters and concat every results
     * before returning them.
     * @access public
     * @param string $hookName Name of the hook to execute.
     * @param array $parameters Parameters to pass to plugins methods.
     * @return string The concatenated answers of all plugins to this hook.
     */
    public function doHookConcat($hookName, $parameters = NULL)
    {
        $result = '';

        if (isset(self::$_pluginsHooks["$hookName"])
                && is_array(self::$_pluginsHooks["$hookName"])) {

            /* Search for loaded plugins. */
            foreach (self::$_pluginsHooks["$hookName"] as $hook) {
                $plugin = self::getPlugin($hook['pluginName']);

                if (NULL != $plugin) {
                    if (method_exists($plugin, $hook['pluginMethod'])) {
                        $result .= $plugin->$hook['pluginMethod']($parameters);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Execute given hook with eventual parameters and concat every results
     * as booleans before returning them.
     * @access public
     * @param string $hookName Name of the hook to execute.
     * @param array $parameters Parameters to pass to plugins methods.
     * @return string The concatenated answers of all plugins to this hook.
     *                If a single answer is false, the result will be false.
     *                Otherwise the result will be true.
     */
    public function doHookConcatBoolean($hookName, $parameters = NULL)
    {
        $result = true;

        if (isset(self::$_pluginsHooks["$hookName"])
                && is_array(self::$_pluginsHooks["$hookName"])) {

            /* Search for loaded plugins. */
            foreach (self::$_pluginsHooks["$hookName"] as $hook) {
                $plugin = self::getPlugin($hook['pluginName']);

                if (NULL != $plugin) {
                    if (method_exists($plugin, $hook['pluginMethod'])) {
                        $result &= $plugin->$hook['pluginMethod']($parameters);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Check required FMB version for given plugin.
     * @access private
     * @param class $plugin Plugin instance.
     * @return string '' if the check is okay, the required version otherwise.
     */
    private function checkPluginRequiredFMBVersion($plugin)
    {
        $pluginInfos = $plugin->getInfos();
        $requiredVersion = $pluginInfos['requiredFMBVersion'];

        if (($requiredVersion == 'any')
            || Core::checkFMBVersion($requiredVersion)) {
            return '';
        }

        return $requiredVersion;
    }

    /**
     * Check required PHP version for given plugin.
     * @access private
     * @param class $plugin Plugin instance.
     * @return string '' if the check is okay, the required version otherwise.
     */
    private function checkPluginRequiredPHPVersion($plugin)
    {
        $pluginInfos = $plugin->getInfos();
        $requiredVersion = $pluginInfos['requiredPHPVersion'];

        if (($requiredVersion == 'any')
            || Core::checkPHPVersion($requiredVersion)) {
            return '';
        }

        return $requiredVersion;
    }
}
?>
