<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_del extends CI_Controller { 
    var $isLogin;       
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
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
    function d_client()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            if($rdata["lvl"]<=5)
            {
                $param=$this->input->post();
                $this->load->model("M_itd_del");
                $data = $this->M_itd_del->d_client(trim($param["client_id"]));
                $rdata["r_success"]=true;
            } 
            echo json_encode($rdata);
        }
    }
    function d_pic()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            if($rdata["lvl"]<=5)
            {
                $param=$this->input->post();
                $this->load->model("M_itd_del");
                $data = $this->M_itd_del->d_pic(trim($param["pic_id"]));
                $rdata["r_success"]=true;
            } 
            echo json_encode($rdata);
        }
    }
    function d_user()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            if($rdata["lvl"]<=0)
            {
                $param=$this->input->post();
                $this->load->model("M_itd_del");
                $data = $this->M_itd_del->d_user(trim($param["user_id"]));
                $rdata["r_success"]=true;
            } 
            echo json_encode($rdata);
        }
    }
}
        
?>