<?php
class M_subsrd_rekap extends CI_Model {

    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    function list_data($s_dt='1900-01-01',$s_dt2='1900-01-01')
    {  //echo "exec subsrd_balance_list '{$s_dt}'";
        //$query=$this->db_jasgir->query("exec subsrd_balance_list '{$s_dt}'");
        //$query=$this->db_jasgir->query("exec subsrd_mon '{$s_dt}'");
        $query=$this->db_jasgir->query("exec subsrd_mon_period '{$s_dt}','{$s_dt2}'");     
        $data=$query->result_array();
        return $data;
    }   
    
}
?>