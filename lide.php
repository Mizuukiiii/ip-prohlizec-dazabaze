<?php

require_once "db.inc.php";
switch($_GET['poradi'])
        {
            case "jmeno_down":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY employee.surname DESC";
                break;
            case "jmeno_up":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY employee.surname ASC";
                break;
            case "mistnost_down":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY room_name DESC";
                break;
            case "mistnost_up":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY room_name ASC";
                break;
            case "telefon_down":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY room.phone DESC";
                break;
            case "telefon_up":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY room.phone ASC";
                break;
            case "pozice_down":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY employee.job DESC";
                break;
            case "pozice_up":
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id ORDER BY employee.job ASC";
                break;
            default:
                $query = "SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.phone, room.name AS room_name FROM employee, room WHERE employee.room = room.room_id;";
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
    <title>Lidé</title>
</head>
<body>
<?php 
    
   
    
    $stmt->execute();

    echo "<h1>Seznam zaměstanců</h1>";
    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo "<th>Jméno a Příjmení <a href='?poradi=jmeno_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=jmeno_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th><th>Místnost <a href='?poradi=mistnost_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=mistnost_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th><th>Telefon <a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th><th>Pozice <a href='?poradi=pozice_up'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></a><a href='?poradi=pozice_down'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></a></th>";
    echo "</tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td><a href='clovek.php?clovekId={$row->employee_id}'>{$row->surname} {$row->name}</a></td><td>{$row->room_name}</td><td>{$row->phone}</td><td>{$row->job}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<a href='index.php'>Zpět na kartu Domů</a>";
    ?>
</body>
</html>