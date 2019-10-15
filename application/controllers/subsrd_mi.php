<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsrd_mi extends CI_Controller { 
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
    
    function list_mi()
    {
        $this->load->model("M_subsrd_mi");
        $data = $this->M_subsrd_mi->list_mi();
        $fields = array("modified_dt");
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
            $this->load->view("subsrd_mi_dlg",$this->data);
            
        }
    }
    function add_mi()
    {
        $this->load->model("M_subsrd_mi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_mi_by_code($param["mi_code"]);    echo 
        
        $data = $this->M_subsrd_mi->add_mi($param['b_ccode'],$param['b_cname'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_mi()
    {
        $this->load->model("M_subsrd_mi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_mi_by_code($param["mi_code"]);    echo 
        
        $data = $this->M_subsrd_mi->edit_mi($param['b_ccode'],$param['b_cname'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_mi()
    {
        $this->load->model("M_subsrd_mi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_mi_by_code($param["mi_code"]);    echo 
        
        $b_id = isset($param['b_id'])?$param['b_id']:'';
        $data = $this->M_subsrd_mi->get_mi($param['b_id']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function save_mi()
    {
        $this->load->model("M_subsrd_mi");
        $data = $this->M_subsrd_mi->list_mi();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        
        $filename="subs_mi.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $this->load->view('subsrd_mi_save',$this->data);
    }
}
        
?>
