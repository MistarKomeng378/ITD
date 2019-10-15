<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscript extends CI_Controller { 
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
    function v_subscript()
    {
        if($this->isLogin)
        {                             
            if($this->data["itd_user_unit"] ==3 || $this->data["itd_user_unit"] == 4) 
                $this->load->view("subscript_inquiry",$this->data);
            else
                $this->load->view("subscript",$this->data);
            
        }
    }
    function subs_list_bank_by_code()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param);
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);
        $data = $this->M_subscript->subs_list_bank_by_code($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function add_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["b_dt"]=change_dt_format($param["b_dt"]);             //print_r($param);
        $data = $this->M_subscript->add_subs($param['b_ccode'],$param['b_code'],$param['b_accno'],$param['b_desc'],
                    $param['b_dt'],$param['b_nominal'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["b_dt"]=change_dt_format($param["b_dt"]);
        $data = $this->M_subscript->edit_subs($param['b_id'],$param['b_ccode'],$param['b_code'],$param['b_accno'],$param['b_desc'],$param['b_dt'],$param['b_nominal'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function del_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $data = $this->M_subscript->del_subs($param['b_id'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function buku_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["b_dt"]=change_dt_format($param["b_dt"]);
        $data = $this->M_subscript->buku_subs($param['b_id'],$param['b_dt'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function cancel_buku_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $data = $this->M_subscript->cancel_buku_subs($param['b_id'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["b_dt"]=change_dt_format($param["b_dt"]);
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $data = $this->M_subscript->list_subs($bccode,$bcode,$baccno,$param["b_dt"]); 
        $fields = array("pending_dt","buku_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_client()
    {
        $this->load->model("M_subscript");
        $data = $this->M_subscript->list_client();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_last_balance_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $data = $this->M_subscript->get_last_balance_subs($bccode,$bcode,$baccno); 
        $fields = array("update_time");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_balance_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $b_dt=change_dt_format($param["b_dt"]);
        $data = $this->M_subscript->get_balance_subs_dt($bccode,$bcode,$baccno,$b_dt); 
        $fields = array("update_time");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_prev_balance_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $b_dt=change_dt_format($param["b_dt"]);
        $data = $this->M_subscript->get_prev_balance_subs_dt($bccode,$bcode,$baccno,$b_dt); 
        $fields = array("update_time");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_total_pending_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $b_dt=change_dt_format($param["b_dt"]);      
        $data = $this->M_subscript->get_total_pending_subs($bccode,$bcode,$baccno,$b_dt); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function update_balance_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $bpending = isset($param["b_pending"])?$param["b_pending"]:0;
        $bhiport = isset($param["b_hiport"])?$param["b_hiport"]:0;
        $bsaldo = isset($param["b_saldo"])?$param["b_saldo"]:"";
        $b_dt=change_dt_format($param["b_dt"]);      
        
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = 0;
        //if($this->data["lvl"]<=5)
        //{
            $data = $this->M_subscript->update_balance_subs($bccode,$bcode,$baccno,$bpending,$bhiport,$bsaldo,$b_dt,$this->data['uid']); 
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
        //}
        echo json_encode($this->data);
    }
    function save_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $param["b_dt"]=change_dt_format($param["b_dt"]);
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $data = $this->M_subscript->list_subs_dt($bccode,$bcode,$baccno,$param["b_dt"]); 
        $fields = array("pending_dt","buku_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $this->data["r_b_code"]= $bcode;
        $this->data["r_b_accno"]= $baccno;
        $this->data["r_b_dt"]= $param["b_dt"];
        $data1 = $this->M_subscript->get_balance_subs_dt($bccode,$bcode,$baccno,$param["b_dt"]); 
        $fields = array("update_time");
        add_data_dt_str($data1,$fields);
        $this->data["r_num_rows1"] = count($data1);
        $this->data["r_sdata1"]= $data1;
        
        $filename="subs.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $this->load->view('subscript_save',$this->data);
        //echo json_encode($this->data);
    }
    function print_subs()
    {
        $this->load->model("M_subscript");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $param["b_dt"]=change_dt_format($param["b_dt"]);
        $bccode = isset($param["b_ccode"])?$param["b_ccode"]:"";
        $bcode = isset($param["b_code"])?$param["b_code"]:"";
        $baccno = isset($param["b_accno"])?$param["b_accno"]:"";
        $data = $this->M_subscript->list_subs($bccode,$bcode,$baccno,$param["b_dt"]); 
        $fields = array("pending_dt","buku_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function v_save_dlg()
    {
        if($this->isLogin)
        {
            $this->load->view("subscript_save_dlg",$this->data);
            
        }
    }
}
        
?>