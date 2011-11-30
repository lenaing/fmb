<?php
/**
 * Plugin.interface.php file.
 * This file contains the sourcecode of the Plugin interface, which all FMB 
 * plugins inherits.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Plugins;

/**
 * Plugin interface.
 * This is the Plugin interface, which all FMB plugins inherits.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
interface PluginInterface
{
    /**
     * Initialize the plugin.
     * @access public
     * @return bool <b>true</b> if plugin is correctly initialized, <b>false</b>
     *              otherwise.
     */
    public function init();
    
    /**
     * Get plugin's infos.
     * @access public
     * @return array Array of this plugin's infos.
     */
    public function getInfos();

    /**
     * Set plugin's version.
     * @access public
     * @param string $version Plugin's version.
     */
    public function setVersion($version);

    /**
     * Set plugin's summary.
     * @access public
     * @param string $summary Plugin's summary.
     */
    public function setSummary($summary);

    /**
     * Set plugin's details.
     * @access public
     * @param string $details Plugin's details.
     */
    public function setDetails($details);

    /**
     * Set plugin's required FMB version.
     * @access public
     * @param string $requiredVersion Plugin's required FMB version.
     */
    public function setRequiredFMBVersion($requiredVersion);

    /**
     * Set plugin's required PHP version.
     * @access public
     * @param string $requiredVersion Plugin's required PHP version.
     */
    public function setRequiredPHPVersion($requiredVersion);
}
?>
