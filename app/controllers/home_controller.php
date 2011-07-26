<?php

class HomeController extends ApplicationController {

    public function __construct() {
        parent::__construct( 'home' );
    }

    public function index() {

        $this->redirect('?controller=domain');
        $this->render();
    }

}
