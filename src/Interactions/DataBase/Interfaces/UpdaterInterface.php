<?php
namespace DataBase\Interfaces;

/**
* Updatese row(s) by specifed $statement
* @see DataBase\Interfaces\DBManipulatorInterface
*/
interface UpdaterInterface
{
	/**
	* @see DataBase\Interfaces\CreaterInterface
	*/
	public function update($statement, $flag);

	/**
	* $flag "R" => 'Row'
	* 
	* @return ture|false 
	*/
	public function updateRow($statement);
}