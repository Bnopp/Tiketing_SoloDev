<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 10.11.2022
 * Description  : Main controller
 * 
 * @copyright 2022 - ETML - Serghei Diulgherov
 */

/**
 * Classes list :
 *  - Controller
 * 
 * Functions list :
 *  - display()
 */

class Controller
{
    
    /**
     * Method allows to call for an action
     * 
     * @return void
     */
    public function display()
    {
        $page = $_GET['action'] . "Display";

        $this -> $page();
    }
}

?>