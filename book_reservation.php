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
    <?php
        session_start();
        require "./includes/db.php";

        // $_GET liefert die 'id' aus der URL 'bookview.php?id=$id'
        if (isset($_POST['bookedBooks'])) {
            $id = $_POST['bookedBooks'];
        }
        else {
            // id fehlt: Abbrechen und PHP verlassen
            exit("Achtung: 'bookedBooks' fehlt");
        }



        foreach($_POST['bookedBooks'] as $book_id) {
            $data = [
                'email' => $_SESSION['email'],
                'book_id' => $book_id,
            ];
            $sql = "INSERT INTO book_reservation (email, book_id) VALUES (:email, :book_id)";
            $sqlStatement = $dbConnection->prepare($sql);
            $sqlStatement->execute($data);
        }

        $sqlStatement->execute($data);

    ?>  
            
</body>
</html>