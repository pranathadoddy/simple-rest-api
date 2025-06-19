<?php

    class Router{
        private $routes = [];

        

        public function addRoute($method, $path, $callback) {
            $this->routes[] = [
                'method' => strtoupper($method),
                'path' => $path,
                'callback' => $callback
            ];
        }

        /* 
 GET localhost/student/ -> localhost/student/
 GET localhost/student/{id} -> localhost/student/1
 POST localhost/student/
 PUT localhost/student/{id}
 DELETE localhost/student/{id}
 PATCH localhost/student/{id}/files/{fileId}

  GET localhost/teacher/
*/
        public function handleRequest(){
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];
            $path = parse_url($uri, PHP_URL_PATH);

            foreach ($this->routes as $route) {
               if($this->matchRoute($route, $path, $method)) {
                    $params = $this->getParams($route, $path);

                    $request = new Request($params);
                    $response = new Response();

                    try {
                        [$controllerName, $handlerName] =$route['callback'];

                        $controller = new $controllerName();
                        if(method_exists($controller, $handlerName)) {
                            return $controller->$handlerName($request, $response);
                        } else {
                            $response->send(404, ['message' => 'Handler not found']);
                            return $response;
                        }
                    } catch (Exception $e) {
                        $response->send(500, ['message' => 'Internal Server Error']);
                        return $response;
                    }
                    
                }
            }
        }

        public function matchRoute($route, $path, $method): bool{
            if( $route['method'] !== $method) {
                return false;
            }

            $routePath = $route['path'];
            /*
                GET localhost/student/
                GET localhost/student/{id}
                GET localhost/student/{id}/details

                #^localhost/student/([^/]+)$# 
            */
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);

            $pattern = '#^' . $pattern . '$#';

            return preg_match($pattern, $path, $matches);
        }

        public function getParams($route, $path): array {
            $params = [];
            preg_match_all('/\{([^}]+)\}/', $route['path'], $paramNames);
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';
            preg_match($pattern, $path, $matches);
            array_shift($matches); 
            for( $i = 0; $i < count($paramNames[1]); $i++) {
                $params[$paramNames[1][$i]] = $matches[$i] ?? null;
            }

            return $params;
        }
    }

?>