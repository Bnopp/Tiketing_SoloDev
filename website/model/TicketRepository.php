<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 21.12.2022
 * Description  : Group of methods allowing to retrieve data for about the registered tickets
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

class TicketRepository implements Entity
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
            -> querySimpleExecute('SELECT * FROM t_ticket');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getOne($id)
    {
        $binds['id'] = ['value' => $id, 'type' => PDO::PARAM_INT];

        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('SELECT * FROM t_ticket WHERE idTicket = :id', $binds);
        
        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function createTicket()
    {

    }
}

?>