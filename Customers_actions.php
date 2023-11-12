<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uc_showroom_joshua";
$table = "customers";

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
        customer_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR (255) NOT NULL,
        alamat VARCHAR (255) NOT NULL,
        id_card VARCHAR (255) NOT NULL,

    )";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Get All data from Customer Table
if('GET_ALL_CUS' == $action){
    $dbdata = array();
    $sql = "SELECT customer_id, nama, alamat, id_card FROM $table ORDER BY customer_id DESC";
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

//Create new Customer
if('ADD_CUS' == $action){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $id_card = $_POST['id_card'];
    $sql = "INSERT INTO $table (nama, alamat, id_card) VALUES('$nama', '$alamat', '$id_card')";
    $result = $conn->query($sql);
    echo 'success';
    return;
}

//Update Customer
if('UPDATE_CUS' == $action){
    $customer_id = $_POST['customer_id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $id_card = $_POST['id_card'];
    $sql = "UPDATE $table SET nama = '$nama', alamat = '$alamat', id_card = '$id_card' WHERE customer_id = $customer_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Delete Customer
if('DELETE_CUS' == $action){
    $customer_id = $_POST['customer_id'];
    $sql = "DELETE FROM $table WHERE customer_id = $customer_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}
?>