<?php

class Response {

    public $headers = [];
    public $content = "";

    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
    }

    public function getHeader($name) {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    public function send() {
        foreach($this->headers as $name => $value) {
            header($name . ": " . $value);
        }

        echo $content;
    }

}
