<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uc_showroom_joshua";
$table = "orders";

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
        order_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        kuantitas INT NOT NULL,
        total_biaya FLOAT NOT NULL,
        CONSTRAINT fk_customer_id FOREIGN KEY (customer_id) REFERENCES customers (customer_id) ON DELETE CASCADE ON UPDATE CASCADE,
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

//Get All data from Orders Table
if('GET_ALL_ORD' == $action){
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

//Get data from Orders Table by id
if('GET_ORD' == $action){
    $order_id = $_POST['order_id'];
    $dbdata = array();
    $sql = "SELECT * FROM $table WHERE order_id = $order_id";
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

//Create new Order
if('ADD_ORD' == $action){
    $kuantitas = $_POST['kuantitas'];
    $total_biaya = $_POST['total_biaya'];
    $customer_id = $_POST['customer_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $sql = "INSERT INTO $table (kuantitas, total_biaya, customer_id, vehicle_id,) VALUES('$kuantitas', '$total_biaya', '$customer_id, '$vehicle_id')";
    $result = $conn->query($sql);
    echo 'success';
    return;
}

//Update Order
if('UPDATE_ORD' == $action){
    $kuantitas = $_POST['kuantitas'];
    $total_biaya = $_POST['total_biaya'];
    $customer_id = $_POST['customer_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $sql = "UPDATE $table SET kuantitas = '$kuantitas', total_biaya = '$total_biaya', customer_id = '$customer_id', vehicle_id = '$vehicle_id', WHERE vehicle_id = $vehicle_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}

//Delete Order
if('DELETE_ORD' == $action){
    $order_id = $_POST['order_id'];
    $sql = "DELETE FROM $table WHERE order_id = $order_id";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    $conn->close();
    return;
}
?>