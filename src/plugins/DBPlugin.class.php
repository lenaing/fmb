<?php
/**
 * DBPlugin.class.php file.
 * This file contains the sourcecode of the abstract DBPlugin class.
 * Every FMB database plugin should extends this class.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Plugins;
use FMB\Core\Core;
use FMB\Plugins\Plugin;
use FMB\Plugins\DBPluginInterface;

// Loading required files.
Core::loadFile('src/plugins/Plugin.class.php', true);
Core::loadFile('src/plugins/DBPlugin.interface.php', true);

/**
 * DBPlugin abstract class.
 * This file contains DBPlugin abstract class.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 * @abstract
 */
abstract class DBPlugin extends Plugin implements DBPluginInterface
{
    /**
     * Insert, update or delete.
     */
    const SQL_QUERY_MANIP = 1;

    /**
     * Get all records.
     */
    const SQL_QUERY_ALL = 2;

    /**
     * Get only the first record.
     */
    const SQL_QUERY_FIRST = 3;

    /*
     * Database handle.
     * @var object
     * @access private
     */
    private $_db = NULL;

    /*
     * Last database error.
     * @var string
     * @access private
     */
    private $_error = NULL;

    /*
     * Last database result.
     * @var array
     * @access private
     */
    private $_result = NULL;

    /**
     * Total performed SQL queries.
     * @var int
     * @access protected
     */
    protected static $sqlQueries = 0;

    public final function __construct()
    {
        parent::__construct('database');
    }
}
?>
