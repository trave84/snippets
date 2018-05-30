<?php

namespace snippets\db;

use PDO;
use PDOException;

class db
{
    // the database connection
    protected static $connection = null;

    /**
     * returns the connection to a MySQL server
     * 
     * the connection is a PDO object
     */
    public static function getConnection()
    {
        if (static::$connection === null) { // was the connection not yet established?
            try {
                static::$connection = new PDO(
                    // 'mysql:dbname=world;host=localhost;charset=utf8'
                    'mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8', 
                    DB_USER,
                    DB_PASS
                );
         
                static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
         
        return static::$connection;
    }

    /**
     * runs a query
     * 
     * @param string $query - the SQL query to be run
     * @param array $values - the values to replace ? in the SQL query
     * @return PDOStatement - the resulting statement
     */
    public static function query($query, $values = [])
    {
        // get the connection to database
        $connection = static::getConnection();

        // prepare the query
        $statement = $connection->prepare($query); 

        // execute the statement
        $success = $statement->execute($values);

        if(!$success)
        {
            // exit on error
            static::exitWithError();
        }

        // return the statement on success
        return $statement;
    }

    /**
     * selects some rows by a query
     * 
     * @param string $query - the SQL query to be run (SELECT)
     * @param array $values - the values to replace ? in the SQL query
     * @return array - array of fetched rows
     */
    public static function select($query, $values = [])
    {
        // run the query and get the statement
        // using the method that we wrote above
        $statement = static::query($query, $values);

        // set the format of the returned rows (to objects)
        $statement->setFetchMode(PDO::FETCH_OBJ);

        // fetch all rows at once as an array
        $all_results = $statement->fetchAll();

        // return the results
        return $all_results;
    }

    /**
     * selects one row by a query
     * 
     * @param string $query - the SQL query to be run (SELECT)
     * @param array $values - the values to replace ? in the SQL query
     * @return mixed - the selected row
     */
    public static function find($query, $values = [])
    {
        // run the query and get the statement
        // using the method that we wrote above
        $statement = static::query($query, $values);

        // set the format of the returned rows (to objects)
        $statement->setFetchMode(PDO::FETCH_OBJ);

        // fetch the first row
        $result = $statement->fetch();

        // return the result
        return $result;
    }

    public static function exitWithError()
    {
        // print a <h1>
        echo '<h1>MySQL error:</h1>';
    
        // dump information about the error
        var_dump(static::getConnection()->errorInfo());
    
        // end execution
        exit();
    }
}