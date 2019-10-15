<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_mail extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>"",
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"lvl"=>$this->session->userdata('itd_lvl'),
                "itd_key"=>$this->session->userdata('itd_key'),"itd_user_unit"=>$this->session->userdata('itd_user_unit'),
                "uid"=>$this->session->userdata('itd_uid')); 
    }
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    
    function list_mail()
    {
        $this->load->model("M_notif");
        $data = $this->M_notif->list_mail();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function view_dlg()
    {
        if($this->is_login())
            $this->load->view("mail_dlg");
    }
    function save_mail()
    {
        $param=$this->input->post();
        sql_quot_all($param); 
        $this->load->model("M_notif");  
        $data = $this->M_notif->save_mail($param["mail_no"],$param["mail_host"],$param["mail_port"],$param["mail_user"],$param["mail_password"],$param["mail_from"],$param["mail_fromname"],$param["mail_to"],$param['mail_default']); 
    }
    function delete_mail()
    {
        $param=$this->input->post();
        sql_quot_all($param); 
        $this->load->model("M_notif");  
        $data = $this->M_notif->delete_mail($param["mail_no"]);
    }
}
        
?>
