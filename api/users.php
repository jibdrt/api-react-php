<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: X-Requested-With');



include('dbconnect.php');
$conn = new DbConnect();
$db = $conn->connect();
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case "GET":
        $sql = "SELECT * FROM users";
        $path = explode('/', $_SERVER['REQUEST_URI']);

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
        echo json_encode($users);
        break;
    case 'POST';
        $user = json_decode(file_get_contents('php://input'));
        $sql = 'INSERT INTO users(id, name, mobile, created_at) values (null, :name, :email, :mobile, :created_at)';
        $stmt = $db->prepare($sql);
        $date = date('Y-m-d');
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':mobile', $user->mobile);
        $stmt->bindParam(':created_at', $user->$date);
        if ($stmt->execute()) {
            $data = ['status' => 1, 'message' => "New user created."];
        } else {
            $data = ['status' => 1, 'message' => "Operation failed."];
        }
        echo json_encode($data);
}

