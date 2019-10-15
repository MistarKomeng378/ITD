<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasi_client_dlg extends CI_Controller { 
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
    function v_client()
    {
        if ($this->is_login())
            $this->load->view("itd_dlg_mutasi11_client",$this->data);
    }
    function v_client_search()
    {
        if ($this->is_login())
            $this->load->view("itd_dlg_mutasi11_client_search",$this->data);
    }
    function list_client_by_code()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param);
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);
        $data = $this->M_mutasi->list_client_by_code($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_client()
    {
        $this->load->model("M_mutasi");
        $data = $this->M_mutasi->list_client();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    } 
    function get_client()
    {
        $this->load->model("M_mutasi_client");
        $param=$this->input->post();
        sql_quot_all($param); 
        $data = $this->M_mutasi_client->get_client(0+$param["client_id"]);
        //$fields = array("created_dt","modified_dt");
        //add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    } 
    
    function save_client()
    {
        $this->load->model("M_mutasi_client");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $data=array();
        if(0+$param["client_id"]==0)
            $data = $this->M_mutasi_client->add_client($param['client_code'],$param['client_name'],$param['acc_no'],$param['client_cif'],$param['client_cbest'],$this->data['uid'],$param['client_user'],$param['bank_name'],$param['client_internal'],$param['client_jasgir'],$param['client_type']); 
        else
            $data = $this->M_mutasi_client->edit_client(0+$param['client_id'],$param['client_code'],$param['client_name'],$param['acc_no'],$param['client_cif'],$param['client_cbest'],$this->data['uid'],$param['client_user'],$param['bank_name'],$param['client_internal'],$param['client_jasgir'],$param['client_type']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_rek_client()
    {
        $this->load->model("M_mutasi_client");  
        $param=$this->input->post();
        sql_quot_all($param); 
        $data = $this->M_mutasi_client->edit_rek_client($param['client_code1'],$param['acc_no1'],$param['client_code2'],$param['acc_no2'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function search_client()
    {
        $this->load->model("M_mutasi_client");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $data = $this->M_mutasi_client->search_client($param['client_code'],$param['client_name'],$param['acc_no'],$param['client_cif'],$param['client_cbest'],$param['client_user']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
}
        
?>