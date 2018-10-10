<?php

class Tutorial extends CI_Controller {

    public function index() {
        $this->load->view('paginamea');
    }

    public function functiaMihai(){
        echo "Functia lui Mihai";
    }
}
?>