<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Fruit extends CI_Model{
    public function getallfruit(){
      $this->db->select('fruit_id,name');
      $this->db->from('tbl_fruit');
      $query= $this->db->get();
      return $query->result();
    }
}
?>
