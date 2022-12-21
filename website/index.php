<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 09.11.2022
 * Description  : Ticket Management web app for "Gestion des élèves"
 * 
 * @copyright 2022 - ETML - Serghei Diulgherov
 */

$debug = false;

if ($debug)
{
   error_reporting(E_ALL);
   ini_set('disply_errors', '1');
}

date_default_timezone_set('Europe/Zurich');

session_start();

include_once 'controller/Controller.php';
include_once 'controller/HomeController.php';

class MainControler 
{
   /**
    * This method finds what page is requested for load and forwards it to the necessary methods to build the view
    * 
    * @return void
    */
   public function dispatch()
   {
      if (!isset($_GET['controller']))
      {
         $_GET['controller'] = 'home';
         if (!isset($_SESSION['loggedIn']))
         {
            $_GET['action'] = 'login';
         }
         else
         {
            $_GET['action'] = 'home';
         }
      }

      $currentLink = $this -> menuSelected($_GET['controller']);
      $this -> viewBuild($currentLink);
   }

   protected function menuSelected($page)
   {
      switch ($page)
      {
         case 'home':
            $link = new HomeController();
         break;
      }
      return $link;
   }

   protected function viewBuild($currentPage)
   {
      $content = $currentPage -> display();

      include (dirname(__FILE__) . '/view/head.html');
      if ($_GET['action'] != 'login' && $_GET['action'] != 'connect')
      {
         include (dirname(__FILE__) . '/view/header.php');
      }
      if ($_GET['action'] != 'connect')
      {
         if (isset($_SESSION['error']))
         {
            //echo 'error detected';
            include (dirname(__FILE__) . '/view/error.php');
            unset($_SESSION['error']);
         }
      }
      echo $content;
      include (dirname(__FILE__) . '/view/footer.html');
   }
}

$_controller = new MainControler();
$_controller -> dispatch();

?>