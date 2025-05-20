<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<h2>Données envoyées :</h2>";

    echo "<p><strong>Nom :</strong> " . $_POST['nom'] . "</p>";
    echo "<p><strong>Prénom :</strong> " . $_POST['prenom'] . "</p>";
    echo "<p><strong>Date de naissance :</strong> " . $_POST['birthdate'] . "</p>";
    echo "<p><strong>Adresse :</strong> " . $_POST['adresse'] . "</p>";
    echo "<p><strong>Pays :</strong> " . $_POST['pays'] . "</p>";
    echo "<p><strong>Email :</strong> " . $_POST['email'] . "</p>";
    echo "<p><strong>Téléphone :</strong> " . $_POST['phone'] . "</p>";

    echo "<p><strong>Sexe :</strong> " . $_POST['sexe'] . "</p>";

    echo "<p><strong>Pseudo :</strong> " . $_POST['pseudo'] . "</p>";
    echo "<p><strong>Mot de passe :</strong> " . $_POST['mdp'] . "</p>";

    if (isset($_FILES['file'])) {
        echo "<p><strong>Photo de profil :</strong> " . $_FILES['file']['name'] . "</p>";
    }

    echo "<p><strong>Recevoir la newsletter :</strong> " . $_POST['newsletter'] . "</p>";

    echo "<p><strong>Newsletters choisies :</strong></p>";
    if (isset($_POST['option1'])) {
        echo "<p>Générale</p>";
    }
    if (isset($_POST['option2'])) {
        echo "<p>Nouveautés</p>";
    }
    if (isset($_POST['option3'])) {
        echo "<p>Conseils</p>";
    }
    if (isset($_POST['option4'])) {
        echo "<p>Entretien</p>";
    }
} else {
    echo "<p>Aucun formulaire soumis.</p>";
}
