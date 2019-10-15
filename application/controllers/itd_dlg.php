<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_dlg extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>"",
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"lvl"=>$this->session->userdata('itd_lvl')); 
    }
    /*nction index()
    {
        if($this->isLogin)
            $this->load->view('itd_main',$this->data);    
        else
            $this->load->view('itd_login',$this->data);    
    } */
    function is_login()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function get_login_lvl()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return $this->session->userdata('itd_lvl');
        return 1000000;
    }
    function v_client()
    {
        if($this->isLogin)
            $this->load->view('itd_dlg_client',$this->data);
    }
    function v_client_group()
    {
        if($this->isLogin)
            $this->load->view('itd_dlg_client_group',$this->data);
    }
    function v_client_search()
    {
        if($this->isLogin)
            $this->load->view('itd_dlg_client_search',$this->data);
    }
    function v_pic()
    {
        if($this->isLogin)
            $this->load->view('itd_dlg_pic',$this->data);
    }
    function v_pic_search()
    {
        if($this->isLogin)
            $this->load->view('itd_dlg_pic_search',$this->data);
    }
    function v_user($dlg_no=0)
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->data["no"] = $dlg_no;
            $this->load->view('itd_dlg_user',$this->data);
        }
    }
    function v_trx()
    {
        if($this->isLogin)
        {
            $this->load->model("M_itd_dlg");
            $this->data["deposit_type"]= $this->M_itd_dlg->get_trx_deposit_type();
            $this->data["trx_type"]= $this->M_itd_dlg->get_trx_type();
            $this->data["tax_status"]= $this->M_itd_dlg->get_trx_tax_status();
            $this->data["rate_payment"]= $this->M_itd_dlg->get_trx_rate_payment();
            $this->data["curr"]= $this->M_itd_dlg->get_trx_curr();
            $this->data["due_date_status"]= $this->M_itd_dlg->get_trx_due_dt_status();
            $this->load->view('itd_dlg_trx',$this->data);
        }
    }
    function v_trx_approve()
    {
        if($this->isLogin)
        {
            $this->load->view('itd_dlg_trx_approve',$this->data);  
        }
    }
    function get_trx_type()
    {
        $this->load->model("M_itd_dlg");  
        $data = $this->M_itd_dlg->get_trx_type();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_trx_deposit_type()
    {
        $this->load->model("M_itd_dlg");  
        $data = $this->M_itd_dlg->get_trx_deposit_type();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function v_bilyet_inst_search()
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->load->view('itd_dlg_bilyet_inst_search',$this->data);
        }
    }
    function v_bilyet_inst_in()
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->load->view('itd_dlg_bilyet_inst_in',$this->data);
        }
    }
    function v_bilyet_inst_out()
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->load->view('itd_dlg_bilyet_inst_out',$this->data);
        }
    }
    function v_trx_search()
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->load->view('itd_dlg_trx_search',$this->data);
        }
    }
    function v_trx_history()
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->load->view('itd_dlg_trx_history',$this->data);
        }
    }
    function v_trx_ticket()
    {
        if($this->isLogin)
        {
            //$this->data["lvl"]=$this->get_login_lvl();
            $this->load->view('itd_dlg_trx_ticket',$this->data);
        }
    }
}
        
?>