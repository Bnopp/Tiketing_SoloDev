<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 13.11.2022
 * Description  : Group of methods allowing to retrieve data for about the user accounts
 * 
 * @copyright 2022 - ETML - Serghei Diulgherov
 */

/**
 * Classes list :
 *  
 * 
 * Functions list :
 *  
 */

include_once 'Entity.php';

require_once 'data/data.php';

class UserRepository implements Entity
{
    private $_pdoConnection;

    public function __construct()
    {
        $this -> _pdoConnection = Data::getConn();
    }

    public function getAll()
    {
        $data = $this
            -> _pdoConnection
            -> querySimpleExecute('SELECT * FROM t_user');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getAdmins()
    {
        $data = $this
            -> _pdoConnection
            -> querySimpleExecute('SELECT * FROM t_user WHERE useAdmin = 1');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getOne($username)
    {
        $binds['username'] = ['value' => $username, 'type' => PDO::PARAM_STR];

        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('SELECT * FROM t_user WHERE useUsername = :username', $binds);
        
        return $this
            -> _pdoConnection
            -> formatData($data);
    }
}

?>