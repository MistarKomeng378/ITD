<?php
class M_itd_report_dlg extends CI_Model {


    function __construct()
    {                                     
        parent::__construct();           
        $this->load->database('default');
    }
    function report11_search($tipe=1,$c_code='',$s_dt='1900-01-01',$e_dt='1900-01-01')
    {
        //echo "exec report_search_trx {$tipe},'{$c_code}','{$s_dt}','{$e_dt}'";
        $query=$this->db->query("exec report_search_trx {$tipe},'{$c_code}','{$s_dt}','{$e_dt}'");
        $data=$query->result_array();
        return $data;
    }
}
?>