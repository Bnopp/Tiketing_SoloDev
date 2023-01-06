<!--

    ETML
    Author          : Serghei Diulgherov
    Date            : 14.10.2022
    Descriptiopn    : Home user page

-->
<div class="home-page">
    <div class="user-dash-left">
        <div class="search-bar">
            <form class="container data-form" id="search" method="GET" action="index.php">
                <div class="row">
                    <input type="text" name="search" placeholder="Rechercher..."/>
                    <button type="submit">Rechercher</button>
                </div>
                <div class="row">
                    <div id="info">
                        <label for="priority">Priorité:</label>
                        <select name="priority" id="priority">
                            <option value="0">Tout</option>
                            <?php
                                foreach(PRIORITIES as $priority)
                                {
                                    $option = '<option value="' . htmlspecialchars($priority['idPriority']) . '"';
                                    if (isset($_GET['priority']) && $_GET['priority'] == $priority['idPriority'])
                                    {
                                        $option .= 'selected ';
                                    }
                                    $option .= '>' . htmlspecialchars($priority['priTitle']) . '</option>';
                                    echo $option;
                                }
                            ?>
                        </select>
                    </div>
                    <div id="info">
                        <label for="statuses">Status:</label>
                        <select name="status" id="statuses">
                            <option value="0">Tout</option>
                            <?php
                                foreach(STATUSES as $status)
                                {
                                    $option = '<option value="' . htmlspecialchars($status['idStatus']) . '"';
                                    if (isset($_GET['status']) && $_GET['status'] == $status['idStatus'])
                                    {
                                        $option .= 'selected ';
                                    }
                                    $option .= '>' . htmlspecialchars($status['staTitle']) . '</option>';
                                    echo $option;
                                }
                            ?>
                        </select>
                    </div>
                    <div id="info">
                        <label for="type">Type:</label>
                        <select name="type" id="type">
                            <option value="0">Tout</option>
                            <?php
                                foreach(TYPES as $type)
                                {
                                    $option = '<option value="' . htmlspecialchars($type['idType']) . '"';
                                    if (isset($_GET['type']) && $_GET['type'] == $type['idType'])
                                    {
                                        $option .= 'selected ';
                                    }
                                    $option .= '>' . htmlspecialchars($type['tyTitle']) . '</option>';
                                    echo $option;
                                }
                            ?>
                        </select>
                    </div>
                    <div id="info">
                        <label for="order">Création:</label>
                        <select name="order" id="order">
                            <?php
                                $option = '<option value="0"';
                                if (isset($_GET['order']) && $_GET['order'] == 0)
                                {
                                    $option .= 'selected ';
                                }
                                $option .= '>Ascendant</option>';
                                echo $option;
                                $option = '<option value="1"';
                                if (isset($_GET['order']) && $_GET['order'] == 1)
                                {
                                    $option .= 'selected ';
                                }
                                $option .= '>Descendant</option>';
                                echo $option;
                            ?>
                        </select>
                    </div>
                    <?php if ($_SESSION['isAdmin'] == 1): ?>
                        <div id="info">
                            <label for="assigned">Assigné à:</label>
                            <select name="assigned" id="assigned">
                                <option value="0">Tout</option>
                                <?php
                                    $option = '<option value="1"';
                                    if (isset($_GET['assigned']) && $_GET['assigned'] == 1)
                                    {
                                        $option .= 'selected ';
                                    }
                                    $option .= '>Assigné à moi</option>';
                                    echo $option;
                                ?>
                            </select>
                        </div>
                    <?php endif ?>
                </div>
            </form>
        </div>
        <div class="container ticket-area">
            <?php 
                $search = '';
                $type = 0;
                $status = 0;
                $priority = 0;
                $order = 0;
                $assigned = 0;

                if (isset($_GET['search']) && !empty($_GET['search']))
                {
                    $search = $_GET['search'];
                }

                if (isset($_GET['type']) && $_GET['type'] > 0 && $_GET['type'] <= count(TYPES))
                {
                    $type = $_GET['type'];
                }

                if (isset($_GET['status']) && $_GET['status'] > 0 && $_GET['status'] <= count(STATUSES))
                {
                    $status = $_GET['status'];
                }

                if (isset($_GET['priority']) && $_GET['priority'] > 0 && $_GET['priority'] <= count(PRIORITIES))
                {
                    $priority = $_GET['priority'];
                }

                if (isset($_GET['order']))
                {
                    $order = $_GET['order'];
                }

                if (isset($_GET['assigned']))
                {
                    $assigned = $_GET['assigned'];
                }
                
                $tickets = $ticketRepository -> searchTicket($search, $type, $status, $priority, $order, $assigned);
                //var_dump($tickets);
            ?>
            <?php foreach($tickets as $ticket): ?>
                <?php echo '<a class="container ticket" href="index.php?ticketId=' .  htmlspecialchars($ticket['idTicket']) . '">'; ?>
                    <div class="preview">
                        <?php
                            if(isset($ticket['ticTitle']))
                            {
                                echo '<h3>' .  htmlspecialchars($ticket['ticTitle']) . ' (ID.' . htmlspecialchars($ticket['idTicket']) . ')</h3>';
                            }

                            if(isset($ticket['ticDescription']))
                            {
                                echo '<p>' .  htmlspecialchars($ticket['ticDescription']) . '</p>';
                            }
                        ?>
                    </div>
                    <div class="information">
                        <div class="row">
                            <div id="info">
                                <p id="label">Priorité:</p>
                                <?php 
                                    if (isset($ticket['fkPriority']))
                                    {
                                        if ($ticket['fkPriority'] == 1)
                                        {
                                            $pri = '<p class="low">';
                                        }
                                        else if ($ticket['fkPriority'] == 2)
                                        {
                                            $pri = '<p class="medium">';
                                        }
                                        else if ($ticket['fkPriority'] == 3)
                                        {
                                            $pri = '<p class="high">';
                                        }
                                        
                                        echo $pri .  htmlspecialchars(PRIORITIES[$ticket['fkPriority']-1]['priTitle']) . '</p>';
                                    }
                                    else
                                    {
                                        echo '<p>Non attribuée</p>';
                                    }
                                ?>
                            </div>
                            <div id="info">
                                <p id="label">Status:</p>
                                <?php 
                                    if(isset($ticket['fkStatus']))
                                    {
                                        echo '<p>' .  htmlspecialchars(STATUSES[$ticket['fkStatus']-1]['staTitle']) . '</p>';
                                    }
                                ?>
                            </div>
                            <div id="info">
                                <p id="label">Type:</p>
                                <?php 
                                    if(isset($ticket['fkType']))
                                    {
                                        echo '<p>' .  htmlspecialchars(TYPES[$ticket['fkType']-1]['tyTitle']) . '</p>';
                                    }
                                ?>
                            </div>
                            <div id="info">
                                <p id="label">Assigné à:</p>
                                <?php 
                                    if(isset($ticket['fkResolver']))
                                    {
                                        echo '<p>' .  htmlspecialchars(ADMINS[$ticket['fkResolver']-1]['useSurname']) . ' ' . 
                                        htmlspecialchars(ADMINS[$ticket['fkResolver']-1]['useName']) . '</p>';
                                    }
                                    else
                                    {
                                        echo '<p>Non assigné</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div id="info">
                                <p id="label">Crée par:</p>
                                <?php 
                                    if(isset($ticket['fkUser']))
                                    {
                                        echo '<p>' .  htmlspecialchars(USERS[$ticket['fkUser']-1]['useSurname']) . ' ' . 
                                        htmlspecialchars(USERS[$ticket['fkUser']-1]['useName']) . '</p>';
                                    }
                                ?>
                            </div>
                            <div id="info">
                                <p id="label">Crée le:</p>
                                <?php 
                                    if(isset($ticket['ticCreationDate']))
                                    {
                                        echo '<p>' .  htmlspecialchars($ticket['ticCreationDate']) . '</p>';
                                    }
                                    else
                                    {
                                        echo '<p>Pas encore résolu</p>';
                                    }
                                ?>
                            </div>
                            <div id="info">
                                <p id="label">Résolu le:</p>
                                <?php 
                                    if(isset($ticket['ticResolutionDate']))
                                    {
                                        echo '<p>' .  htmlspecialchars($ticket['ticResolutionDate']) . '</p>';
                                    }
                                    else
                                    {
                                        echo '<p>Pas encore résolu</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
    
    <div class="user-dash-right">
        <?php if (isset($_GET['ticketId'])):?>
        <?php
            $ticketRepository = new TicketRepository();
            $attachementRepository = new AttachementRepository();
            $ticket = $ticketRepository -> getOne($_GET['ticketId']);
            $attachements = $attachementRepository -> getAllByTicket($_GET['ticketId']);
            echo '<h2>Ticket nb.' .  htmlspecialchars($_GET['ticketId']) . '</h2>';
        ?>
        <?php 
            $form = '<form class="container data-form" enctype="multipart/form-data" id="ticket-creation" method="POST" action="index.php?ticketId=';
            $form .= htmlspecialchars($ticket[0]['idTicket']) . '&controller=home&action=updateTicket">';
            echo $form;
        ?>
        
            <label for="title">Titre:</label>

            <?php echo '<input type="text" name="title" placeholder="Titre" value="' .  htmlspecialchars($ticket[0]['ticTitle']) . '" required readonly>';?>

            <label for="description">Description:</label>

            <?php echo ' <textarea name="description" placeholder="Description" required readonly>' .  htmlspecialchars($ticket[0]['ticDescription']) . '</textarea>';?>

            <div class="info-content">
                <?php if ($_SESSION['isAdmin'] == 1): ?>
                    <div class="row">
                        <div id="info">
                            <p id="label">Priorité:</p>
                            <select name="priority" id="priority">
                                <option value="0">Non attribué</option>
                                <?php
                                    foreach(PRIORITIES as $priority)
                                    {
                                        $option = '<option value="' . htmlspecialchars($priority['idPriority']) . '"';
                                        if (isset($ticket[0]['fkPriority']) && $ticket[0]['fkPriority'] == $priority['idPriority'])
                                        {
                                            $option .= 'selected ';
                                        }
                                        $option .= '>' . htmlspecialchars($priority['priTitle']) . '</option>';
                                        echo $option;
                                    }
                                ?>
                            </select>
                        </div>
                        <div id="info">
                            <p id="label">Status:</p>
                            <select name="status" id="status">
                                <?php
                                    foreach(STATUSES as $status)
                                    {
                                        $option = '<option value="' . htmlspecialchars($status['idStatus']) . '"';
                                        if (isset($ticket[0]['fkStatus']) && $ticket[0]['fkStatus'] == $status['idStatus'])
                                        {
                                            $option .= 'selected ';
                                        }
                                        $option .= '>' . htmlspecialchars($status['staTitle']) . '</option>';
                                        echo $option;
                                    }
                                ?>
                            </select>
                        </div>
                        <div id="info">
                            <p id="label">Type:</p>
                            <select name="type" id="type">
                                <?php
                                    foreach(TYPES as $type)
                                    {
                                        $option = '<option value="' . htmlspecialchars($type['idType']) . '"';
                                        if (isset($ticket[0]['fkType']) && $ticket[0]['fkType'] == $type['idType'])
                                        {
                                            $option .= 'selected ';
                                        }
                                        $option .= '>' . htmlspecialchars($type['tyTitle']) . '</option>';
                                        echo $option;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div id="info">
                            <p id="label">Assigné à:</p>
                            <select name="assigned" id="assigned">
                                <option value="0">Non assigné</option>
                                <?php
                                    foreach(ADMINS as $admin)
                                    {
                                        $option = '<option value="' . htmlspecialchars($admin['idUser']) . '"';
                                        if (isset($ticket[0]['fkResolver']) && $ticket[0]['fkResolver'] == $admin['idUser'])
                                        {
                                            $option .= 'selected ';
                                        }
                                        $option .= '>' . htmlspecialchars($admin['useSurname']) . ' ' . htmlspecialchars($admin['useName']) . '</option>';
                                        echo $option;
                                    }
                                ?>
                            </select>
                        </div>
                        <div id="info">
                            <button type="submit">Mettre à jour le ticket</button>
                        </div>
                    </div>
                    <div class="row">
                        <div id="info">
                            <p id="label">Pièces(s) jointe(s):</p>
                            <?php
                                if (count($attachements) > 0)
                                {
                                    foreach ($attachements as $attachement)
                                    {
                                        if(!file_exists($attachement['attPath']))
                                        {
                                            $attachementRepository -> removeOne($attachement['idAttachement']);
                                            echo "<p>Ce ticket ne contient pas de pièces jointes";
                                        }
                                        else
                                        {
                                            echo '<a href="' . htmlspecialchars($attachement['attPath']) . '">' . htmlspecialchars(basename($attachement['attPath'])) .'</a>';
                                        }
                                    }
                                }
                                else
                                {
                                    echo "<p>Ce ticket ne contient pas de pièces jointes";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="info">
                            <p id="label">Crée par:</p>
                            <?php 
                                if(isset($ticket[0]['fkUser']))
                                {
                                    echo '<p>' .  htmlspecialchars(USERS[$ticket[0]['fkUser']-1]['useSurname']) . ' ' . 
                                    htmlspecialchars(USERS[$ticket[0]['fkUser']-1]['useName']) . '</p>';
                                }
                            ?>
                        </div>
                        <div id="info">
                            <p id="label">Crée le:</p>
                            <?php 
                                if(isset($ticket[0]['ticCreationDate']))
                                {
                                    echo '<p>' .  htmlspecialchars($ticket[0]['ticCreationDate']) . '</p>';
                                }
                                else
                                {
                                    echo '<p>Pas encore résolu</p>';
                                }
                            ?>
                        </div>
                        <div id="info">
                            <p id="label">Résolu le:</p>
                            <?php 
                                if(isset($ticket[0]['ticResolutionDate']))
                                {
                                    echo '<p>' .  htmlspecialchars($ticket[0]['ticResolutionDate']) . '</p>';
                                }
                                else
                                {
                                    echo '<p>Pas encore résolu</p>';
                                }
                            ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div id="info">
                            
                            <p id="label">Priorité:</p>
                            <?php 
                                if (isset($ticket[0]['fkPriority']))
                                {
                                    if ($ticket[0]['fkPriority'] == 1)
                                    {
                                        $pri = '<p class="low">';
                                    }
                                    else if ($ticket[0]['fkPriority'] == 2)
                                    {
                                        $pri = '<p class="medium">';
                                    }
                                    else if ($ticket[0]['fkPriority'] == 3)
                                    {
                                        $pri = '<p class="high">';
                                    }

                                    echo $pri .  htmlspecialchars(PRIORITIES[$ticket[0]['fkPriority']-1]['priTitle']) . '</p>';
                                }
                                else
                                {
                                    echo '<p>Non attribuée</p>';
                                }
                            ?>
                        </div>
                        <div id="info">
                            <p id="label">Status:</p>
                            <?php 
                                if(isset($ticket[0]['fkStatus']))
                                {
                                    echo '<p>' .  htmlspecialchars(STATUSES[$ticket[0]['fkStatus']-1]['staTitle']) . '</p>';
                                }
                            ?>
                        </div>
                        <div id="info">
                            <p id="label">Type:</p>
                            <?php 
                                if(isset($ticket[0]['fkType']))
                                {
                                    echo '<p>' .  htmlspecialchars(TYPES[$ticket[0]['fkType']-1]['tyTitle']) . '</p>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="info">
                            <p id="label">Assigné à:</p>
                            <?php 
                                if(isset($ticket[0]['fkResolver']))
                                {
                                    echo '<p>' .  htmlspecialchars(ADMINS[$ticket[0]['fkResolver']-1]['useSurname']) . ' ' . 
                                    htmlspecialchars(ADMINS[$ticket[0]['fkResolver']-1]['useName']) . '</p>';
                                }
                                else
                                {
                                    echo '<p>Non assigné</p>';
                                }
                            ?>
                        </div>
                        <div id="info">
                            <p id="label">Crée par:</p>
                            <?php 
                                if(isset($ticket[0]['fkUser']))
                                {
                                    echo '<p>' .  htmlspecialchars(USERS[$ticket[0]['fkUser']-1]['useSurname']) . ' ' . 
                                    htmlspecialchars(USERS[$ticket[0]['fkUser']-1]['useName']) . '</p>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="info">
                            <p id="label">Crée le:</p>
                            <?php 
                                if(isset($ticket[0]['ticCreationDate']))
                                {
                                    echo '<p>' .  htmlspecialchars($ticket[0]['ticCreationDate']) . '</p>';
                                }
                                else
                                {
                                    echo '<p>Pas encore résolu</p>';
                                }
                            ?>
                        </div>
                        <div id="info">
                            <p id="label">Résolu le:</p>
                            <?php 
                                if(isset($ticket[0]['ticResolutionDate']))
                                {
                                    echo '<p>' .  htmlspecialchars($ticket[0]['ticResolutionDate']) . '</p>';
                                }
                                else
                                {
                                    echo '<p>Pas encore résolu</p>';
                                }
                            ?>
                        </div>
                    </div>
                <div class="row">
                    <div id="info">
                        <p id="label">Pièces(s) jointe(s):</p>
                        <?php
                            if (count($attachements) > 0)
                            {
                                foreach ($attachements as $attachement)
                                {
                                    if(!file_exists($attachement['attPath']))
                                    {
                                        $attachementRepository -> removeOne($attachement['idAttachement']);
                                        echo "<p>Ce ticket ne contient pas de pièces jointes";
                                    }
                                    else
                                    {
                                        echo '<a href="' . htmlspecialchars($attachement['attPath']) . '">' . htmlspecialchars(basename($attachement['attPath'])) .'</a>';
                                    }
                                }
                            }
                            else
                            {
                                echo "<p>Ce ticket ne contient pas de pièces jointes";
                            }
                            
                        ?>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </form>
        

        <?php else:?>
            <h2>Créer un Ticket:</h2>
            <form class="container data-form" enctype="multipart/form-data" id="ticket-creation" method="POST" action="index.php?controller=home&action=createTicket">
                <label for="title">Titre:</label>
                <input type="text" name="title" placeholder="Titre" required>
                <label for="description">Description:</label>
                <textarea name="description" placeholder="Description" required></textarea>
                <label for="types">Type:</label>
                <select name="type" id="types" required>
                    <?php
                        foreach(TYPES as $type)
                        {
                            echo '<option value=' . htmlspecialchars($type['idType']) . '>' .  htmlspecialchars($type['tyTitle']) . '</option>';
                        }
                    ?>
                </select>
                <input class="file-input" type="file" name="fileToUpload[]" id="fileToUpload" multiple>
                <button type="submit">Envoyer le Ticket</button>
            </form>
        <?php endif ?>
    </div>
</div>