<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd_nfs extends CI_Controller { 
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
                "uid"=>$this->session->userdata('itd_uid'),
                "err_login"=>$this->session->userdata('err_login'),
                "err_pass_count"=>$this->session->userdata('err_pass_count'),
                "err_period"=>$this->session->userdata('err_period'),
                "nm1"=>$this->session->userdata('nm1')
                ); 
    }
    function index()
    {
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
    function list_trx()
    {
        $param=$this->input->post();
        $this->load->model("M_itd_nfs");
        $tday= getdate();
        $cdt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        if(cek_date($param["trx_dt"]))
            $cdt = change_dt_format($param["trx_dt"]);
        $data = $this->M_itd_nfs->list_trx($cdt,$this->session->userdata('itd_uid'));
        $fields = array("trx_create_dt","trx_valuta_date","trx_due_date","trx_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function down_trx()
    {
        if(!$this->is_login())
            return 0;
        else
        {
            $param=$this->input->post();
            sql_quot_all($param);
            
            if($param["trx_dt"]=="")
                $param["trx_dt"]='01-01-1900';
            $dt= change_dt_format($param["trx_dt"]); 
            list($bl,$tg,$th)=explode("/",$dt);
            $sdt=substr('000'.$th,-4) . substr('00'.$bl,-2) . substr('00'.$tg,-2); 
            $this->load->model("M_itd_nfs");
            $datanfs = $this->M_itd_nfs->down_trx($sdt);
            $this->M_itd_nfs->clear_tmp();
            foreach($datanfs as $xitem1)
            {
                $pdate = substr($xitem1['PLACEMENT_DATE'],4,2) . '/' . substr($xitem1['PLACEMENT_DATE'],-2) . '/' . substr($xitem1['PLACEMENT_DATE'],0,4);
                $mdate = substr($xitem1['MATURITY_DATE'],4,2) . '/' . substr($xitem1['MATURITY_DATE'],-2) . '/' . substr($xitem1['MATURITY_DATE'],0,4);
                $this->M_itd_nfs->insert_tmp(sql_quot($xitem1['HIPORT_CODE']),sql_quot($xitem1['TRANSACTION_STATUS']),sql_quot($xitem1['ACTION_TYPE']),sql_quot($xitem1['INPUT_TYPE']),trim($xitem1['IM_NAME']),
                    sql_quot($xitem1['FUND_CODE']),sql_quot($xitem1['FUND_NAME']),sql_quot($xitem1['PLACEMENT_BANK_CODE']),sql_quot($xitem1['PLACEMENT_BANK_NAME']),trim($xitem1['BRANCH_CODE']),sql_quot($xitem1['BRANCH_NAME']),
                    sql_quot($xitem1['PLACEMENT_BANK_SECURITY']),sql_quot($xitem1['PLACEMENT_BANK_CASH']),sql_quot($xitem1['CCY']),sql_quot($xitem1['PRINCIPLE']),sql_quot($xitem1['INTEREST_RATE']),sql_quot($pdate),sql_quot($mdate),sql_quot(
                    $xitem1['SHARIA_DEPOSIT']),sql_quot($xitem1['CONTACT_PERSON']),sql_quot($xitem1['TELEPHONE_NO']),sql_quot($xitem1['FAX_NO']),sql_quot($xitem1['REFERENCE_NO']),sql_quot($xitem1['PARENT_REFERENCE_NO']),sql_quot(
                    $xitem1['DESCRIPTION']),sql_quot($xitem1['SI_REFERENCE']),sql_quot($xitem1['STATUS']),sql_quot($xitem1['APPROVE']),sql_quot($xitem1['CHECKED']),sql_quot($xitem1['PENDING']),sql_quot($xitem1['REJECT_REASON']
                    ),sql_quot($xitem1['ACCT_NO']),sql_quot($xitem1['ACCT_NAME']));
                
            }
            
            $data = $this->M_itd_nfs->move_tmp($this->session->userdata('itd_uid'));

            $datanfs = $this->M_itd_nfs->down_trx_rev($sdt);
            foreach($datanfs as $xitem1)
            {
                $pdate = substr($xitem1['PLACEMENT_DATE'],4,2) . '/' . substr($xitem1['PLACEMENT_DATE'],-2) . '/' . substr($xitem1['PLACEMENT_DATE'],0,4);
                $mdate = substr($xitem1['MATURITY_DATE'],4,2) . '/' . substr($xitem1['MATURITY_DATE'],-2) . '/' . substr($xitem1['MATURITY_DATE'],0,4);
                $this->M_itd_nfs->insert_rev_tmp(sql_quot($xitem1['HIPORT_CODE']),sql_quot($xitem1['TRANSACTION_STATUS']),sql_quot($xitem1['ACTION_TYPE']),sql_quot($xitem1['INPUT_TYPE']),sql_quot($xitem1['IM_NAME']),sql_quot(
                    $xitem1['FUND_CODE']),sql_quot(substr(trim($xitem1['FUND_NAME'])),sql_quot(0),sql_quot(150)),sql_quot($xitem1['PLACEMENT_BANK_CODE']),sql_quot($xitem1['PLACEMENT_BANK_NAME']),sql_quot($xitem1['BRANCH_CODE']),sql_quot($xitem1['BRANCH_NAME']),sql_quot(
                    $xitem1['PLACEMENT_BANK_SECURITY']),sql_quot($xitem1['PLACEMENT_BANK_CASH']),sql_quot($xitem1['CCY']),sql_quot($xitem1['PRINCIPLE']),sql_quot($xitem1['INTEREST_RATE']),sql_quot($pdate),sql_quot($mdate),sql_quot(
                    $xitem1['SHARIA_DEPOSIT']),sql_quot($xitem1['CONTACT_PERSON']),sql_quot($xitem1['TELEPHONE_NO']),sql_quot($xitem1['FAX_NO']),sql_quot($xitem1['REFERENCE_NO']),sql_quot($xitem1['PARENT_REFERENCE_NO']),sql_quot(
                    $xitem1['DESCRIPTION']),sql_quot($xitem1['SI_REFERENCE']),sql_quot($xitem1['STATUS']),sql_quot($xitem1['APPROVE']),sql_quot($xitem1['CHECKED']),sql_quot($xitem1['PENDING']),sql_quot($xitem1['REJECT_REASON']
                    ),sql_quot($xitem1['ACCT_NO']),sql_quot($xitem1['ACCT_NAME']));
            }
            
            $this->M_itd_nfs->move_rev_tmp($this->session->userdata('itd_uid'));    
            
        }
    }
    
    function get_trx()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx($this->session->userdata('itd_uid'),$param["trx_id"],$param["trx_unix"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        //print_r($data);
        $fields = array("trx_valuta_date","trx_due_date","trx_date","trx_create_dt","trx_modified_dt","trx_break_dt");
        add_data_dt_str($data,$fields);
        //print_r($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_trx_for_print($trx_id=0)
    {
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx_print($this->session->userdata('itd_uid'),$trx_id); 
        if(count($data)>0)
        {
            //if($data[0]["trx_create_by"]==$this->session->userdata('itd_uid'))
            //{
                $this->data["r_sdata"] = $data[0];
                $this->load->view('itd_trx_print',$this->data);
            //}
            //else
            //    echo "false";
        }
        else
            echo "false";
    }
    function get_trx_info()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx_info($this->session->userdata('itd_uid'),$param["trx_id"],$param["trx_unix"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);                                                                     
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_trx_unapproved()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx_unapproved($param["trx_id"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }   
    function get_trx_approved()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx_approved($param["trx_id"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    } 
    function search_trx_approved()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        if($param["trx_sdate"]=="")
            $param["trx_sdate"]='01/01/1900';
        if($param["trx_edate"]=="")
            $param["trx_edate"]='01/01/1900';
        $param["trx_sdate"] = change_dt_format($param["trx_sdate"]);
        $param["trx_edate"] = change_dt_format($param["trx_edate"]);
        $data = $this->M_itd->search_trx_approved($param["trx_to"],$param["trx_ccode"],$param["trx_cname"],$param["trx_stype"],$param["trx_ntype"],0+$param["trx_nominal"],$param["trx_sdate"],$param["trx_edate"],$this->session->userdata('itd_uid'),$param['trx_id']);
        $fields = array("trx_create_dt","trx_valuta_date","trx_due_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    } 
    function search_trx_approved_save()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        if($param["trx_sdate"]=="")
            $param["trx_sdate"]='01/01/1900';
        if($param["trx_edate"]=="")
            $param["trx_edate"]='01/01/1900';
        $param["trx_sdate"] = change_dt_format($param["trx_sdate"]);
        $param["trx_edate"] = change_dt_format($param["trx_edate"]);
        $data = $this->M_itd->search_trx_approved($param["trx_to"],$param["trx_ccode"],$param["trx_cname"],$param["trx_stype"],$param["trx_ntype"],0+$param["trx_nominal"],$param["trx_sdate"],$param["trx_edate"],$this->session->userdata('itd_uid'),$param['trx_id']);
        $fields = array("trx_create_dt","trx_valuta_date","trx_due_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="itd.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_trx_search_save',$this->data);
    }
    function list_user()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $u_unit = isset($param["u_unit"])?$param["u_unit"]:0;
        $this->load->model("M_itd");  
        $data = $this->M_itd->list_user($u_unit);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_unit()
    {
        $this->load->model("M_itd");  
        $data = $this->M_itd->list_unit();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_user()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_user($param["user_id"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_pic()
    {
        $this->load->model("M_itd");  
        $data = $this->M_itd->list_pic(0,0);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }   
    function list_pic_by_bank()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        //$data = $this->M_itd->list_pic_by_bank($param["bank_name"]);
        $data = $this->M_itd->list_pic_by_bank($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }    
    function get_pic()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_pic($param["pic_id"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function search_pic()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->search_pic($param["b_name"],$param["c_name"],$param["c_remark1"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }     
    function list_client()
    {
        $this->load->model("M_itd");  
        $data = $this->M_itd->list_client(0,0);
        $fields = array("client_created_dt","client_modified_dt","client_approved_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_client_by_code()
    {
        $this->load->model("M_itd");  
        $param=$this->input->post();
        sql_quot_all($param);
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);
        $data = $this->M_itd->list_client_by_code($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }      
    
    function list_client_distinct()
    {
        $this->load->model("M_itd");  
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->list_client_distinct($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_client()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_client($param["client_id"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function search_client()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->search_client($param["c_code"],$param["c_name"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_client_by_code()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_client_by_code($param["client_code"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_trx_ticket_print()
    {
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx_ticket_print($this->session->userdata('itd_uid'));
        if(count($data)>0)
        {
            $rdata= array();
            $rdata["url"]=base_url();
            $rdata["c_code"] = trim(strtoupper($data[0]["f1"]));
            $rdata["c_name"] = trim(strtoupper($data[0]["f2"]));
            $rdata["c_type"] = 0+trim($data[0]["f3"]);
            $rdata["c_typename"] = trim(strtoupper($data[0]["f4"]));
            $rdata["c_bank"] = trim(strtoupper($data[0]["f5"]));
            $rdata["c_setdate"] = trim(strtoupper($data[0]["f6"]));
            $rdata["c_term"] = 0+ trim(strtoupper($data[0]["f7"]));
            $rdata["c_rate"] = 0+trim(strtoupper($data[0]["f8"]));
            $rdata["c_year"] = 0+ trim($data[0]["f9"]);
            $rdata["c_amount"] = 0+ str_replace(',','',trim($data[0]["f10"]));
            $rdata["c_ref"] = trim(strtoupper($data[0]["f11"]));            
            $rdata["c_intamount"] = 0+ str_replace(',','',trim($data[0]["f12"]));
            $rdata["c_tax"] = 0+ str_replace(',','',trim($data[0]["f13"]));
            $rdata["c_stamptype"] = 0+ str_replace(',','',trim($data[0]["f14"]));
            $rdata["c_stamp"] = trim(strtoupper($data[0]["f15"]));            
            $rdata["c_stampamount"] = 0+ str_replace(',','',trim($data[0]["f16"]));
            $rdata["c_net"] = 0+ str_replace(',','',trim($data[0]["f17"]));
            $rdata["c_id"] = trim(strtoupper($data[0]["f18"]));
            $rdata["c_note"] = (strtoupper($data[0]["f19"]));
            $rdata["c_taxamount"] = 0+ str_replace(',','',trim($data[0]["f20"]));
            $rdata["c_rate1"] = 0+trim(strtoupper($data[0]["f21"]));
            $this->load->view('itd_dlg_trx_ticket_print',$rdata);
        }
        else
            echo "";
    }
    
    /* get configuration for javscript client side */
    function get_js_config()
    {
         //if($this->isLogin)
            $this->load->view('itd_js_config',$this->data);   
    }
    
    function is_trx_editable()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->is_trx_editable($param["trx_id"],'jaigid');
        if(count($data)>0)
            echo $data[0]["editable"];
        else
            echo 0;
    }
    function create_key()
    {
        $i_len = rand(5,25);
        $key='';
        for($i=0;$i<$i_len;$i++)
        {
            $ichr = rand(33,122);
            if($ichr==39 || $ichr==60 || $ichr==62 || $ichr==92 || $ichr==96)
                $ichr++;
            $key .= chr($ichr);
        }
        return($key);
    }
    function decrypt($pstr)
    {
        $key = $this->session->userdata('itd_key');
        $i_key = strlen($key);
        $pass = '';
        for($i=0;$i<strlen($pstr);$i++)
        {
            $pass .= chr( (ord($pstr[$i]) - ord($key[$i%$i_key])) );
        }           
        return $pass;
    }
    function check_session()
    {
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
        {
            echo '1';
            return 0;
        }
        echo "0";
    }
    function frm_change_pass()
    {
        $this->load->model("M_itd");  
        $arr_par=$this->M_itd->get_user_pass_parameter();
        $this->data["r_pass"]= $arr_par;
        $this->load->view('itd_change_pass',$this->data); 
    }
    function change_pass()
    {
        $param=$this->input->post();
        $this->load->model("M_itd");
        $arr_data=$this->M_itd->get_login_info($this->data['nm1'],$param["upo"]);
        $arr_err_change=array("err_no"=>0,"err_desc"=>"Successful change password.");
        if ($arr_data[0]["user_pass"]!=md5($param["upo"]))
            $arr_err_change=array("err_no"=>1,"err_desc"=>"Old password doesn't match.");
        $arr_par=$this->M_itd->get_user_pass_parameter();
        if (strlen($param["up"])<$arr_par[0]["user_pass_min"])
            $arr_err_change=array("err_no"=>2,"err_desc"=>"Min password: {$arr_par[0]["user_pass_min"]} characters.");
        if (strlen($param["up"])>$arr_par[0]["user_pass_max"])
            $arr_err_change=array("err_no"=>3,"err_desc"=>"Max password: {$arr_par[0]["user_pass_max"]} characters.");
        if ($arr_par[0]["user_pass_alpha_numeric"]==1 && !preg_match('/[A-Z]+[a-z]+[0-9]+/', $param["up"]))
            $arr_err_change=array("err_no"=>4,"err_desc"=>"Password must be alphanumeric.");
        if ($arr_par[0]["user_pass_first_cap"]==1 && !preg_match('/^[A-Z]/', $param["up"]))
            $arr_err_change=array("err_no"=>5,"err_desc"=>"First char of password must be capitalize.");
        
        if($arr_err_change["err_no"]==0)
        {
            $arr_data=$this->M_itd->change_pass($this->data['nm1'],$param["up"]);
            if ($arr_data[0]["no_err"]==1)
                $arr_err_change=array("err_no"=>6,"err_desc"=>"Password cycle in use : {$arr_par[0]["user_pass_recycle"]}");
        }
        $this->data["r_change"]=$arr_err_change;
        $this->data["r_pass"]= $arr_par;
        $this->load->view('itd_change_pass',$this->data); 
    }
    function list_client_group()
    {
        $param=$this->input->post();
        $this->load->model("M_itd");
        $data = $this->M_itd->list_client_group();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_client_group()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");
        $data = $this->M_itd->get_client_group($param['g_code']);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_client_group_select()
    {
        $param=$this->input->post();
        $this->load->model("M_itd");
        $data = $this->M_itd->list_client_group();
        echo "<option value=\"\">-None-</option>\n";
        foreach($data as $xitem1)
            echo "<option value=\"{$xitem1['group_code']}\">{$xitem1['group_name']}</option>\n";
    }

    public function list_pending()
    {
        return $this->load->view('list_pending');
    }

    public function show_list_pending()
    {
        $this->load->model("M_itd_nfs");
        $data = $this->M_itd_nfs->list_pending();
        echo json_encode($data);
    }

    public function show_list_pending_parent()
    {
        $param = $this->input->post();
        $this->load->model("M_itd_nfs");
        $data = $this->M_itd_nfs->list_pending_parent($param);

        $parent = array();
        $child = array();
        $list = array();

        foreach ($data as $key => $value) {
            if ($value['trx_id_upper'] == 0) {
                array_push($parent, $value);
            }

            if ($value['trx_id_upper'] !== 0) {
                array_push($child, $value);
            }
        }

        $id = 0;
        foreach ($parent as $key => $value) {
            $value['id']     = $id;
            $value['parent'] = null;
            array_push($list,$value);
            
            foreach ($child as $keyb => $valueb) {
                if ($value['trx_id'] == $valueb['trx_id_upper']) {
                    $valueb['id'] = ++$id;
                    $valueb['parent'] = $value['id'];
                    array_push($list,$valueb);
                }
            }

            ++$id;
        }

        echo json_encode($list);
    }

}
        
?>
