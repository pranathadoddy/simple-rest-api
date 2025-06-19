<?php

class Request {
   
    private $queryParams = [];
    private $body;

    public function __construct($params = []) {
        
        $this->body = json_decode(file_get_contents('php://input'), true) ?? []; ;
        $this->queryParams = $params;
    }

    public function getBody() {
        return $this->body;
    }

}