<?php

class User_model extends CI_Model
{
    function insereaza_utilizator($data)
    {
        return $this->db->insert("utilizatori", $data);
    }

    function update_utilizator($data, $id_user)
    {
        $this->db->where('ID', $id_user);
        return $this->db->update('utilizatori', $data);
    }

    function sterge_utilizator($id_user) {
        $this->db->where('ID', $id_user);
        return $this->db->delete('utilizatori');
    }

    function extrage_date($id_user){
        $this->db->where('ID', $id_user);
        $query = $this->db->get('utilizatori');
        return $query->result();
    }
}