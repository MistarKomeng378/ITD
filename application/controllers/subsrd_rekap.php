<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsrd_rekap extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>array(),
                "url"=>base_url(),"uid"=>$this->session->userdata('itd_uid'),"lvl"=>$this->session->userdata('itd_lvl')
                ,"itd_user_unit"=>$this->session->userdata('itd_user_unit')); 
    } 
    function is_login()
    {
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    
    function list_data()
    {
        $param=$this->input->post();         
        $today=getdate();
        if(!isset($param["s_dt"]))
            $param["s_dt"]=substr('00'.$today["mday"],-2).'-'.substr('00'.$today["mon"],-2).'-'.$today["year"];
        if(!isset($param["s_dt2"]))
            $param["s_dt2"]=substr('00'.$today["mday"],-2).'-'.substr('00'.$today["mon"],-2).'-'.$today["year"];
        sql_quot_all($param);
        $param["s_dt"]=change_dt_format($param["s_dt"]);            
        $param["s_dt2"]=change_dt_format($param["s_dt2"]);          //print_r($param);
        $this->load->model("M_subsrd_rekap");
        $data = $this->M_subsrd_rekap->list_data($param['s_dt'],$param['s_dt2']);
        $fields = array("subsrd_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_excel()
    {
        $param=$this->input->post();  
        $today=getdate();
        if(!isset($param["s_dt"]))
            $param["s_dt"]=substr('00'.$today["mday"],-2).'-'.substr('00'.$today["mon"],-2).'-'.$today["year"];
        if(!isset($param["s_dt2"]))
            $param["s_dt2"]=substr('00'.$today["mday"],-2).'-'.substr('00'.$today["mon"],-2).'-'.$today["year"];
        sql_quot_all($param);
        $param["s_dt"]=change_dt_format($param["s_dt"]);            
        $param["s_dt2"]=change_dt_format($param["s_dt2"]);          //print_r($param);
        $this->load->model("M_subsrd_rekap");
        $data = $this->M_subsrd_rekap->list_data($param['s_dt'],$param['s_dt2']);
        $fields = array("subsrd_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="subs_rekap.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('subsrd_rekap_excel',$this->data);
    }                 
}
        
?>
