<!--

    ETML
    Author          : Serghei Diulgherov
    Date            : 14.10.2022
    Descriptiopn    : Home user page

-->

<div class="home-page">
    <div class="container user-dash-left">
    
    </div>
    <div class="user-dash-right">
        <h2>Créer un Ticket:</h2>
        <form class="container data-form" enctype="multipart/form-data" id="ticket-creation" method="POST" action="index.php?controller=home&action=createTicket">
            <label for="title">Titre:</label>
            <input type="text" name="title" placeholder="Titre" required>
            <label for="description">Description:</label>
            <textarea name="description" placeholder="Description" required></textarea>
            <label for="types">Types:</label>
            <select id="types" required>
                <option value="" hidden selected>Sélectionner</option>
                <option value="Bug">Bug</option>
                <option value="Demande">Demande</option>
                <option value="Question">Question</option>
                <option value="Autre">Autre</option>
            </select>
            <input class="file-input" type="file" name="fileToUpload" id="fileToUpload">
            <button type="submit">Envoyer le Ticket</button>
        </form>
    </div>
</div>
