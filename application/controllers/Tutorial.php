<?php

class Tutorial extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
        $this->load->model('user_model');
    }

    public function process_login(){
        $username = $this->input->post("username", TRUE);
        $parola = $this->input->post("password", TRUE);

        $this->form_validation->set_rules("username", "Utilizator", "trim|required");
        $this->form_validation->set_rules("password", "Parola", "trim|required");

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Datele introduse sunt incorecte.</div>');
            redirect("tutorial/login");
        }
        else
        {
            $uresult = $this->user_model->get_user($username, $parola);
            if (count($uresult) > 0)
            {
                $sess_data = array( 'loggedin' => TRUE,
                                    'uname' => $uresult[0]->username,
                                    'uid' => $uresult[0]->ID,
                                    'prenume' => $uresult[0]->prenume,
                                    'nume' => $uresult[0]->nume,
                                    'email' => $uresult[0]->email);
                $this->session->set_userdata($sess_data);
                redirect("tutorial/");
            }
            else
            {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Datele introduse sunt incorecte.</div>');
                redirect("tutorial/login");
            }
        }
    }

    public function process_register() {
        $this->form_validation->set_rules('nume', 'Nume', 'trim|required|alpha|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('prenume', 'Prenume', 'trim|required|alpha|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('username', 'Utilizator', 'trim|required|is_unique[utilizatori.username]');
        $this->form_validation->set_rules('email', 'Mail', 'trim|required|valid_email|is_unique[utilizatori.email]');
        $this->form_validation->set_rules('password', 'Parola', 'trim|required|md5');
        $this->form_validation->set_rules('cpassword', 'Confirma Parola', 'trim|required|matches[password]|md5');

        $data = array(
            'prenume' => $this->input->post('prenume'),
            'nume' => $this->input->post('nume'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'parola' => $this->input->post('password'),
            'rol' => 1
        );

        if ($this->user_model->insereaza_utilizator($data))
        {
            $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Te-ai inregistrat cu succes! Acum te poti autentifica!</div>');
            redirect('tutorial/login');
        }
        else
        {
            // error
            $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Eroare!</div>');
            redirect('tutorial/register');
        }

    }

    public function login() {
        $this->load->view('templates/header');
        $this->load->view('pages/login');
        $this->load->view('templates/footer');
    }

    public function register() {
        $this->load->view('templates/header');
        $this->load->view('pages/register');
        $this->load->view('templates/footer');
    }

    public function index() {
        if($this->session->userdata('uid') == NULL)
            show_404();

        $this->load->view('templates/header');
        $this->load->view('pages/protected');
        $this->load->view('templates/footer');
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