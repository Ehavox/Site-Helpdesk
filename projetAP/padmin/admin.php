<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - L'atelier des jeux</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="w3-light-grey">

<?php
    // definir dbb
    $server = "localhost";
    $dbname = "AP";
    $user   = "user1";
    $passwd = "1234";

    try {
        $bdd = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8", $user, $passwd);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }

    // suppr ticket
    if (isset($_POST['suppr_tickets'])) {
        try {
            $stmt = $bdd->prepare("DELETE FROM tickets");
            $stmt->execute();
            $message = "Tous les tickets ont été supprimés.";
        } catch (Exception $e) {
            $message = "Erreur lors de la suppression : " . $e->getMessage();
        }
    }

    // status
    if (isset($_POST['update_statut']) && isset($_POST['id']) && isset($_POST['new_statut'])) {
        try {
            $stmt = $bdd->prepare("UPDATE tickets SET statut = ? WHERE id = ?");
            $stmt->execute([$_POST['new_statut'], $_POST['id']]);
            $message = "Statut mis à jour.";
        } catch (Exception $e) {
            $message = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
?>

<!-- header-->
<header class="w3-container w3-light-green w3-center" style="padding:128px 16px">
    <h1 class="w3-margin w3-jumbo">Administration - Gestion des tickets</h1>
    <p class="w3-xlarge">L'atelier des jeux</p>
</header>

<!-- nav -->
<div class="w3-top">
    <div class="w3-bar w3-light-green w3-card w3-large">
        <a href="../index.html" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Accueil</a>
        <a href="../problemes.html" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Assistance</a>
        <a href="../contact.html" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Contact</a>
        <a href="../inscription.html" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Inscription</a>
    </div>
</div>

<!-- body-->
<main class="w3-container w3-padding-32">
    <section class="w3-card-4 w3-white w3-padding">
        <h2 class="w3-center">Tableau de bord des tickets d’assistance</h2>
        <p class="w3-center">Bienvenue dans l’espace d’administration. Consultez et gérez les tickets soumis.</p>

        <!-- mess conf -->
        <?php if (isset($message)): ?>
            <div class="w3-panel w3-pale-green w3-border">
                <?php echo htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- bouton suppr-->
        <form method="post" class="w3-center w3-margin-bottom">
            <button type="submit" name="suppr_tickets" class="w3-button w3-red w3-round-large"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer tous les tickets ?');">
                Supprimer tous les tickets
            </button>
        </form>

        <!-- tickets-->
        <div class="w3-responsive">
            <table class="w3-table-all w3-hoverable w3-small">
                <thead>
                    <tr class="w3-blue">
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Statut</th>
                        <th>Changer le statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $stmt = $bdd->query("SELECT * FROM tickets ORDER BY date_creation DESC");
                            while ($donnees = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($donnees['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($donnees['pseudo']) . "</td>";
                                echo "<td>" . htmlspecialchars($donnees['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($donnees['type_probleme']) . "</td>";
                                echo "<td>" . nl2br(htmlspecialchars($donnees['message'])) . "</td>";
                                echo "<td>" . htmlspecialchars($donnees['statut']) . "</td>";
                                echo "<td>
                                    <form method='post' style='display:flex; gap:5px;'>
                                        <input type='hidden' name='id' value='" . $donnees['id'] . "'>
                                        <select name='new_statut' class='w3-select w3-border' required>
                                            <option value='En attente'" . ($donnees['statut'] == 'En attente' ? ' selected' : '') . ">En attente</option>
                                            <option value='En cours'" . ($donnees['statut'] == 'En cours' ? ' selected' : '') . ">En cours</option>
                                            <option value='Résolu'" . ($donnees['statut'] == 'Résolu' ? ' selected' : '') . ">Résolu</option>
                                        </select>
                                        <button type='submit' name='update_statut' class='w3-button w3-small w3-green'>OK</button>
                                    </form>
                                  </td>";
                                echo "<td>" . htmlspecialchars($donnees['date_creation']) . "</td>";
                                echo "</tr>";
                            }
                        } catch (Exception $e) {
                            echo "<tr><td colspan='8'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<!-- footer -->
<footer class="w3-container w3-black w3-padding-64 w3-center w3-opacity">
    <div class="w3-xlarge w3-padding-32">
        <i class="fa fa-facebook-official w3-hover-opacity"></i>
        <i class="fa fa-instagram w3-hover-opacity"></i>
        <i class="fa fa-discord w3-hover-opacity"></i>
        <i class="fa fa-twitter w3-hover-opacity"></i>
        <i class="fa fa-linkedin w3-hover-opacity"></i>
    </div>
    <p>© 2025 L'atelier des jeux - Propulsé par <a href="https://www.w3schools.com/w3css/default.asp"
            target="_blank">w3.css</a></p>
    <p><a href="conf.html">Politique de confidentialité</a></p>
    <p><a href="../index.html">Retour en haut</a> | <a href="admin.php">Administration</a></p>
</footer>

</body>
</html>
