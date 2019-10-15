<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasi_bf extends CI_Controller { 
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
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    

    function list_bf()
    {
        $this->load->model("M_mutasi_bf");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        $data = $this->M_mutasi_bf->list_bf($param["coa"],$param["tipe"],$param["dt1"],$param["dt2"]); 
        $fields = array("fb_dt","fb_doc_accepted_dt",'fb_settle_dt');
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_list_balance()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        $data = $this->M_mutasi->list_balance($param["dt1"],$param["dt2"]); 
        $fields = array("balance_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="balance_{$param["dt1"]}.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_balance',$this->data);
    }
}
        
?>