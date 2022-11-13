<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 13.11.2022
 * Description  : Interface grouping all the methods needed in every repository
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

interface Entity
{
    public function getAll();

    public function getOne($id);
}

?>