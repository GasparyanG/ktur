<?php
namespace DataBase\Interfaces;

/**
* @see Database\Interfaces\Creater, Reader, Updater, Deleter for more info
*
* All above mentioned interfaces' implementations takes for instantiation only one parameter
* - connection to database:
* 	this will let them to interact with database and not to define connection by itself!
* they are a components of DBManipulatorInterface
* 
* Way of working:
* 
* - there is one parameter which are common for them all; '$falg':
* - they all have flag=>mehtod pair associative array:
*		based on this two facts we can have desired implementation by only passing $statement and $flag parameters,
* 		which will be explaind in further reading
* - all keys in assoc array of flag=>method pair should be UPPERCASE!
*/

/**
 * Whole app will use instances of this interface to deal with data:
 * 
 * because of the fact that db need to be connected to interact with
 * its very clumsy to have db connection definition in every handler 
 * (i.e. CRUD participants with oop)
 *
 * This interface instances will HAVE all implementations (CRUD)
 * injected
 * 
 * implementations MUST:
 * 
 * - return 'false'  if sth goes wrong
 * - return 'null' if 'falg' isn't set
 * - methods of implementations MUST recieve SQL statements if there is need for that: 
 * 		 db implementations SHOULD NOT to do other 'stuff' except db related (e.g. fetch statement
 * 		 from object's method then pass that statement to corresponding function/method)
 * 
 * - (coming soon)
 *
 * Every implementation will make it possible to have different behavior with help of passed in flags!
 */

interface DBManipulatorInterface
{
	/**
	 * As this class is abstract (i.e. obeying to Bridge Pattern)
	 * actual implementations will be defind in component classe!
	 * 
	 * @see Database\Interfaces\Creater
	 * 
	 * @param string $statement SQL (MySQL) syntax
	 * @param string this will force corresponding object to call corresponding method
	 * 
	 * @return true|false|index (last_insert_index: insrtion is olso create's consern)
	 */
	public function create($statement, $flag);

	/**
	 * @see DBmanipulatorInterface::create
	 * @see Database\Interfaces\Reader
	 *
	 * @return array|assoc_array|false
	 */
	public function read($statement, $flag);

	/**
	 * @see Database\Interfaces\Updater
	 *
	 * @return true|false
	 */
	public function update($statement, $flag);

	/**
	* @see Database\Interfaces\Deleter
	*
	* @return true|false
	*/
	public function delete($statement, $flag);
}