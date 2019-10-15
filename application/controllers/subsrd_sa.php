<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsrd_sa extends CI_Controller { 
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
    
    function list_sa()
    {
        $param=$this->input->post();
        $param['c_enable'] = isset($param['c_enable'])?$param['c_enable']:'0';
        $this->load->model("M_subsrd_sa");
        $data = $this->M_subsrd_sa->list_sa($param["c_enable"]);
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_sa_by_name()
    {
        $param=$this->input->post();
        $param['sa_name'] = isset($param['q'])?$param['q']:'';
        $param['client_code'] = isset($param['par1'])?$param['par1']:'';
        sql_quot_all($param);
        $this->load->model("M_subsrd_sa");
        $data = $this->M_subsrd_sa->list_sa_by_name($param['sa_name'],$param['client_code'] );
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_sa_by_client()
    {
        $param=$this->input->post();
        $param['client_code'] = isset($param['q'])?$param['q']:'';
        sql_quot_all($param);
        $this->load->model("M_subsrd_sa");
        $data = $this->M_subsrd_sa->list_sa_by_client($param['q']);
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
            $this->load->view("subsrd_sa_dlg",$this->data);
            
        }
    }
    function add_sa()
    {
        $this->load->model("M_subsrd_sa");  
        $param=$this->input->post();
        sql_quot_all($param);        
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subsrd_sa->add_sa($param['b_cname'],$param['b_micode'],$param['b_enable'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_sa()
    {
        $this->load->model("M_subsrd_sa");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subsrd_sa->edit_sa($param['b_said'],$param['b_cname'],$param['b_micode'],$param['b_enable'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function enable_client()
    {
        $this->load->model("M_subsrd_sa");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_subsrd_sa->enable_client($param['b_id'],$param['b_ena'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_sa()
    {
        $this->load->model("M_subsrd_sa");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $b_id = isset($param['b_id'])?$param['b_id']:'0';
        $data = $this->M_subsrd_sa->get_sa($param['b_id']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function save_client()
    {
        $this->load->model("M_subsrd_sa");
        $data = $this->M_subsrd_sa->list_client();
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
        
        $this->load->view('subsrd_sa_save',$this->data);
    }
}
        
?>
