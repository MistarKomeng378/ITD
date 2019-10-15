<?php
class M_user_parameter extends CI_Model {

    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function list_data()
    {                                                                                
        $query=$this->db->query("exec list_user_parameter");
        return $query->result_array();
    }
    function save_data($param)
    {
        $query=$this->db->query("exec update_user_parameter {$param["c_wrong"]},{$param["c_cycle"]},
        {$param["c_ex_pass"]},{$param["c_min"]},{$param["c_max"]},{$param["c_alpha"]},{$param["c_first"]},
        {$param["c_ex_log"]}");
        return $query->result_array();
    }
    
}
?>