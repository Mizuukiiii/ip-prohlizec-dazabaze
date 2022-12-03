<?php
$id = filter_input(INPUT_GET,
'mistnostId',
FILTER_VALIDATE_INT,
["options" => array("min_range"=> 1, "max_range"=>11)]
);

if ($id === null || $id === false || $id === 9|| $id === 10) {
    http_response_code(404);
    $status = "not_found";
}
else{
    require_once "db.inc.php";  
    $stmtStart = $pdo->prepare("SELECT room.room_id, room.name AS rname, employee.name, employee.surname FROM room, employee WHERE room.room_id=:mistnostId");
    $stmtStart->execute(['mistnostId' => $id]);
    $rowStart = $stmtStart->fetch();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>Karta místnosti {$rowStart->rname}</title>"; ?>
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
    $stmt = $pdo->prepare("SELECT * FROM room r WHERE r.room_id = $_GET[mistnostId]");
    $stmt->execute(); 
    
    $stmtLide = $pdo->prepare("SELECT e.employee_id, e.name , e.surname  FROM room r LEFT JOIN employee e ON (r.room_id = e.room) WHERE r.room_id=$_GET[mistnostId]");
    $stmtLide->execute();

    $stmtKlice = $pdo->prepare("SELECT *  FROM `key` k LEFT JOIN employee e ON (e.employee_id = k.employee) WHERE k.room=$_GET[mistnostId]; ");
    $stmtKlice->execute();

    $stmtSalary = $pdo->prepare("SELECT ROUND(AVG(employee.wage)) AS avg FROM employee WHERE employee.room=$_GET[mistnostId];");
    $stmtSalary->execute();

    $row4 = $stmtSalary->fetch();
    $row3 = $stmtKlice->fetchAll();
    $row2 = $stmtLide->fetchAll();  
    $row = $stmt->fetch();
        
    
    echo "<h1>Místnost č. {$row->no}</h1>";
    echo "<strong>Lidé: </strong>";
    
    foreach($row2 as $value )
    {
        
        echo "<a href=clovek.php?clovekId={$value->employee_id}>{$value->name} {$value->surname}</a>  &nbsp;";
        
    }
    echo "</br>";
    echo "<strong>Klíče: </strong>";
    foreach($row3 as $value )
    {
        echo "<a href=clovek.php?clovekId={$value->employee_id}>{$value->name} {$value->surname}</a>  &nbsp;";
    }
    echo "</br>";
    echo "</br>";
    echo "</br>";
    

    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo "<th>-Číslo-</th><th>-Název-</th><th>-Telefon-</th><th>-Průměrná mzda-</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>{$row->no}</td><td>{$row->name}</td><td>{$row->phone}</td><td>{$row4->avg}</td>";
    echo "</tr>";
    echo "</table>";
    echo "</br>";
    echo "<a href='mistnosti.php'>Zpět na kartu Místnosti</a>";
}
    ?>
</body>
</html>