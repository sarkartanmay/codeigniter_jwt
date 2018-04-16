<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Fruit extends CI_Model{
    public function getallfruit(){
      $this->db->select('fruit_id,name');
      $this->db->from('tbl_fruit');
      $query= $this->db->get();
      return $query->result();
    }
    public function newfruit($data){
      $this->db->insert('tbl_fruit',$data);
      if($this->db->affected_rows() > 0){
        return "Success";
      }else{
        $err= $this->db->error();
        if($err['code']===1062){
          $err['message'] ='Duplicate Entry Strictly Prohibited';
        }
        return $err;
      }
    }
}
?>
