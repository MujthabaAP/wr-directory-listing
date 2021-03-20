<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class helper {

    public $mysqli;

    function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "test";
        $dbname = "white_rabbit";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$sql = "INSERT INTO users (name, email, points, referal_code) VALUES ('John', 'john@example.com',0, 'ghj')";
            // use exec() because no results are returned
            //$conn->exec($sql);
            //echo "New record created successfully";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $this->mysqli = $conn;
    }

    public function getAllFiles() {
        $response = ['status' => 'failed', 'message' => 'No data found'];
        $sql = "SELECT * FROM `files` order by id desc";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            $response = ['status' => 'success', 'message' => 'data fetched successfully.', 'data' => $result];
        }
        return $response;
    }

    public function deleteFile($id) {
        $response = ['status' => 'failed', 'message' => 'The file id is empty.'];
        if (!empty($id)) {
            $sql = "UPDATE `files` SET `is_deleted`=true WHERE id='{$id}'";
            $stmt = $this->mysqli->prepare($sql);
            if (!empty($stmt->execute())) {
                $response = ['status' => 'success', 'message' => 'The file has been deleted',];
            }
        }

        return $response;
    }

    public function selectFileInfo($id) {
        $response = ['status' => 'failed', 'message' => 'The file id is empty.'];
        if (!empty($id)) {
            $sql = "SELECT * FROM `files` WHERE id='{$id}'";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (!empty($result)) {
                $response = ['status' => 'success', 'message' => 'data fetched successfully.', 'data' => $result[0]];
            }
        }

        return $response;
    }

}
