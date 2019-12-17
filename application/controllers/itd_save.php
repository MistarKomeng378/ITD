<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_save extends CI_Controller { 
    var $isLogin;       
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
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
        //echo $this->session->userdata('itd_lvl');
        //if($this->session->userdata('itd_lvl'))
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return $this->session->userdata('itd_lvl');
        //else
        return 1000000;
    }
    function save_client()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            //if($rdata["lvl"]<=5)
            //{
                $param=$this->input->post();
                sql_quot_all($param);
                $this->load->model("M_itd_save");
                /*$data = $this->M_itd_save->save_client($this->session->userdata('itd_uid'),$param["client_id"],$param["client_code"],$param["client_name"],
                            $param["acc_no"],$param["acc_name"],$param["bank_name"],$param["acc_cif"]);*/
                //update client has tax on 07/05/2013 by gw
                $data = $this->M_itd_save->save_client($this->session->userdata('itd_uid'),$param["client_id"],$param["client_code"],$param["client_name"],
                            $param["acc_no"],$param["acc_name"],$param["bank_name"],$param["acc_cif"],$param["h_tax"],$param["g_code"]);
            //}
            echo json_encode($rdata);
            /*$this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            echo json_encode($this->data);*/
        }
    }
    function submit_approve_client()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {                                                          
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());  
            if($rdata["lvl"]<=5)
            {
                $param=$this->input->post();
                sql_quot_all($param);                                  
                $this->load->model("M_itd_save");      
                $data=$this->M_itd_save->submit_approve_client($this->session->userdata('itd_uid'),$param["client_id"]);
                $rdata["r_num_rows"] = count($data);
                $rdata["r_data"] = $data;
                $rdata["r_success"] = true;
            }
            echo json_encode($rdata);
        }
    }
    function save_pic()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            $param=$this->input->post();
            sql_quot_all($param);
            $this->load->model("M_itd_save");
            $data = $this->M_itd_save->save_pic($this->session->userdata('itd_uid'),$param["pic_id"],$param["bank_name"],$param["bank_rek"],$param["bank_acc_name"],$param["pic_name"],
                            $param["pic_telp"],$param["pic_fax"],$param["pic_remark1"],$param["pic_remark2"]);
            echo json_encode($rdata);
            /*$this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            echo json_encode($this->data);*/
        }
    }
    function save_user()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            if($rdata["lvl"]<=0)
            {
                $param=$this->input->post();
                $pass= md5($param["user_pass"]);
                sql_quot_all($param);
                $this->load->model("M_itd_save");             
                if($param['uid']=='' || '' . $param['uid']=='0')
                    $data = $this->M_itd_save->insert_user($param["user_id"],$param["user_name"],$pass,
                            $param["user_lvl"],$param["user_active"],$param["user_group"]);
                else
                    $data = $this->M_itd_save->update_user($param["uid"],$param["user_name"],$param["user_lvl"], 
                            $param["user_active"],$param["user_group"],$param["user_lock"]);
                echo json_encode($rdata);
            }
        }
    }
    function reset_user_pass()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            if($rdata["lvl"]<=0)
            {
                $param=$this->input->post();
                $pass= md5($param["user_pass"]);
                sql_quot_all($param);
                $this->load->model("M_itd_save");             
                if($param['uid']!='' && '' . $param['uid']!='0')
                    $this->M_itd_save->update_pass($param["uid"],$pass);
                echo json_encode($rdata);
            }
        }
    }
    function change_user_pass()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $uinfo = $this->session->userdata('itd_uid');
            $this->load->model("M_itd");
            $param=$this->input->post();
            $arr_data=$this->M_itd->get_login_info($this->session->userdata('itd_uid'),$param["user_pass_old"]); 
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl(),"e"=>10);
            if(is_array($arr_data))
            {
                if(count($arr_data)>=1)
                {
                    $rdata["r_success"] = true;
                    $rdata["e"] = 0;
                    $this->load->model("M_itd_save");
                    $this->M_itd_save->update_pass($uinfo,md5($param["user_pass"]));
                }
            }
            echo json_encode($rdata);
        }
    }
    function submit_new_trx()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            $param=$this->input->post();
            sql_quot_all($param);            
            $this->load->model("M_itd_save");
            if($param["trx_break_dt"]=="")
                $param["trx_break_dt"]='01/01/2011';
            if(!isset($param['trx_rbreak']))
                $param['trx_rbreak']=0;
            elseif(trim($param['trx_rbreak'])=="")
                $param['trx_rbreak']=0;
            $param["trx_dt"] = change_dt_format($param["trx_dt"]);
            $param["trx_val_dt"] = change_dt_format($param["trx_val_dt"]);
            $param["trx_due_dt"] = change_dt_format($param["trx_due_dt"]);
            $param["trx_break_dt"] = change_dt_format($param["trx_break_dt"]);
            //print_r($param);
            $this->load->model("M_itd_save");
            //echo "{$param["trx_id_master"]},{$param["trx_id"]}";
            if($param["trx_id_master"]==0)
                $param["trx_id_master"]=$param["trx_id"];
            $data = $this->M_itd_save->submit_new_trx($this->session->userdata('itd_uid'),$param);
            $rdata["r_success"] = true;
            $rdata["r_numrows"] = count($data);
            $rdata["r_sdata"] = $data;
            echo json_encode($rdata);
            /*if($rdata["lvl"]<=0)
            {
                $param=$this->input->post();
                $pass= md5($param["user_pass"]);
                sql_quot_all($param);
                $this->load->model("M_itd_save");             
                if($param['uid']=='' || '' . $param['uid']=='0')
                    $data = $this->M_itd_save->insert_user($param["user_id"],$param["user_name"],$pass,
                            $param["user_lvl"],$param["user_active"]);
                else
                    $data = $this->M_itd_save->update_user($param["uid"],$param["user_name"],$param["user_lvl"], 
                            $param["user_active"]);
                echo json_encode($rdata);
            } */
        }
    }
    function submit_edit_trx()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            $param=$this->input->post();
            sql_quot_all($param);           //print_r($param);    
            
            // $this->load->database('default');
            // $query=$this->db->query("
            //     select nfs_td from itd_trx_approved where trx_id='".$param["trx_id"]."'
            // ");
            // $nfd_td = $query->result_array();
            // echo json_encode( count( $nfd_td[0]['nfs_td'])  );
            // die();

            $this->load->model("M_itd_save");
            if($param["trx_break_dt"]=="")
                $param["trx_break_dt"]='01/01/2011';
            if(!isset($param['trx_rbreak']))
                $param['trx_rbreak']=0;
            elseif(trim($param['trx_rbreak'])=="")
                $param['trx_rbreak']=0;
            $param["trx_dt"] = change_dt_format($param["trx_dt"]);
            $param["trx_val_dt"] = change_dt_format($param["trx_val_dt"]);
            $param["trx_due_dt"] = change_dt_format($param["trx_due_dt"]);
            $param["trx_break_dt"] = change_dt_format($param["trx_break_dt"]);
           // $param["PTP"]==
            //print_r($param);
            $this->load->model("M_itd_save");
            $data=$this->M_itd_save->submit_edit_trx($this->session->userdata('itd_uid'),$param);
            $rdata["r_success"] = true;
            $rdata["r_numrows"] = count($data);
            $rdata["r_sdata"] = $data;
            echo json_encode($rdata);
        }
    }
    function submit_revise_trx()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            if($rdata["lvl"]<=5)
            {
                $param=$this->input->post();
                sql_quot_all($param);                                  
                $this->load->model("M_itd_save");
                $this->M_itd_save->submit_revise_trx($this->session->userdata('itd_uid'),$param);
                $rdata["r_success"] = true;
            }
            echo json_encode($rdata);
        }
    }
    function submit_approve_trx()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {                   
            //$rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            //print_r($rdata);
            //if($rdata["lvl"]<=5)
            //{
                //echo $this->session->userdata('itd_uid');
                $param=$this->input->post();
                sql_quot_all($param);                                  
                $this->load->model("M_itd_save");
                $data=$this->M_itd_save->submit_approve_trx($this->session->userdata('itd_uid'),$param["trx_id"]);
                $rdata["r_success"] = true;
                $rdata["r_numrows"] = count($data);
                $rdata["r_sdata"] = $data;
                $rdata["penempatan_to_mutasi"] = $this->PenempatanToMutasi($param["trx_id"]);
                $rdata["pencairan_to_mutasi"] = $this->PencairanToMutasi($param["trx_id"]);
            //}
            echo json_encode($rdata);
        }
    }
    function submit_approve_trx1()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {                   
            //$rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            //print_r($rdata);
            //if($rdata["lvl"]<=5)
            //{
                //echo $this->session->userdata('itd_uid');
                $param=$this->input->post();
                sql_quot_all($param);                                  
                $this->load->model("M_itd_save");
                $data=$this->M_itd_save->submit_approve_trx1($param["ud1"],$param["up1"],$param["trx_id"]);
                $rdata["r_success"] = true;
                $rdata["r_numrows"] = count($data);
                $rdata["r_sdata"] = $data;
                $rdata["penempatan_to_mutasi"] = $this->PenempatanToMutasi($param["trx_id"]);
            //}
            echo json_encode($rdata);
        }
    }
    function submit_cancel_trx()
    {
        if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {                   
            //$rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            //print_r($rdata);
            //if($rdata["lvl"]<=5)
            //{
                //echo $this->session->userdata('itd_uid');
                $param=$this->input->post();
                sql_quot_all($param);                                  
                $this->load->model("M_itd_save");
                $data=$this->M_itd_save->submit_cancel_trx($this->session->userdata('itd_uid'),$param["trx_id"],$param["trx_note"]);
                $rdata["r_success"] = true;
                $rdata["r_numrows"] = count($data);
                $rdata["r_sdata"] = $data;
            //}
            echo json_encode($rdata);
        }
    }
    function submit_trx_ticket_print()
    {
         if(!$this->is_login())
            header('Location: ' . base_url());
        else
        {
            $param=$this->input->post();
            sql_quot_all($param);                                                
            $this->load->model("M_itd_save");
            $data=$this->M_itd_save->submit_trx_ticket_print($this->session->userdata('itd_uid'),$param);
        }
    }
    
    function save_client_group()
    {
        if(!$this->is_login())
            echo '';
        else
        {
            $rdata = array("r_success"=>false,"lvl"=>$this->get_login_lvl());
            //if($rdata["lvl"]<=5)
            //{
                $param=$this->input->post();
                sql_quot_all($param);
                $this->load->model("M_itd_save");  
                $data = $this->M_itd_save->save_client_group($this->session->userdata('itd_uid'),$param["g_id"],$param["c_code"],$param["c_name"],
                           $param["c_ena"],$param["c_mail"],$param["c_mailcc"]);
            //}
            echo json_encode($rdata);
            /*$this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            echo json_encode($this->data);*/
        }
    }

    public function PenempatanToMutasi($unapprove_id)
    {
        $this->load->model("M_itd_save");
        $data = $this->M_itd_save->PenempatanToMutasi($unapprove_id);
        return $data;
    }

    public function PencairanToMutasi($unapprove_id)
    {
        $this->load->model("M_itd_save");
        $data = $this->M_itd_save->PencairanToMutasi($unapprove_id);
        return $data;
    }
    
}
        
?>
