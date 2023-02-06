<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: X-Requested-With');



include('dbconnect.php');
$conn = new DbConnect();
$db = $conn->connect();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':

        $sql = 'SELECT * FROM users';
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($path[3]) && is_numeric($path[3])) {

            $sql .= ' WHERE id = :id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
            $stmt->execute();
            $users = $stmt->fetch(PDO::FETCH_ASSOC);

        } else {

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode($users);
        break;

    case 'POST':

        $user = json_decode(file_get_contents('php://input'));
        $sql = 'INSERT INTO users(id, name, email, mobile) VALUES (null, :name, :email, :mobile)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':mobile', $user->mobile);

        if ($stmt->execute()) {

            $data = ['status' => 1, 'message' => "New user created."];

        } else {

            $data = ['status' => 1, 'message' => "Operation failed."];

        }

        echo json_encode($data);
        break;

    case 'PUT':

        $user = json_decode(file_get_contents('php://input'));
        $sql = 'UPDATE users SET name= :name, email =:email, mobile =:mobile, WHERE id = :id';
        $stmt = $db->prepare($sql);
        $updated_at = date('Y-m-d');
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':mobile', $user->mobile);

        if($stmt->execute()) {

            $response = ['status' => 1, 'message' => 'Updated'];

        } else {
            $response = ['status' => 0, 'message' => 'Failed updating'];

        }

        echo json_encode($response);
        break;

    case 'DELETE':

        $sql = 'DELETE FROM users WHERE id = :id';
        $path = explode('/', $_SERVER['REQUEST_URI']);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $path[3]);

        if($stmt->execute()){

            $response = ['status' => 1, 'message' => 'Successfully deleted'];

        } else {

            $response = ['status' => 0, 'message' => 'Failed when trying to delete'];

        }
        
        echo json_encode($response);
        break;
}
