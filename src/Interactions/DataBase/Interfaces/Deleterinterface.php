<?php
namespace DataBase\Interfaces;

/**
* Deletes row(s) by specifyied statement (e.g. "DELETE any_number as row index FROM table")
* @see DataBase\Interfaces\DBManipulatorInterface
*/
interface Deleterinterface
{
	/**
	* @see DataBase\Interfaces\CreaterInterface
	*/
	public function delete($statement, $flag);

	/**
	* $flag "R" => 'row'
	* @return true|false
	*/
	public function deleteRow($statement);
}