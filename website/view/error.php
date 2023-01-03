<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Erreur!</strong> 
  <?php
    if (is_array($_SESSION['error']))
    {
      foreach ($_SESSION['error'] as $error)
      {
          echo "</br>" . htmlspecialchars($error);
      } 
    }
    else
    {
      echo "</br>" . htmlspecialchars($_SESSION['error']);
    }
  ?>  
</div>