<?php

class Contact_model extends CI_Model
{
    function insereaza_contact($data)
    {
        return $this->db->insert("contact", $data);
    }
}