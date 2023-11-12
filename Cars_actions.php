<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uc_showroom_joshua";
$table = "cars";

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
        cars_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tipe_bahan_bakar VARCHAR (255) NOT NULL,
        luas_bagasi FLOAT NOT NULL,
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

//Get All data from Cars Table
if('GET_ALL_CAR' == $action){
    $dbdata = array();
    $sql = "SELECT * FROM $table ORDER BY cars_id DESC";
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

//Get data from Cars Table by id
if('GET_CAR' == $action){
    $cars_id = $_POST['cars_id'];
    $dbdata = array();
    $sql = "SELECT * FROM $table WHERE cars_id = $cars_id";
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

//Create new Cars
if('ADD_CAR' == $action){
    $tipe_bahan_bakar = $_POST['tipe_bahan_bakar'];
    $luas_bagasi = $_POST['luas_bagasi'];
    $sql = "INSERT INTO $table (tipe_bahan_bakar, luas_bagasi,) VALUES('$tipe_bahan_bakar', '$luas_bagasi',)";
    $result = $conn->query($sql);
    echo 'success';
    return;
}

//Update Cars data
if('UPDATE_CAR' == $action){
    $cars_id = $_POST['cars_id'];
    $tipe_bahan_bakar = $_POST['tipe_bahan_bakar'];
    $luas_bagasi = $_POST['luas_bagasi'];
    $sql = "UPDATE $table SET tipe_bahan_bakar = '$tipe_bahan_bakar', luas_bagasi = '$luas_bagasi' WHERE cars_id = $cars_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Delete Cars
if('DELETE_CAR' == $action){
    $cars_id = $_POST['cars_id'];
    $sql = "DELETE FROM $table WHERE cars_id = $cars_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}
?>