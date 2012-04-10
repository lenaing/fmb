<?php
// WARNING /!\ DO NOT EDIT NOR MOVE THIS FILE! You've been warned! -------------

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
 * base.inc.php file.
 * This file contains the minimum process to start up FMB and therefore should
 * be included by every FMB modules.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
use FMB\Core\Core;
use FMB\Plugins\PluginEngine;

session_start();
/**
 * FMB_PATH is the absolute path to the FMB main directory.
 * @var string FMB path.
 */
$dirname = substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), '/'));
define('FMB_PATH', $dirname.'/');

/**
 * FMB_VERSION is, ow... nevermind.
 * @var string FMB version.
 */
define('FMB_VERSION', '0.1b');

require_once(FMB_PATH.'config/config.inc.php');
require_once(FMB_PATH.'src/core/Core.class.php');
Core::loadFile('src/inc/i18n.inc.php');
Core::loadFile('src/core/Singleton.class.php', true);
Core::loadFile('src/core/User.class.php', true);
Core::loadFile('src/plugins/PluginEngine.class.php', true);

$fmbPluginEngine = PluginEngine::getInstance();
$fmbPluginEngine->loadPlugins();
?>
