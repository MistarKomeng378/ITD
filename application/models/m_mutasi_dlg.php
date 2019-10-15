<?php
class M_mutasi_dlg extends CI_Model {

    private $q_param = array();
    private $db_itd;
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
        $this->db_itd = $this->load->database('default',true);
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    function get_login_info($user,$pass)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function list_mutasi($client_code='',$acc_no='',$mon=0,$year=0)
    { //echo "exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [list_mutasi] '{$client_code}','{$acc_no}',{$mon},{$year}");
        $data=$query->result_array();
        return $data;
    }
    function list_mutasi_by_dt($client_code='',$acc_no='',$dt='1900-01-01')
    { //echo "exec [list_mutasi_by_date] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [list_mutasi_by_date] '{$client_code}','{$acc_no}','{$dt}'");
        $data=$query->result_array();
        return $data;
    }
    function list_mutasi_by_coa($dt='1900-01-01',$coa='C001')
    { //echo "exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [list_trx_by_coa] '{$dt}','{$coa}'");
        $data=$query->result_array();
        return $data;
    }
    function get_last_balance($client_code='',$acc_no='')
    { //echo "exec [get_last_balance] '{$client_code}','{$acc_no}'";
        $query=$this->db_jasgir->query("exec [get_last_balance] '{$client_code}','{$acc_no}'");
        $data=$query->result_array();
        return $data;
    }
    function add_mutasi_giro($v_dt,$a_dt,$c_rate,$c_tenor,$c_year,$c_code,$c_name,$c_accno,$c_nml,$c_int,$c_int_tax,$c_int_net,$add,$user_id)
    {//cho "exec [add_mutasi_giro]  '{$v_dt}','{$a_dt}',{$c_rate},{$c_tenor},{$c_year},'{$c_code}','{$c_name}','{$c_accno}',{$c_nml},{$c_int},{$c_int_tax},{$c_int_net},'{$user_id}',{$add}";
        $query=$this->db_jasgir->query("exec [add_mutasi_giro]  '{$v_dt}','{$a_dt}',{$c_rate},{$c_tenor},{$c_year},'{$c_code}','{$c_name}','{$c_accno}',{$c_nml},{$c_int},{$c_int_tax},{$c_int_net},'{$user_id}',{$add}");
        $data=$query->result_array();
        return $data;
    }
    function get_giro($giro_id=0)
    { //echo "exec [get_last_balance] '{$client_code}','{$acc_no}'";
        $query=$this->db_jasgir->query("exec [get_giro] {$giro_id}");
        $data=$query->result_array();
        return $data;
    }
    function get_giro_val_asof($c_code='',$acc_no='',$c_dt='1900-01-01',$v_dt='1900-01-01')
    { //echo "exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [get_giro_val_asof] '{$c_code}','{$acc_no}','{$c_dt}','{$v_dt}'");
        $data=$query->result_array();
        return $data;
    }
    function list_jasa_giro_by_date($dt='1900-01-01')
    { //echo "exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [list_jasa_giro_by_date] '{$dt}'");
        $data=$query->result_array();
        return $data;
    }
    function get_last_param($param_name='')
    { //echo "exec [get_balance] '{$client_code}','{$acc_no}','{$dt}'";
        $query=$this->db_jasgir->query("exec [get_last_param] '{$param_name}'");
        $data=$query->result_array();
        return $data;
    }
    function get_giro_val_asof_by_user($c_dt='1900-01-01',$v_dt='1900-01-01',$user_id='')
    { 
        $query=$this->db_jasgir->query("exec [get_giro_val_asof_by_user] '{$c_dt}','{$v_dt}','{$user_id}'");
        $data=$query->result_array();
        return $data;
    }
    function get_giro_val_asof_by_user1($v_dt='1900-01-01',$user_id='',$tipe=0)
    { 
        $query=$this->db_jasgir->query("exec [get_giro_val_asof_by_user1] '{$v_dt}','{$user_id}',{$tipe}");
        $data=$query->result_array();
        return $data;
    }
}
?>
