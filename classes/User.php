<?php

class User {

    public $isAuthenticated = true;

    function __construct() {
        $this->isAuthenticated = isset($_SESSION["username"]) && isset(App::$app->users[$_SESSION["username"]]);
    }

    public function login($username) {
        $_SESSION["username"] = $username;
    }

    public function logout() {
        $_SESSION["username"] = null;
    }

}
