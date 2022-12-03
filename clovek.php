<?php
$status = "ok";
$id = filter_input(INPUT_GET,'clovekId',FILTER_VALIDATE_INT,["options" => array("min_range"=> 1, "max_range"=>11)]);
if ($id === null || $id === false) {
    http_response_code(404);
    $status = "not_found";
}
else {
    require_once "db.inc.php";  
    $stmtStart = $pdo->prepare("SELECT employee.employee_id, room.room_id, room.name AS rname, employee.name, employee.surname FROM room, employee WHERE employee.employee_id=:clovekId");
    $stmtStart->execute(['clovekId' => $id]);
    if ($stmtStart->rowCount() === 0) {
        http_response_code(400);
        $status = "bad_request";
    }
    else {
        $rowStart = $stmtStart->fetch();
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>Karta zaměstnance {$rowStart->name} {$rowStart->surname}</title>"; ?>
</head>
<body>
    <?php 
    switch ($status) {
        case "bad_request":
            echo "<h1>Error 400: Bad request</h1>";
            break;
        case "not_found":
            echo "<h1>Error 404: Not found</h1>";
            break;
        default:
            $stmt = $pdo->prepare("SELECT employee.employee_id, employee.wage, employee.name, employee.surname, employee.job, room.phone, room.room_id,  room.name AS room_name FROM employee, room  WHERE employee.room = room.room_id");
            $stmt->execute();
    
            $stmtKeys = $pdo->prepare("SELECT r.room_id AS room_id, r.name AS name FROM `key` k LEFT JOIN room r ON (r.room_id = k.room) WHERE k.employee=$_GET[clovekId]");
            $stmtKeys->execute();

            $row2 = $stmtKeys->fetchAll();
    
            echo "<h2>Karta zaměstnance <u>{$rowStart->name} {$rowStart->surname}</u></h2>";
            echo "<table class='table table-striped'>";
            echo "<tr>";
            echo "<th>-Jméno-</th><th>-Příjmení-</th><th>-Pozice-</th><th>-Mzda-</th><th>-Místnost-</th>";
            echo "</tr>";
            echo "<strong>Klíče: </strong>";
            foreach($row2 as $value)
            {
                echo "<a href=mistnost.php?mistnostId={$value->room_id}>{$value->name}</a>  &nbsp;";
        
            }
            echo "</br>";
            echo "</br>";
            while($row = $stmt->fetch()){
            if($_GET['clovekId']== $row->employee_id)
            {
                echo "<tr>";
                echo "<td>{$row->name}</td><td>{$row->surname}</td><td>{$row->job}</td><td>{$row->wage}</td><td><a href=mistnost.php?mistnostId={$row->room_id}>{$row->room_name}</td></a>";
                echo "</tr>";
            }
}
    
        
    

    echo "</table>";
    echo "</br>";
    echo "<a href='lide.php'>Zpět na kartu Lidé</a>";
    }
    ?>
</body>
</html>