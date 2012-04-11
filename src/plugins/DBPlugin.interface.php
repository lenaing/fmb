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
 * DBPlugin.interface.php file.
 * This file contains the sourcecode of the DBPlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
 */
namespace FMB\Plugins;

/**
 * DBPlugin interface.
 * This file contains the DBPlugin interface.
 * @package FMB
 * @subpackage Plugins
 * @author Lenain <lenaing@gmail.com>
 * @version 0.1b
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

    /**
     * Get SQL interval string for given epoch period.
     * @param string $startEpoch Epoch period start.
     * @param string $endEpoch Epoch period end.
     * @return string SQL interval string for the given epoch period.
     */
    public function getSQLIntervalString($startEpoch, $endEpoch);

    /**
     * Get SQL extract string for given element and column.
     * @param string $what Element to extract.
     * @param string $column Column from which we extract the element.
     * @return string SQL extract string for given element and column.
     */
    public function getSQLExtractString($what, $column);

    /**
     * Get boolean value from given SQL boolean.
     * @param string $SQLBoolean SQL boolean value.
     * @return boolean Boolean value of given SQL boolean.
     */
    public function getBooleanValueFromSQL($SQLBoolean);
}

?>
