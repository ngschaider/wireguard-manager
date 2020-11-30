<?php

class App {

    public static $app = null;

    public $user;

    public $users = [
        "admin" => "123",
    ];

    public $request;
    public $basePath = null;
    public $name = "";

    function __construct()  {
        if(self::$app !== null) {
            throw new Exception("Class " . __CLASS__ . " can only be instantiated once.");
        }
        self::$app = $this;
    }

    function __clone() {
        throw new Exception("Class " . __CLASS__ . " cannot be cloned.");
    }

    function run() {
        session_start();

        $this->user = new User();
        $this->request = new Request();

        $route = isset($_GET["r"]) ? $_GET["r"] : "site/index";
        $splits = explode("/", $route);

        $controllerName = $splits[0];
        $actionName = count($splits) === 2 ? $splits[1] : "index";

        $controllerClassName = ucfirst($controllerName) . "Controller";
        $actionMethodName = "action" . ucfirst($actionName);

        $controller = new $controllerClassName();
        $response = $controller->$actionMethodName();

        if($response instanceof Response) {
            $response->send();
        } else {
            echo $response;
        }
    }

}
