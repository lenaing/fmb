<?php
/**
 * Plugin.class.php file.
 * This file contains the sourcecode of the abstract Plugin class, which is the
 * mother class of all FMB plugins.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
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
 * @version 0.1a
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
}
?>
