<?php

class Response{
    public function send($statusCode = 200, $body = '', 
    $headers = []) {
        http_response_code($statusCode);
        
        foreach ($headers as $name => $value) {
            header("$name: $value");
        }

        echo json_encode($body);
    }
}
?>