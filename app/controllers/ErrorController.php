<?php
class ErrorController extends Controller {
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Display an error page with the given error code
     * 
     * @param int $code HTTP error code
     * @param string $message Optional error message (only shown in development)
     * @return string The rendered error view
     */
    public function show($code = 500, $message = '') {
        // Set the HTTP response code
        http_response_code($code);
        
        // Check if the specific error view exists
        $specificErrorView = APP_PATH . "/app/views/errors/{$code}.php";
        
        if (file_exists($specificErrorView)) {
            return $this->view("errors/{$code}", ['message' => $message]);
        } else {
            // Use the generic error page
            return $this->view('error', [
                'code' => $code,
                'message' => $message
            ]);
        }
    }
    
    /**
     * Handle 404 errors
     * 
     * @return string The rendered 404 error view
     */
    public function notFound() {
        return $this->show(404, 'Page not found');
    }
    
    /**
     * Handle 403 errors
     * 
     * @return string The rendered 403 error view
     */
    public function forbidden() {
        return $this->show(403, 'Access forbidden');
    }
    
    /**
     * Handle 500 errors
     * 
     * @param string $message Optional error message
     * @return string The rendered 500 error view
     */
    public function serverError($message = '') {
        return $this->show(500, $message);
    }
}
