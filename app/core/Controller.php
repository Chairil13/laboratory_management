<?php

class Controller {
    
    public function view($view, $data = []) {
        extract($data);
        
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }

    public function model($model) {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model();
        } else {
            die('Model does not exist');
        }
    }

    public function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    public function isLoggedIn() {
        return isLoggedIn(); // Use helper function
    }

    public function requireLogin() {
        if (!isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }

    public function checkRole($allowedRoles = []) {
        if (!isLoggedIn()) {
            $this->redirect('auth/login');
        }

        if (!empty($allowedRoles) && !in_array(getUserRole(), $allowedRoles)) {
            $this->redirect('dashboard');
        }
    }
}
