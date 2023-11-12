<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uc_showroom_joshua";
$table = "motorcycles";

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
        motorcycles_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ukuran_bagasi FLOAT NOT NULL,
        kapasitas_bensin FLOAT NOT NULL,
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

//Get All data from Vehicles Table
if('GET_ALL_MOT' == $action){
    $dbdata = array();
    $sql = "SELECT * FROM $table ORDER BY motorcycles_id DESC";
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

//Get data from Motorcycles Table by id
if('GET_MOT' == $action){
    $motorcycles_id = $_POST['motorcycles_id'];
    $dbdata = array();
    $sql = "SELECT * FROM $table WHERE motorcycles_id = $motorcycles_id";
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

//Create new Motorcycles
if('ADD_MOT' == $action){
    $ukuran_bagasi = $_POST['ukuran_bagasi'];
    $kapasitas_bensin = $_POST['kapasitas_bensin'];
    $sql = "INSERT INTO $table (ukuran_bagasi, kapasitas_bensin,) VALUES('$ukuran_bagasi', '$kapasitas_bensin',)";
    $result = $conn->query($sql);
    echo 'success';
    return;
}

//Update Motorcycles data
if('UPDATE_MOT' == $action){
    $motorcycles_id = $_POST['motorcycles_id'];
    $ukuran_bagasi = $_POST['ukuran_bagasi'];
    $kapasitas_bensin = $_POST['kapasitas_bensin'];
    $sql = "UPDATE $table SET ukuran_bagasi = '$ukuran_bagasi', kapasitas_bensin = '$kapasitas_bensin' WHERE motorcycles_id = $motorcycles_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Delete Motorcycles data
if('DELETE_MOT' == $action){
    $motorcycles_id = $_POST['motorcycles_id'];
    $sql = "DELETE FROM $table WHERE motorcycles_id = $motorcycles_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}
?>