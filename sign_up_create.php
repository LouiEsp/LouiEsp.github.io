<?php
    if(isset($_POST['insert'])) {
        try{
        //connect to mysql
        $pdoConnect = new PDO("mysql:host=localhost;dbname=roadalertmapperdb","root","");
        //set the PDO error mode to exception
        $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exc) {
        echo $exc->getMessage();
        exit();
    }
    //get values form input text and number
    $id = $_POST['id'];
    $Fname = $_POST['fullname'];
    $User = $_POST['username'];
    $Pass = $_POST['password'];
    
    //mysl query to insert data
    $pdoQuery = "INSERT INTO roadalertmappertable (Email,Password,Fullname) VALUES(:username,:password,:fullname)";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(array(":username"=>$User,":password"=>$Pass,":fullname"=>$Fname));

    //check if mysql insert query successful
    $pdoQuery = 'SELECT * FROM roadalertmappertable';
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoResult->execute();
    while ($row = $pdoResult->fetch()) {
        echo $row['id'] . " | " .$row['UserName'] . " | " . $row['PassWord'] . " | " .
        $row['FullName'] . "<br>";
    }
    header("location: index.php");
    exit;
} else {
    echo 'Data Not Inserted';
}
$pdoConnect = null;
?>