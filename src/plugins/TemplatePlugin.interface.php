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
 * TemplatePlugin.interface.php file.
 * This file contains the sourcecode of the TemplatePlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Plugins;

/**
 * TemplatePlugin interface.
 * This file contains the TemplatePlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
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
