<?php
class M_trxos extends CI_Model {

    private $q_param = array();
    private $db_itd;
    private $db_jasgir;
    function __construct()
    {                                     
        parent::__construct();           
         $this->db_itd = $this->load->database('default',true);
        $this->db_jasgir = $this->load->database('dbjasgir',true);
    }
    function get_login_info($dt)
    {                                                                                
        $query=$this->db->query("exec get_user_info '{$user}','" . md5($pass) . "'");
        $data=$query->result_array();
        return $data;
    }
    function c($dt)
    {
        $this->db_jasgir->query("delete from tb_balance_trx where trade_date='{$dt}'");
    }
    function u($dt_t,$dt_s,$pfcode,$pfname,$seccode,$secname,$t,$unit,$bal)
    {
        $this->db_jasgir->query("insert into tb_balance_trx(trade_date, settle_date, pfcode, pfname, seccode, secname, trxtype, unit, os)
            values('{$dt_t}','{$dt_s}','{$pfcode}','{$pfname}','{$seccode}','{$secname}','{$t}','{$unit}','{$bal}')");
    }
    function l($dt)
    {
        //echo "exec list_trx '{$trx_date}','{$user_id}'";
        $query=$this->db_jasgir->query("select * from tb_balance_trx  where trade_date='{$dt}' order by pfcode,seccode");
       // echo "exec list_tc5 '{$trx_date}','{$client_code}','{$bnf_bank}','{$bnf_name}'";
        $data=$query->result_array();
        return $data;
    }
    
    
}
?>