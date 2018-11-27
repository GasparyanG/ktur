<?php
namespace DataBase\Interfaces;

/**
 * Selects column(s) from table by specifyied statement and returns either row or rows or false
 * @see DataBase\Interfaces\DBManipulatorInterface
 */
interface ReaderInterface
{
	/**
	* @see DataBase\Interfaces\CreaterInterface
	*/
	public function read($statement, $flag);


	/**
	* $flag "O" => 'One'
	*
	* @return assoc_array|false
	*/
	public function readOne($statement);

	/**
	* $flag "A" => 'All' 
	*
	* @return array with assoc_arrays(neasted)
	*/
	public function readAll($statement);
}