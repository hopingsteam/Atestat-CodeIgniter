<?php

class Tutorial extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $this->load->view('paginamea');
    }

    public function functiaMihai(){
        $data = array(
            'nume' => 'Popescu',
            'prenume' => 'Andrei',
            'username'=> 'uzerprietenos',
            'parola' => 'parola1',
            'email' => 'emailsmecher',
            'rol' => 1,
        );

        $this->user_model->insereaza_utilizator($data);
    }

    public function updateazaUser(){
        $data = array(
            'nume' => 'Ilie',
            'prenume' => 'Mihai',
        );

        $this->user_model->update_utilizator($data, 5);
    }

    public function stergeUser(){
        $this->user_model->sterge_utilizator(5);
    }

    public function extrageUser(){
        $result = $this->user_model->extrage_date(4);
        echo $result[0]->prenume;
    }
}
?>