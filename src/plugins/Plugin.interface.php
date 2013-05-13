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
 * Plugin.interface.php file.
 * This file contains the sourcecode of the Plugin interface, which all FMB 
 * plugins inherits.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Plugins;

/**
 * Plugin interface.
 * This is the Plugin interface, which all FMB plugins inherits.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
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

    /**
     * Get the given Plugin's URL.
     * @access public
     * @param string $id Plugin's name.
     * @return Plugin's URL/
     */
    public function getPluginUrl($id);
}
?>
