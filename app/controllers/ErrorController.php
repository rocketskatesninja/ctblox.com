<?php
class ErrorController extends Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function show($code) {
        http_response_code($code);
        return $this->view("errors/{$code}");
    }
}
