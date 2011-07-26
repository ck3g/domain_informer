<?php

 
class DomainController extends ApplicationController {

    public function __construct() {
        parent::__construct( 'domain' );
    }

    public function index() {

        $this->render();
    }

    public function show_results() {
        $domain_list = isset( $_POST['domains'] ) ? (array)$_POST['domains'] : array();

        $this->info = array();
        foreach ($domain_list as $url) {
            if (empty($url))
                continue;
            
            $domain = new Domain($url);
            $this->info[] = $domain->GetInfo();
        }
        
        $this->render('show_results');
    }
}
