<?php
class M_subsrd_pay extends CI_Model {

    private $q_param = array();
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
     
    function list_data($client_date,$client_code,$user_id)
    {
        //$query=$this->db_jasgir->query("exec [subsrd_rekap_instruction_payment] '{$client_date}','{$client_code}'");
        $query=$this->db_jasgir->query("exec [subsrd_cso_list] '{$client_date}','{$client_code}'");
        $data=$query->result_array();
        return $data;
    }
    function get_data_cso($s_dt='1900-01-01',$client_code='',$s_src='',$s_dst='',$user_id='')
    { //echo "exec [subsrd_cso_get] '{$s_dt}','{$client_code}',{$s_src},{$s_dst}";
        $query=$this->db_jasgir->query("exec [subsrd_cso_get] '{$s_dt}','{$client_code}',{$s_src},{$s_dst}");
        $data=$query->result_array();
        return $data;
    }
    function get_data_closed($s_dt='1900-01-01',$client_code='',$s_src='',$s_dst='',$user_id='')
    { //echo "exec [subsrd_closed_get] '{$s_dt}','{$client_code}',{$s_src},{$s_dst}";
        $query=$this->db_jasgir->query("exec [subsrd_closed_get] '{$s_dt}','{$client_code}',{$s_src},{$s_dst}");
        $data=$query->result_array();
        return $data;
    }
    function get_printed_status($s_dt='1900-01-01',$client_code='',$s_src='',$s_dst='',$user_id='')
    {
        $query=$this->db_jasgir->query("exec [subsrd_cso_get_status] '{$s_dt}','{$client_code}',{$s_src},{$s_dst}");
        $data=$query->result_array();
        return $data;
    }
    function create_get_cso($param,$user_id='',$c_ref=1)
    {
        $query=$this->db_jasgir->query("exec [subsrd_cso_create] '{$param["s_dt"]}','{$param["s_code"]}','{$param["s_src"]}','{$param["s_dst"]}',{$param["s_sa"]},
            '{$param["s_refto"]}','{$param["s_refup"]}','{$param["s_reftelp"]}','{$param["s_reffax"]}','{$param["s_inst_dt"]}','{$param["s_via"]}',
            '{$param["s_remarks"]}','{$param["s_txn_date"]}','{$param["s_add_info"]}',{$param["s_charges"]},'{$user_id}','{$param["s_src_name"]}','{$param["s_dst_name"]}',{$c_ref}");
        $data=$query->result_array();
        return $data;
    }
    function get_cso($cso_id)
    {
        $query=$this->db_jasgir->query("exec [subsrd_cso_get_by_id] {$cso_id}");
        $data=$query->result_array();
        return $data;
    }
}
?>
