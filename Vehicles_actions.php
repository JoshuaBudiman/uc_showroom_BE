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
        tipe_bahan_bakar VARCHAR (255) NULL,
        luas_bagasi FLOAT NULL,
        ukuran_bagasi FLOAT NULL,
        kapasitas_bensin FLOAT NULL,
        jumlah_roda INT NULL,
        luas_kargo FLOAT NULL,

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
        $row = $result->fetch_assoc();
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
    $tipe_bahan_bakar = $_POST['tipe_bahan_bakar'];
    $luas_bagasi = $_POST['luas_bagasi'];
    $ukuran_bagasi = $_POST['ukuran_bagasi'];
    $kapasitas_bensin = $_POST['kapasitas_bensin'];
    $jumlah_roda = $_POST['jumlah_roda'];
    $luas_kargo = $_POST['luas_kargo'];

    $sql = "INSERT INTO $table (jenis, model, tahun, jumlah_penumpang, manufaktur, harga, tipe_bahan_bakar, luas_bagasi, ukuran_bagasi, kapasitas_bensin, jumlah_roda, luas_kargo) 
    VALUES('$jenis', '$model', '$tahun, '$jumlah_penumpang', '$manufaktur', '$harga', '$tipe_bahan_bakar', '$luas_bagasi', '$ukuran_bagasi', '$kapasitas_bensin', '$jumlah_roda', '$luas_kargo')";
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
    $tipe_bahan_bakar = $_POST['tipe_bahan_bakar'];
    $luas_bagasi = $_POST['luas_bagasi'];
    $ukuran_bagasi = $_POST['ukuran_bagasi'];
    $kapasitas_bensin = $_POST['kapasitas_bensin'];
    $jumlah_roda = $_POST['jumlah_roda'];
    $luas_kargo = $_POST['luas_kargo'];
    $sql = "UPDATE $table SET jenis = '$jenis', model = '$model', tahun = '$tahun', jumlah_penumpang = '$jumlah_penumpang', manufaktur = '$manufaktur', harga = '$harga', 
    tipe_bahan_bakar = '$tipe_bahan_bakar', luas_bagasi = '$luas_bagasi', ukuran_bagasi = '$ukuran_bagasi', kapasitas_bensin = '$kapasitas_bensin', jumlah_roda = '$jumlah_roda', luas_kargo = '$luas_kargo',
    WHERE vehicle_id = $vehicle_id";
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