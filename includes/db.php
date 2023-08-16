<?php
require "./includes/tools.php";

// Verbinde mit mySQL, mit Hilfe eines PHP PDO Object
$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPassword);

// Setze den Fehlermodus für Web Devs
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// echo "<p>db.php: \$dbConnection erzeugt</p>";

// Funktion, welche $_POST-Daten ausliest und die Datenbank aktualisiert.
// Achtung: $dbConnection muss als Argument übergeben werden!
function updateBook($dbConnection) {
    // $_POST auslesen.
    prettyPrint($_POST);

    if (isset($_POST['deleteID']) && $_POST['deleteID'] > 0) {
        // Lösche das Buch mit der gegebenen 'deleteID'.
        $deleteID = $_POST['deleteID'];
        echo "<p>\$deleteID = $deleteID</p>"; // DEVONLY

        $sqlStatement = $dbConnection->query("DELETE FROM `books` WHERE `id`= $deleteID");
        $sqlStatement->execute();
    }
    elseif (isset($_POST['editID'])) {
        // Buchdaten in der Datenbank aktualisieren.
        $editID = $_POST['editID'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        $sqlStatement = $dbConnection->query("UPDATE `books` 
        SET `title` = '$title', `author` = '$author', `year` = $year 
        WHERE `id` = $editID");
        $sqlStatement->execute();
    }
    else {
        // Keine weitere Aktionen mit der Datenbank. 
        // Dieses else kann auch weggelöscht werden.
    }
}















// Feldnamen übersetzen
define(
    "NAME_MAP",
    array(
        // Schlüssel: Feldnamen => Wert: Deutsche Übersetzung
        "title" => "Titel",
        "genre" => "Genre",
        "author" => "Autor",
        "description" => "Beschreibung",
        "publisher" => "Publisher",
        "ISBN" => "ISBN",
        "price" => "Preis",
        "currency" => "Währung",
        "out_of_print" => "vergriffen"
    )
);

function translateColumnName($columnName) {
    return NAME_MAP[$columnName];
}

// ucfirst()

?>