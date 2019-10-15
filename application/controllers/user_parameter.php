<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_parameter extends CI_Controller { 
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
    function v_content()
    {
        if($this->isLogin)
            $this->load->view('user_parameter',$this->data);
    }  
    function list_data()
    {
        $this->load->model("M_user_parameter");  
        $data = $this->M_user_parameter->list_data(); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo @json_encode($this->data);
    }
    function save_data()
    {
        $param=$this->input->post();
        sql_quot_all($param); 
        $this->load->model("M_user_parameter");
        $data = $this->M_user_parameter->save_data($param); 
        if(count($data)>0)
            echo $data[0]["err_no"];
    }
}
        
?>