<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uc_showroom_joshua";
$table = "vehicles";

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
        vehicle_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        jenis VARCHAR (255) NOT NULL,
        model VARCHAR (255) NOT NULL,
        tahun INT NOT NULL,
        jumlah_penumpang INT NOT NULL,
        manufaktur VARCHAR (255) NOT NULL,
        harga FLOAT NOT NULL,

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
if('GET_ALL_VEH' == $action){
    $dbdata = array();
    $sql = "SELECT * FROM $table ORDER BY vehicle_id DESC";
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

//Get data from Vehicles Table by id
if('GET_VEH' == $action){
    $vehicle_id = $_POST['vehicle_id'];
    $dbdata = array();
    $sql = "SELECT * FROM $table WHERE vehicle_id = $vehicle_id";
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

//Create new Vehicles
if('ADD_VEH' == $action){
    $jenis = $_POST['jenis'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $jumlah_penumpang = $_POST['jumlah_penumpang'];
    $manufaktur = $_POST['manufaktur'];
    $harga = $_POST['harga'];
    $sql = "INSERT INTO $table (jenis, model, tahun, jumlah_penumpang, manufaktur, harga) VALUES('$jenis', '$model', '$tahun, '$jumlah_penumpang', '$manufaktur', '$harga')";
    $result = $conn->query($sql);
    echo 'success';
    return;
}

//Update Vehicle
if('UPDATE_VEH' == $action){
    $vehicle_id = $_POST['vehicle_id'];
    $jenis = $_POST['jenis'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $jumlah_penumpang = $_POST['jumlah_penumpang'];
    $manufaktur = $_POST['manufaktur'];
    $harga = $_POST['harga'];
    $sql = "UPDATE $table SET jenis = '$jenis', model = '$model', tahun = '$tahun', jumlah_penumpang = '$jumlah_penumpang', manufaktur = '$manufaktur', harga = '$harga' WHERE vehicle_id = $vehicle_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Delete Vehicle
if('DELETE_VEH' == $action){
    $vehicle_id = $_POST['vehicle_id'];
    $sql = "DELETE FROM $table WHERE vehicle_id = $vehicle_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}
?>