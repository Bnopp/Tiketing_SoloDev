<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 2.1.2023
 * Description  : Group of methods allowing to retrieve data for about the uploaded attachements (files)
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

class AttachementRepository implements Entity
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
            -> querySimpleExecute('SELECT * FROM t_attachement');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getOne($id)
    {
        $binds['id'] = ['value' => $id, 'type' => PDO::PARAM_INT];

        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('SELECT * FROM t_attachement WHERE idAttachement = :id', $binds);
        
        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function removeOne($id)
    {
        $binds['id'] = ['value' => $id, 'type' => PDO::PARAM_INT];

        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('DELETE FROM t_attachement WHERE idAttachement = :id', $binds);
        
        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getAllByTicket($id)
    {
        $binds['id'] = ['value' => $id, 'type' => PDO::PARAM_INT];

        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('SELECT * FROM t_attachement WHERE fkTicket = :id', $binds);
        
        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function createOne($path, $ticket)
    {
        $binds['path'] = ['value' => $path, 'type' => PDO::PARAM_STR];
        $binds['ticket'] = ['value' => $ticket, 'type' => PDO::PARAM_INT];

        $data = $this
            ->_pdoConnection
            ->queryPrepareExecute('INSERT INTO t_Attachement (attPath, fkTicket) VALUES (:path, :ticket)', $binds);

        return $this
            ->_pdoConnection
            ->formatData($data);
    }
}

?>