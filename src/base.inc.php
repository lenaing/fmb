<?php
// WARNING /!\ DO NOT EDIT NOR MOVE THIS FILE! You've been warned! -------------

/**
 * base.inc.php file.
 * This file contains the minimum process to start up FMB and therefore should
 * be included by every FMB modules.
 * @package FMB
 * @subpackage Core
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
use FMB\Core\Core;
use FMB\Plugins\PluginEngine;

session_start();
/**
 * TODO : Document define
 * @var string FMB path.
 */
$dirname = substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__),'/'));
define('FMB_PATH', $dirname.'/');

/**
 * TODO : Document define
 * @var string FMB version.
 */
define('FMB_VERSION', '0.1a');

require_once(FMB_PATH.'config/config.inc.php');
require_once(FMB_PATH.'src/core/Core.class.php');
Core::loadFile('src/inc/i18n.inc.php');
Core::loadFile('src/core/Singleton.class.php', true);
Core::loadFile('src/core/User.class.php', true);
Core::loadFile('src/plugins/PluginEngine.class.php', true);

$fmbPluginEngine = PluginEngine::getInstance();
$fmbPluginEngine->loadPlugins();
?>
