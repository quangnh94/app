<?php

use Firebase\JWT\JWT;

session_start();

class auth {

    private $config;

    function __construct() {
        $this->config = require '././config.php';
    }

    public function actionLogin() {
        if (isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) {
            header("location: /index.php/auth/update");
        }
        //Handle login
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                "email" => isset($_POST['email']) && $_POST['email'] != '' ? $_POST['email'] : '',
                "password" => isset($_POST['password']) && $_POST['password'] != '' ? md5($_POST['password']) : '',
                "time" => time()
            ];
            $jwt = JWT::encode($data, $this->config['privateKey'], 'RS256');
            $url = "http://$_SERVER[HTTP_HOST]" . "/index.php/app/login";
            $result = $this->call($jwt, $url);
            if ($result->success) {
                $_SESSION['login_user'] = $result->data;
                header("location: /index.php/auth/update");
            } else {
                $_SESSION['error'] = "Tài khoản hoặc mật khẩu không chính xác";
            }
        }
        return include '././view/login.php';
    }

    public function actionLogout() {
        unset($_SESSION['login_user']);
        header("location: /index.php/auth/login");
    }

    public function actionUpdate() {
        if (!isset($_SESSION['login_user']) && empty($_SESSION['login_user'])) {
            header("location: /index.php/auth/login");
        }
        $user = $_SESSION['login_user'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                "name" => isset($_POST['name']) && $_POST['name'] != '' ? $_POST['name'] : '',
                "tel" => isset($_POST['tel']) && $_POST['tel'] != '' ? $_POST['tel'] : '',
                "address" => isset($_POST['address']) && $_POST['address'] != '' ? $_POST['address'] : '',
                "email" => isset($user) && $user->email != '' ? $user->email : '',
                "time" => time()
            ];
            $jwt = JWT::encode($data, $this->config['privateKey'], 'RS256');
            $url = "http://$_SERVER[HTTP_HOST]" . "/index.php/app/update";
            $result = $this->call($jwt, $url);
            if ($result->success) {
                $user->name = $data['name'];
                $user->tel = $data['tel'];
                $user->address = $data['address'];
                $_SESSION['login_user'] = $user;
                $_SESSION['success'] = "Cập nhật thông tin thành công";
            } else {
                $_SESSION['error'] = "Tài khoản hoặc mật khẩu không chính xác";
            }
        }
        return include '././view/update.php';
    }

    private function call($jwtToken, $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'token: ' . $jwtToken));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        //$result = json_decode($result);
        return json_decode($result);
    }

}
