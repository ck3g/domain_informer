<?php

 
class DomainController extends ApplicationController {

    public function __construct() {
        parent::__construct( 'domain' );
        include(PHP_ROOT . '/app/models/domain.php');
    }

    public function index() {
        if (Config::ENV == Environment::DEVELOPMENT)
            $this->domains_list = "homebugh.info\nmmo-champion.com\nhabrahabr.ru\nuniofweb.ru\nhttp://www.fitnessadvisors.co.uk/";
        else
            $this->domains_list = '';

        $this->render();
    }

    public function show_results() {

        $this->domains = isset($_POST['domains']) ? $_POST['domains'] : '';
        $domain_list = preg_split("/\r\n|\r|\n/", $this->domains);

        $this->info = array();
        $p_excel = new PHPExcel();
        $sheet_index = 0;
        foreach ($domain_list as $url) {
            if (empty($url))
                continue;
            
            $domain = new Domain($url);
            $domain_info = $domain->GetInfo();
            $this->info[] = $domain_info;

            $p_excel = DomainModel::PopulateSheet($domain_info, $p_excel, $sheet_index);

            $sheet_index++;
        }

        $p_excel->setActiveSheetIndex();
        $obj_writer = new PHPExcel_Writer_Excel5($p_excel);
        $filename = PHP_ROOT . '/tmp/results.xls';
        $obj_writer->save($filename);
        
        $this->render('show_results');
    }
}
