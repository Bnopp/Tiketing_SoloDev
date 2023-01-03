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

    public function createOne($title, $description, $type, $user)
    {
        $binds['title'] = ['value' => $title, 'type' => PDO::PARAM_STR];
        $binds['description'] = ['value' => $description, 'type' => PDO::PARAM_STR];
        $binds['type'] = ['value' => $type, 'type' => PDO::PARAM_INT];
        $binds['user'] = ['value' => $user, 'type' => PDO::PARAM_INT];

        $data = $this
            ->_pdoConnection
            ->queryPrepareExecute('INSERT INTO t_ticket (ticTitle, ticDescription, fkType, fkUser) VALUES (:title, :description, :type, :user);', $binds);

        return $this
            ->_pdoConnection
            ->formatData($data);
    }

    public function getLastCreatedId()
    {
        $data = $this
            -> _pdoConnection
            -> querySimpleExecute('SELECT LAST_INSERT_ID();');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getTicketTypes()
    {
        $data = $this
            -> _pdoConnection
            -> querySimpleExecute('SELECT * FROM t_type');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getTicketPriorities()
    {
        $data = $this
            -> _pdoConnection
            -> querySimpleExecute('SELECT * FROM t_priority');

        return $this
            ->_pdoConnection
            ->formatData($data);
    }

    public function getTicketStatuses()
    {
        $data = $this
            -> _pdoConnection
            -> querySimpleExecute('SELECT * FROM t_status');

        return $this
            ->_pdoConnection
            ->formatData($data);
    }
}

?>