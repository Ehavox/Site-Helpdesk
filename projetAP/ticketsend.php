<?php
$server = "localhost";
$dbname = "AP";
$user   = "user1";
$passwd = "1234";

try {
    $bdd = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8", $user, $passwd);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (
        isset($_POST['pseudo'], $_POST['email'], $_POST['type_probleme'], $_POST['message'])
        && ! empty($_POST['pseudo']) && ! empty($_POST['email']) && ! empty($_POST['message'])
    ) {
        $stmt = $bdd->prepare("INSERT INTO tickets (pseudo, email, type_probleme, message, statut, date_creation) VALUES (?, ?, ?, ?, 'En attente', NOW())");
        $stmt->execute([
            $_POST['pseudo'],
            $_POST['email'],
            $_POST['type_probleme'],
            $_POST['message'],
        ]);

        // redirection conf
        header("Location: confirmation.html");
        exit();
    } else {
        echo "Tous les champs sont requis.";
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
