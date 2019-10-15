<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsrd_acc extends CI_Controller { 
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
    
    function list_acc()
    {
        $this->load->model("M_subsrd_acc");
        $data = $this->M_subsrd_acc->list_acc();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_acc_by_client_sa()
    {
        $param=$this->input->post();         
        $param['client_code'] = isset($param['par1'])?$param['par1']:'';
        $param['acc_type'] = isset($param['par2'])?$param['par2']:'0';
        $param['sa_id'] = isset($param['q'])?$param['q']:'0';
        sql_quot_all($param);
        $this->load->model("M_subsrd_acc");
        $data = $this->M_subsrd_acc->list_acc_by_client_sa($param['client_code'],$param['sa_id'],$param['acc_type']);
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function list_type()
    {
        $this->load->model("M_subsrd_acc");
        $data = $this->M_subsrd_acc->list_type();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function v_dlg()
    {
        if($this->isLogin)
        {
            $this->load->view("subsrd_acc_dlg",$this->data);
            
        }
    }
    function add_acc()
    {
        $this->load->model("M_subsrd_acc");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subsrd_acc->add_acc($param['b_type'],$param['b_sid'],$param['b_bcode'],$param['b_ccode'],$param['b_no'],$param['b_name'],$param['b_enable'],$param['b_to'],$param['b_up'],$param['b_telp'],$param['b_fax'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_acc()
    {
        $this->load->model("M_subsrd_acc");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subsrd_acc->edit_acc($param['b_aid'],$param['b_type'],$param['b_sid'],$param['b_bcode'],$param['b_ccode'],$param['b_no'],$param['b_name'],$param['b_enable'],$param['b_to'],$param['b_up'],$param['b_telp'],$param['b_fax'],$this->data['uid']);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function enable_client()
    {
        $this->load->model("M_subsrd_acc");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subsrd_acc->enable_client($param['b_id'],$param['b_ena'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_acc()
    {
        $this->load->model("M_subsrd_acc");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $b_id = isset($param['b_id'])?$param['b_id']:'';
        $data = $this->M_subsrd_acc->get_acc($param['b_id']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function save_client()
    {
        $this->load->model("M_subsrd_acc");
        $data = $this->M_subsrd_acc->list_client();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        
        $filename="subs_client.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $this->load->view('subsrd_acc_accve',$this->data);
    }
}
        
?>
