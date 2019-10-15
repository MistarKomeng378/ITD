<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsrd_rekon extends CI_Controller { 
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
    function index()
    {        
    }
    function view()
    {
        $d=getdate();
        
        $param=$this->input->post(); 
        $param["q"]=isset($param["q"])?$param["q"]:"{$d['mday']}-{$d['mon']}-{$d['year']}";
        $param["t"]=isset($param["t"])?$param["t"]:"0";
        sql_quot_all($param);
        $dt=change_dt_format($param["q"]);
        $this->data['dt']=$dt;
        $this->data['t']=$param["t"];
        $this->load->model("M_subsrd");  
        $this->data['r_data'] = $this->M_subsrd->rekon_vs_urs($dt,$param['t']);
         $this->load->view('subsrd_rekon',$this->data);
    }
    function view_html()
    {
        $d=getdate();
        
        $param=$this->input->post(); 
        $param["q"]=isset($param["q"])?$param["q"]:"{$d['mday']}-{$d['mon']}-{$d['year']}";
        $param["t"]=isset($param["t"])?$param["t"]:"0";
        sql_quot_all($param);
        $dt=change_dt_format($param["q"]);
        $this->data['dt']=$dt;
        $this->data['t']=$param["t"];
        $this->load->model("M_subsrd");  
        $this->data['r_data'] = $this->M_subsrd->rekon_vs_urs($dt,$param['t']);
         $this->load->view('subsrd_rekon_html',$this->data);
    }
      
}
        
?>