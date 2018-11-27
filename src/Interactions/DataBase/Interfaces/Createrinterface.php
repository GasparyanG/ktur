<?php
namespace DataBase\Interfaces;

/**
* @see DataBase\Interfaces\DBManipulatorInterface
*/
interface Createrinterface
{
	/**
	 * call desired method by '$flag' param:
	 * flag_method property will be of associative array type, which will hold key=>value pair
	 * of flag => method and by specifying concreate falg defind in array then corresponding method will be returned!
	 * 
	 * Retunred method name will be called with parentheses.
	 *
	 * @param string
	 * @param string
	 */
	public function create($statement, $flag);


	/**
	 * creates table with specifyied statement (SQL syntax)
	 *
	 * $flag "T" => 'Table'
	 * 
	 * @param string $statement
	 *
	 * @return true|false
	 */
	public function createTable($statement);

	/**
	 * inserts data to row and returns insertedd row primary key if specified
	 *
	 * $flag "R" => 'Row'
	 *
	 * if PRIMARY_KEY is not defined in table then LAST_INSERT_ID will not retunr anything!
	 * 
	 * if (PRIMARY_KEY && everything is OK) {
	 * @return LAST_INSERT_ID()
	 * }
	 * else{
	 * @return false this is important to make app more maintainable (e.g. if sth gose wrong message about that to console)
	 * }
	 */
	public function insertRow($statement);

}