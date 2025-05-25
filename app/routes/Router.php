<?php
class Router {
    private $routes = [];
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        
        // Start or resume the session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Set session cookie parameters for better security
        session_set_cookie_params([
            'lifetime' => SESSION_LIFETIME,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        
        // Update session timestamp on every request if user is logged in
        if (isset($_SESSION['user_id'])) {
            $_SESSION['last_activity'] = time();
        }
        
        // Check for session timeout
        if (isset($_SESSION['last_activity']) && 
            (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
            // Session has expired, destroy it and redirect to login
            session_unset();
            session_destroy();
            header('Location: /login');
            exit;
        }
    }
    
    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function match($method, $path) {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#";
            
            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                unset($params[0]);
                
                $controller = new $route['controller']();
                return [$controller, $route['action'], $params];
            }
        }
        
        return false;
    }
    
    public function dispatch() {
        // Update session timestamp on every request if user is logged in
        if (isset($_SESSION['user_id'])) {
            $_SESSION['last_activity'] = time();
        }
        
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $match = $this->match($method, $path);
        
        if ($match) {
            list($controller, $action, $params) = $match;
            try {
                // Extract the values from the associative array to pass as positional parameters
                $paramValues = array_values($params);
                return call_user_func_array([$controller, $action], $paramValues);
            } catch (Exception $e) {
                error_log($e->getMessage());
                return $this->error(500);
            }
        }
        
        return $this->error(404);
    }
    
    private function error($code) {
        $errorController = new ErrorController();
        return $errorController->show($code);
    }
}
