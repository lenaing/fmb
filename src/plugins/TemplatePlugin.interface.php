<?php
/**
 * TemplatePlugin.interface.php file.
 * This file contains the sourcecode of the TemplatePlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Plugins;

/**
 * TemplatePlugin interface.
 * This file contains the TemplatePlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
interface TemplatePluginInterface
{
    /**
     * Assign values to the template.
     * @param string $varname Variable to assign;
     * @param mixed $var Value to assign.
     */
    public function assign($varname, $var);

    /**
     * Displays a template.
     * @param string $ |object $template The resource handle of the template
     *                                   file or template object.
     * @param mixed $cacheID Cache ID to be used with this template.
     * @param mixed $compileID Compile ID to be used with this template.
     */
    public function display($template, $cacheID, $compileID);

    /**
     * Fetches a rendered template.
     * @param string $ |object $template The resource handle of the template
     *                                   file or template object.
     * @param mixed $cacheID Cache ID to be used with this template.
     * @param mixed $compileID Compile ID to be used with this template.
     * @param bool $display Flag to display fetched template or not.
     * @return string Rendered template output.
     */
    public function fetch($template, $cacheID, $compileID, $display);
}

?>
