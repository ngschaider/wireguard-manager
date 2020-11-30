<?php


class Request {
    public $method;

    public $isGetRequest;
    public $isPostRequest;

    function __construct() {
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->isPostRequest = $this->method === "POST";
        $this->isGetRequest = $this->method === "GET";
    }

    public function get($name, $default=null) {
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }

    public function post($name, $default=null) {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

}
