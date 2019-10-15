<?php
class M_itd_duedate extends CI_Model {

    private $q_param = array();
    private $db_itd;
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_itd = $this->load->database('default',true);
        //$this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function list_data($dt,$lte=0)
    {
        $query=$this->db_itd->query("exec list_trx_due '{$dt}','{$lte}'");
        $data=$query->result_array();
        return $data;
    }
}
?>