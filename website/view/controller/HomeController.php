<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 10.11.2022
 * Description  : Home controller
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

class HomeController extends Controller
{
    public function display()
    {
        $action = $_GET['action'] . "Action";

        if (method_exists($this, $action))
            return call_user_func(array(
                $this, 
                $action
            ));
        else
        {
            $_SESSION['errorCode'] = 404;
            $_SESSION['errorMsg'] = "Page not found";

            //Error redirect page
            //header("Location: ...")

            die();
        }
    }
}