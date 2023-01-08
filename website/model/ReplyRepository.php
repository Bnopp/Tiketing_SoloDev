<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 1.8.2023
 * Description  : Group of methods allowing to retrieve data for about the replies
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

class ReplyRepository implements Entity
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
            -> querySimpleExecute('SELECT * FROM t_reply');

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function getOne($ticket)
    {
        $binds['ticket'] = ['value' => $ticket, 'type' => PDO::PARAM_STR];

        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('SELECT * FROM t_reply WHERE fkTicket = :ticket', $binds);
        
        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function createOne($content, $ticket, $user)
    {
        $binds['content'] = ['value' => $content, 'type' => PDO::PARAM_STR];
        $binds['ticket'] = ['value' => $ticket, 'type' => PDO::PARAM_INT];
        $binds['user'] = ['value' => $user, 'type' => PDO::PARAM_INT];

        $data = $this
            ->_pdoConnection
            ->queryPrepareExecute('INSERT INTO t_reply (repContent, repCreationDate, fkTicket, fkUser) VALUES (:content, now(), :ticket, :user)', $binds);

        return $this
            ->_pdoConnection
            ->formatData($data);
    }
}

?>