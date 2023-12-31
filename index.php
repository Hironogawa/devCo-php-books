<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</head>
<body>

    <table class="table table-success table-striped">           
        <!-- TABELLENKOPF MIT FELDNAMEN -->
        <thead>
            <tr class="table-dark">
            <?php
                require "./includes/db.php";

                // Falls möglich, die Daten vom letzten editbook.php-Aufruf aktualisieren.
                updateBook($dbConnection);

                // Alle Daten zu den Büchern aus der Datenbank auslesen (SELECT)
                $sqlStatement = $dbConnection->query("SELECT * FROM `books`");

                // Den Tabellenkopf vollständig ausgeben
                // https://www.php.net/manual/en/pdostatement.columncount.php
                $columnCount = $sqlStatement->columnCount();

                for ($c = 0; $c < $columnCount; $c++) {
                    // array mit Spalten-Metadaten holen
                    // https://www.php.net/manual/en/pdostatement.getcolumnmeta.php
                    $columnMeta = $sqlStatement->getColumnMeta($c);

                    // Aus den Spalten-Metadaten den Wert für 'name' auslesen und ausgeben
                    $columnName = $columnMeta['name'];
                    echo "<th>$columnName</th>";
                }
            ?>
            </tr>
        </thead>
        <!-- TABELLENZELLEN MIT DATEN -->
        <tbody> 
        <?php 
            // Falls $row === null wird die Bedingung in () von PHP als false interpretiert.
            // Damit kann die while-Schleife verlassen werden.

            // ->fetch() holt immer genau eine Tabellenzeile aus der Datenbank.
            $row = $sqlStatement->fetch(PDO::FETCH_ASSOC);

            while ($row) { // vertikal, zeilenweise (vertical, row-by-row)
                echo "<tr>";

                // Durch den Array hindurch die Angaben zu einem Buch in eine Tabellenzelle ausgeben.
                foreach ($row as $columnName => $value) { // horizontal, spaltenweise (col-by-col)
                    if ($columnName === 'title') {
                        $id = $row['id'];
                        echo "<td><a href='editbook.php?id=$id'>$value</a></td>";
                    }
                    else { // id, author, year ....
                       echo "<td>$value</td>"; 
                    }
                }

                echo "</tr>";

                // Hole die nächste Tabellenzeile.
                $row = $sqlStatement->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        </tbody>
    </table>   
</body>
</html>