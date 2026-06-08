<?php

class HomeController extends Controller {
    
    public function index() {
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        } else {
            $this->view('home/index', [
                'title' => 'Beranda'
            ]);
        }
    }
}
