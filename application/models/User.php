<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class User extends CI_Model{
    public function loginCheck($data){
        $this->db->select('first_name,last_name,user_typ');
        $this->db->from('tbl_user');
        $where = "email='".$data['email']."' AND password='".$data['pwd']."' and user_status='1'" ;
        $this->db->where($where);
        $query= $this->db->get();
        return $query->result();
    }
    public function newstudent($data){
        $this->db->insert('tbl_user',$data);
    }
}
?>
