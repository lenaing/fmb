<?php
/**
 * TemplatePlugin.class.php file.
 * This file contains the sourcecode of the abstract TemplatePlugin class.
 * Every FMB template plugin should extends this class.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Plugins;
use FMB\Core\Core;
use FMB\Plugins\Plugin;
use FMB\Plugins\TemplatePluginInterface;

// Loading required files.
Core::loadFile('src/plugins/Plugin.class.php', true);
Core::loadFile('src/plugins/TemplatePlugin.interface.php', true);

/**
 * TemplatePlugin abstract class.
 * This file contains the TemplatePlugin abstract class.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 * @abstract
 */
abstract class TemplatePlugin extends Plugin implements TemplatePluginInterface
{

    public final function __construct()
    {
        parent::__construct('template');
    }

}
?>
