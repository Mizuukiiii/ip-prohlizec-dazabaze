<?php
require_once "db.inc.php";  
switch($_GET['poradi'])
        {
            case "nazev_down":
                $query = "SELECT * FROM room ORDER BY room.name DESC";
                break;
            case "nazev_up":
                $query = "SELECT * FROM room ORDER BY room.name ASC";
                break;
            case "cislo_down":
                $query = "SELECT * FROM room ORDER BY room.no DESC";
                break;
            case "cislo_up":
                $query = "SELECT * FROM room ORDER BY room.no ASC";
                break;
            case "telefon_down":
                $query = "SELECT * FROM room ORDER BY room.phone DESC";
                break;
            case "telefon_up":
                $query = "SELECT * FROM room ORDER BY room.phone ASC";
                break;
            default:
                $query = "SELECT * FROM `room`";
        }
        $stmt = $pdo->prepare($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Místnosti</title>
</head>
<body>
    <?php 
    
        
    
    
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    
    echo "<h1>Seznam místností</h1>";
    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo "<th>Jméno <a href='?poradi=nazev_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=nazev_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th><th>Číslo <a href='?poradi=cislo_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=cislo_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th><th>Telefon <a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th>";
    echo "</tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td><a href='mistnost.php?mistnostId={$row->room_id}'>{$row->name}</a></td><td>{$row->no}</td><td>{$row->phone}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<a href='index.php'>Zpět na kartu Domů</a>";
    ?>
</body>
</html>