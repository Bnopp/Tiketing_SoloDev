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

    public function updateTicket($id, $title, $description, $priority, $status, $type, $resolver)
    {
        $binds['title'] = ['value' => $title, 'type' => PDO::PARAM_STR];
        $binds['description'] = ['value' => $description, 'type' => PDO::PARAM_STR];
        if ($priority == 0)
        {
            $priority = null;
        }
        $binds['priority'] = ['value' => $priority, 'type' => PDO::PARAM_INT];
        if ($status == 1 && $resolver > 0)
        {
            $status = 2;
        }
        if ($resolver == 0)
        {
            $status = 1;
        }
        $binds['status'] = ['value' => $status, 'type' => PDO::PARAM_INT];
        $binds['type'] = ['value' => $type, 'type' => PDO::PARAM_INT];
        if ($resolver == 0)
        {
            $resolver = null;
        }
        $binds['resolver'] = ['value' => $resolver, 'type' => PDO::PARAM_INT];
        $binds['id'] = ['value' => $id, 'type' => PDO::PARAM_INT];


        if ($status == 5)
        {
            $query = 'UPDATE t_ticket SET ticTitle = :title, ticDescription = :description, fkPriority = :priority, fkStatus = :status,
                    fkType = :type, fkResolver = :resolver, ticResolutionDate = now() WHERE idTicket = :id;';
        }
        else
        {
            $query = 'UPDATE t_ticket SET ticTitle = :title, ticDescription = :description, fkPriority = :priority, fkStatus = :status,
                    fkType = :type, fkResolver = :resolver WHERE idTicket = :id;';
        }

        $data = $this
            ->_pdoConnection
            ->queryPrepareExecute($query, $binds);

        return $this
            ->_pdoConnection
            ->formatData($data);
    }

    public function validateTicket($ticket)
    {
        $binds['ticket'] = ['value' => $ticket, 'type' => PDO::PARAM_INT];
        $data = $this
            -> _pdoConnection
            -> queryPrepareExecute('UPDATE t_ticket SET fkStatus = 5, ticResolutionDate = now() WHERE idTicket = :ticket', $binds);

        return $this
            -> _pdoConnection
            -> formatData($data);
    }

    public function searchTicket($search, $type, $status, $priority, $order, $assigned)
    {
        $query = 'SELECT * FROM t_ticket WHERE (';

        $keywords = explode(' ', $search);

        if (count($keywords) < 2)
        {
            $binds['search'] = ['value' => "%" . $search . "%", 'type' => PDO::PARAM_STR];

            $query = 'SELECT * FROM t_ticket WHERE (ticTitle LIKE :search OR ticDescription LIKE :search)';
        }
        else
        {
            for ($i = 0;$i < count($keywords); $i++)
            {
                if (!empty($keywords[$i]))
                {
                    $binds[$keywords[$i]] = ['value' => "%" . $keywords[$i] . "%", 'type' => PDO::PARAM_STR];
                    $query .= 'ticTitle LIKE :' . $keywords[$i];
                    if ($i < count($keywords)-1)
                    {
                        $query .= ' && ';
                    }
                }
            }
            $query .= ') OR (';

            for ($i = 0;$i < count($keywords); $i++)
            {
                if (!empty($keywords[$i]))
                {
                    $binds[$keywords[$i]] = ['value' => "%" . $keywords[$i] . "%", 'type' => PDO::PARAM_STR];
                    $query .= 'ticDescription LIKE :' . $keywords[$i];
                    if ($i < count($keywords)-1)
                    {
                        $query .= ' && ';
                    }
                }
            }
            $query .= ')';
        }

        if ($type != 0)
        {
            $binds['type'] = ['value' => $type, 'type' => PDO::PARAM_INT];
            $query .= ' AND fkType = :type';
            
        }

        if ($status != 0)
        {
            $binds['status'] = ['value' => $status, 'type' => PDO::PARAM_INT];
            $query .= ' AND fkStatus = :status';
            
        }

        if ($priority != 0)
        {
            $binds['priority'] = ['value' => $priority, 'type' => PDO::PARAM_INT];
            $query .= ' AND fkPriority = :priority';
        }

        if ($assigned == 1)
        {
            $binds['admin'] = ['value' => $_SESSION['id'], 'type' => PDO::PARAM_INT];
            $query .= ' AND fkResolver = :admin';
        }

        if ($_SESSION['isAdmin'] == 0)
        {
            $binds['user'] = ['value' => $_SESSION['id'], 'type' => PDO::PARAM_INT];
            $query .= ' AND fkUser = :user';
        }

        if ($order == 0)
        {
            $query .= ' ORDER BY `t_ticket`.`ticCreationDate` ASC';
        }
        else
        {
            $query .= ' ORDER BY `t_ticket`.`ticCreationDate` DESC';
        }

        $data = $this
            ->_pdoConnection
            ->queryPrepareExecute($query, $binds);
        
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