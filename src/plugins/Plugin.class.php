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
 * Plugin.class.php file.
 * This file contains the sourcecode of the abstract Plugin class, which is the
 * mother class of all FMB plugins.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Plugins;
use FMB\Core\Core;
use FMB\Plugins\PluginInterface;

// Loading required files.
Core::loadFile('src/plugins/Plugin.interface.php', true);

/**
 * Plugin class.
 * This class is the mother class of all FMB plugins.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 * @see PluginInterface
 * @abstract
 */
abstract class Plugin implements PluginInterface
{
    /**
     * @var string Plugin name.
     * @access private
     */
    private $_name;

    /**
     * @var string Plugin type.
     * @access private
     */
    private $_type;

    /**
     * @var string Plugin version.
     * @access private
     */
    private $_version;

    /**
     * @var string Plugin summary.
     * @access private
     */
    private $_summary;

    /**
     * @var string Plugin details.
     * @access private
     */
    private $_details;

    /**
     * @var string Plugin required FMB version.
     * @access private
     */
    private $_requiredFMBVersion;

    /**
     * @var string Plugin required PHP version.
     * @access private
     */
    private $_requiredPHPVersion;


    /**
     * Construct a plugin with default properties.
     * @param string $type Plugin type ('database', 'template', ...)
     */
    public function __construct($type='')
    {
        $this->_name = get_class($this);
        $this->_type = $type;
        $this->_version = _('Unknown version.');
        $this->_summary = _('No summary.');
        $this->_details = _('No details.');
        $this->_requiredFMBVersion = 'any';
        $this->_requiredPHPVersion = 'any';
    }

    // Plugin interface methods.------------------------------------------------
    public function getInfos() {
        return array('name' => $this->_name,
                     'type' => $this->_type,
                     'version' => $this->_version,
                     'summary' => $this->_summary,
                     'details' => $this->_details,
                     'requiredFMBVersion' => $this->_requiredFMBVersion,
                     'requiredPHPVersion' => $this->_requiredPHPVersion);
    }

    public function setVersion($version)
    {
        $this->_version = $version;
    }

    public function setSummary($summary)
    {
        $this->_summary = $summary;
    }

    public function setDetails($details)
    {
        $this->_details = $details;
    }

    public function setRequiredFMBVersion($requiredVersion)
    {
        if (($requiredVersion == 'any')
            || Core::isVersionString($requiredVersion)) {
            $this->_requiredFMBVersion = $requiredVersion;
        } elseif (Core::isDebugging()) {
            $msg = _('Tried to set invalid required FMB version \'%s\' for '
                 . 'plugin \'%s\'.');
            $val = array($requiredVersion, $this->_name);
            Core::debug($msg, $val);
        }
    }

    public function setRequiredPHPVersion($requiredVersion)
    {
        if (($requiredVersion == 'any')
            || Core::isVersionString($requiredVersion)) {
            $this->_requiredPHPVersion = $requiredVersion;
        } elseif (Core::isDebugging()) {
            $msg = _('Tried to set invalid required PHP version \'%s\' for '
                 . 'plugin \'%s\'.');
            $val = array($requiredVersion, $this->_name);
            Core::debug($msg, $val);
        }
    }

    public function getPluginUrl($id)
    {
        global $fmbConf;
        return $fmbConf['site']['url'].'plugins/'.$id.'/';
    }

    public function getPluginUri($id)
    {
        return FMB_PATH.'plugins/'.$id.'/';
    }
}
?>
