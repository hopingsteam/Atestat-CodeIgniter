<?php

class Tutorial extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('user_model');
        $this->load->model('contact_model');
    }

    public function process_login(){
        $username = $this->input->post("username", TRUE);
        $parola = $this->input->post("password", TRUE);

        $this->form_validation->set_rules("username", "Utilizator", "trim|required");
        $this->form_validation->set_rules("password", "Parola", "trim|required");

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Datele introduse sunt incorecte.</div>');
            redirect("/login");
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
                                    'email' => $uresult[0]->email,
                                    'rol' => $uresult[0]->rol);
                $this->session->set_userdata($sess_data);
                redirect("/dashboard");
            }
            else
            {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Datele introduse sunt incorecte.</div>');
                redirect("/login");
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

    public function process_contact() {
        $this->form_validation->set_rules('name', 'Nume', 'trim|required|alpha|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('subject', 'Subiect', 'trim|required|alpha|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('message', 'Mesaj', 'trim|required|min_length[3]|max_length[30]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Nu ai respectat campurile.</div>');
            redirect("/contact");
        }
        else
        {
            $contact_email = $this->input->post('email');
            $contact_nume = $this->input->post('name');
            $contact_subiect = $this->input->post('subject');
            $contact_mesaj = $this->input->post('message');

            $data = array(
                'nume' => $contact_nume,
                'email' => $contact_email,
                'subiect' => $contact_subiect,
                'mesaj' => $contact_mesaj
            );

            if ($this->contact_model->insereaza_contact($data))
            {
                $mesajComplet = nl2br($contact_mesaj);
                $ipAddress = $this->input->ip_address();
                $dataTrimitere = date("Y-m-d H:i");
                $options = array(
                    'http' => array (
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen(http_build_query($data))."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context  = stream_context_create($options);
                $mesajComplet .= "Mesaj trimis de pe atestat in data de $dataTrimitere de pe IP: $ipAddress . Te pup!";

                $this->email->from($contact_email, $contact_nume);
                $this->email->to('whiteage13@yahoo.com');
                $this->email->subject($contact_subiect);
                $this->email->message($mesajComplet);
                $this->email->send();

                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Ai trimis mesajul cu succes!</div>');
                redirect('/contact');
            }
            else
            {
                // error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Eroare!</div>');
                redirect('/contact');
            }
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

    public function logout() {
        $this->session->sess_destroy();
        redirect('/login');
    }

    public function index() {
        $data = new stdClass();

        if($this->session->userdata('uid') == NULL)
            show_404();

        $data->rol = $this->session->userdata('rol');
        
        $this->load->view('templates/header');
        $this->load->view('pages/protected', $data);
        $this->load->view('templates/footer');
    }

    public function contact() {
        $this->load->view('templates/header');
        $this->load->view('pages/contact');
        $this->load->view('templates/footer');
    }
}
?>