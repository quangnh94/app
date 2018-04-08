<?php

use Firebase\JWT\JWT;

class app {

    private $config;
    private $token;

    function __construct() {
        $header = getallheaders();
        $this->config = require '././config.php';
        $this->token = $header['token'];
    }

    public function actionLogin() {
//        header('Content-Type: application/json');
        header('content-type: text/html; charset=utf-8');
        $connect = null;
        $data_result = ["success" => 0, 'data' => [], 'message' => ''];
        try {
            if (!empty($this->token)) {
                $decoded = JWT::decode($this->token, $this->config['publicKey'], array('RS256'));
                $connect = mysqli_connect($this->config['host'], $this->config['username'], $this->config['password'], $this->config['db_name']) or die("Cannot connect to database");
                $connect->set_charset("utf8");
                if (isset($decoded->email) && isset($decoded->password) && $decoded->email != '' && $decoded->password != '') {
                    $sql = "SELECT * FROM user WHERE email = '" . $decoded->email . "' AND password = '" . $decoded->password . "' LIMIT 1";
                    $result = mysqli_query($connect, $sql);
                    if (isset($result->num_rows) && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $data_result['data'] = array_map('utf8_encode', $row);
                        }
                    } else {
                        $data_result['message'] = "0 result";
                    }
                    //$data_result['data'] not empty -> response to client data and close connection
                    if (!empty($data_result['data'])) {
                        $data_result['message'] = "Get data success";
                        $data_result['success'] = 1;
                    }
                    $encode = json_encode($data_result);
                    //check encode
                    if ($encode) {
                        echo $encode;
                    }
                }
            }
        } catch (Exception $exc) {
            var_dump($exc->getMessage());
        }
    }

    public function actionUpdate() {
//        header('Content-Type: application/json');
        header('content-type: text/html; charset=utf-8');
        $connect = null;
        $data_result = ["success" => 0, 'data' => [], 'message' => ''];
        try {
            if (!empty($this->token)) {
                $decoded = JWT::decode($this->token, $this->config['publicKey'], array('RS256'));
                $connect = mysqli_connect($this->config['host'], $this->config['username'], $this->config['password'], $this->config['db_name']) or die("Cannot connect to database");
                mysqli_set_charset($connect, "utf8");
                if (isset($decoded->name) && isset($decoded->address) && isset($decoded->tel) && $decoded->name != '' && $decoded->address != '' && $decoded->tel != '') {
                    $sql = "UPDATE user SET name = '" . $decoded->name . "', address = '" . $decoded->address . "', tel = '" . $decoded->tel . "' WHERE email = '" . $decoded->email . "'";
                    if ($connect->query($sql)) {
                        $data_result['message'] = "Update data success";
                        $data_result['success'] = 1;
                    } else {
                        $data_result['message'] = "Update data fail";
                    }
                    //$data_result['data'] not empty -> response to client data and close connection
                    $encode = json_encode($data_result);
                    //check encode
                    if ($encode) {
                        echo $encode;
                    }
                }
            }
        } catch (Exception $exc) {
            var_dump($exc->getMessage());
        }
    }

}
