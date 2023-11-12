<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uc_showroom_joshua";
$table = "trucks";

$action = $_POST["action"];

//Create Connection
$conn = new mysqli($servername,$username,$password, $dbname);
//Check Connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
    return;
}
//Create Table if it does not exist
if ("CREATE_TABLE" == $action) {
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        trucks_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        jumlah_roda INT NOT NULL,
        luas_kargo FLOAT NOT NULL,
        CONSTRAINT fk_vehicle_id FOREIGN KEY (vehicle_id) REFERENCES vehicle_id (vehicle_id) ON DELETE CASCADE ON UPDATE CASCADE,

    )";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Get All data from Trucks Table
if('GET_ALL_TRU' == $action){
    $dbdata = array();
    $sql = "SELECT * FROM $table ORDER BY trucks_id DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dbdata[]=$row;
        }
        echo json_encode($dbdata);
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Get data from Trucks Table by id
if('GET_TRU' == $action){
    $trucks_id = $_POST['trucks_id'];
    $dbdata = array();
    $sql = "SELECT * FROM $table WHERE trucks_id = $trucks_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dbdata[]=$row;
        }
        echo json_encode($dbdata);
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Create new Trucks
if('ADD_TRU' == $action){
    $jumlah_roda = $_POST['jumlah_roda'];
    $luas_kargo = $_POST['luas_kargo'];
    $sql = "INSERT INTO $table (jumlah_roda, luas_kargo,) VALUES('$jumlah_roda', '$luas_kargo',)";
    $result = $conn->query($sql);
    echo 'success';
    return;
}

//Update Trucks data
if('UPDATE_TRU' == $action){
    $trucks_id = $_POST['trucks_id'];
    $jumlah_roda = $_POST['jumlah_roda'];
    $luas_kargo = $_POST['luas_kargo'];
    $sql = "UPDATE $table SET jumlah_roda = '$jumlah_roda', luas_kargo = '$luas_kargo' WHERE trucks_id = $trucks_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Delete Trucks
if('DELETE_TRU' == $action){
    $trucks_id = $_POST['trucks_id'];
    $sql = "DELETE FROM $table WHERE trucks_id = $trucks_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}
?>