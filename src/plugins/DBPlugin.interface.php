<?php
/**
 * DBPlugin.interface.php file.
 * This file contains the sourcecode of the DBPlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
namespace FMB\Plugins;

/**
 * DBPlugin interface.
 * This file contains the DBPlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1a
 */
interface DBPluginInterface
{
    /**
     * Query the database.
     * Put the query result in $_result. Get it with getSQLResult().
     * Set error in $_error if an error happened. Get it with getSQLError().
     * @param string $query SQL query string.
     * @param array $values SQL query values.
     * @param string $type SQL query type.
     * @return bool <b>true</b> if the query succeeded, <b>false</b> otherwise.
     * @see DBPlugin:SQL_QUERY_FIRST
     * @see DBPlugin:SQL_QUERY_ALL
     * @see DBPlugin:SQL_QUERY_MANIP
     * @see $result
     */
    public function query($query, $values, $type);

    /**
     * Get last SQL query result.
     * @return array Last SQL query result or <b>NULL</b> if an error happened.
     */
    public function getSQLResult();

    /**
     * Get last SQL query error string.
     * @return string Last SQL query error string or empty if no error happened.
     */
    public function getSQLError();

    /**
     * Get current count of SQL queries executed on database.
     * @return int Count of SQL queries.
     */
    public function getSQLQueriesCount();

    /**
     * Get SQL string for given columns and search string.
     * @param string $queryableCols Queryable columns.
     * @param string $searchString Search string.
     * @return string SQL search string for these columns and search string.
     */
    public function getSQLSearchString($queryableCols, $searchString);
}

?>
