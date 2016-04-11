<?php
/** Includes */
include ('pdosetting.inc.php');

/**
 * PDO-Class using singelton pattern from John Richardson
 *
 * Reference: http://weebtutorials.com/2012/03/pdo-connection-class-using-singleton-pattern/
 * Changes: Errorhandling, some comments. Everything else unchanged.
 * Formated Comments
 */
class dbConn
{
	/** variable to hold connection object. */
	static $db;
	 
	/** private construct - class cannot be instatiated externally. */
	private function __construct() 
	{
		try 
		{
			/** assign PDO object to db variable */
			self::$db = new PDO( 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
			self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $e) 
		{
			/** Datebase connection error */
			$navbar = 3;
			echo '<div class="alert alert-danger"><strong>Fehler:</strong> Es kann keine Verbindung zur Datenbank hergestellt werden.</div>';
			die;
		}
	}
	 
	/** get connection function. Static method - accessible without instantiation */
	public static function getConnection() 
	{
		/** Guarantees single instance, if no connection object exists then create one. */
		if (!self::$db) 
		{
			/** new connection object.*/
			new dbConn();
		}
		 
		/** return connection. */
		return self::$db;
	}
}
?>