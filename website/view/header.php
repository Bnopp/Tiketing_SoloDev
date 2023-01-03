<?php

/**
 * ETML
 * @author      : Serghei Diulgherov
 * Date         : 16.11.2022
 * Description  : WebPage header
 * 
 * @copyright 2022 - ETML - Serghei Diulgherov
 */
?>

<div class="flex-center" id="header">
    <header class="menu-bar">
        <div class="title-text">
        <a href="index.php" style="color: white; text-decoration:none;"><h3>GETS</h3></a>
            <span class="vertical-separator"></span>
            <a href="index.php" style="color: white; text-decoration:none;"><h3>Bienvenue, <?=$_SESSION['firstName']?></h3></a>
        </div>
        
        <a class="button" href="index.php?controller=home&action=logout">Se déconnecter</a>
    </header>
</div>
