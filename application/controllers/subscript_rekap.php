<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscript_rekap extends CI_Controller { 
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
    
    function list_rekap()
    {
        $this->load->model("M_subscript_rekap");
        $param=$this->input->post();
        $b_dt=isset($param["b_dt"])?change_dt_format($param["b_dt"]):"1900-01-01";
        $data = $this->M_subscript_rekap->list_rekap($b_dt);
        
        $fields = array("update_time");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function v_dlg()
    {
        if($this->isLogin)
        {
            $this->load->view("subscript_rekap_dlg",$this->data);
            
        }
    }
    function add_rekap()
    {
        $this->load->model("M_subscript_rekap");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_rekap_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subscript_rekap->add_rekap($param['b_ccode'],$param['b_cname'],$param['b_bcode'],
                    $param['b_bname'],$param['b_accno'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_rekap()
    {
        $this->load->model("M_subscript_rekap");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_rekap_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subscript_rekap->edit_rekap($param['b_id'],$param['b_ccode'],$param['b_cname'],$param['b_bcode'],
                    $param['b_bname'],$param['b_accno'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function enable_rekap()
    {
        $this->load->model("M_subscript_rekap");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_rekap_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subscript_rekap->enable_rekap($param['b_id'],$param['b_ena'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_rekap()
    {
        $this->load->model("M_subscript_rekap");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_rekap_by_code($param["client_code"]);    echo 
        
        $b_id = isset($param['b_id'])?$param['b_id']:0;
        $data = $this->M_subscript_rekap->get_rekap($param['b_id']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_rekap($p_dt='1900-01-01')
    {
        $this->load->model("M_subscript_rekap");
        $param=$this->input->post();
        $b_dt=isset($param["b_dt"])?change_dt_format($param["b_dt"]):"1900-01-01";
        $data = $this->M_subscript_rekap->list_rekap($b_dt);
        
        $fields = array("update_time");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $this->data["r_sdt"]= $p_dt;
        
        $filename="subs_rekap.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $this->load->view('subscript_rekap_save',$this->data);
    }
    
}
        
?>