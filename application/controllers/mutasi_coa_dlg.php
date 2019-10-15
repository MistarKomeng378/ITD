<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasi_coa_dlg extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin = $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>array(),
                "url"=>base_url(),"uid"=>$this->session->userdata('itd_uid'),"lvl"=>$this->session->userdata('itd_lvl')); 
    } 
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function v_coa()
    {
        if ($this->is_login())
            $this->load->view("itd_dlg_mutasi11_coa",$this->data);
    }
    function get_coa()
    {
        $this->load->model("M_mutasi_coa");
        $param=$this->input->post();
        sql_quot_all($param); 
        $data = $this->M_mutasi_coa->get_coa($param["coa_no"]);
        //$fields = array("created_dt","modified_dt");
        //add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_coa()
    {
        $this->load->model("M_mutasi_coa");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $data = $this->M_mutasi_coa->save_coa($param['coa_no'],$param['coa_desc'],$param['coa_dc'],0+$param['coa_enable'],0+$param['coa_order'],$this->data["uid"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    
}
        
?>