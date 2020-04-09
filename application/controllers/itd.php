<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itd extends CI_Controller { 
    var $isLogin;
    var $data;          
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
         $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, 
                "r_err_desc"=>"", 
                "r_num_rows"=>0, 
                "r_sdata"=>"",
                "url"=>base_url(),
                "nm"=>$this->session->userdata('itd_nm'),
                "lvl"=>$this->session->userdata('itd_lvl'),
                "itd_key"=>$this->session->userdata('itd_key'),
                "itd_user_unit"=>$this->session->userdata('itd_user_unit'),
                "uid"=>$this->session->userdata('itd_uid'),
                "err_login"=>$this->session->userdata('err_login'),
                "err_pass_count"=>$this->session->userdata('err_pass_count'),
                "err_period"=>$this->session->userdata('err_period'),
                "nm1"=>$this->session->userdata('nm1')
                ); 
    }
    function index()
    {
        if($this->isLogin)
        {
            if($this->data["itd_user_unit"] ==2 )
                $this->load->view('itd_main_safe',$this->data);
            else if($this->data["itd_user_unit"] ==3 )
                $this->load->view('itd_main_inquiry',$this->data);
            else if($this->data["itd_user_unit"] == 4)
                $this->load->view('itd_main_payment',$this->data);
            else if($this->data["itd_user_unit"] == 5)
                $this->load->view('itd_main_query',$this->data);
            else
                $this->load->view('itd_main',$this->data);    
        }
        else 
            $this->load->view('itd_login',$this->data); 
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
    function do_login()
    {
        $param=$this->input->post();           
        $this->load->model("M_itd");      
        $this->data["r_login"] = false;
        $arr_par=$this->M_itd->get_user_pass_parameter();
        $arr_data=$this->M_itd->get_login_info($param["ud"],$param["up"]);
        //$arr_sesion= array("itd_nm"=>'',"itd_lvl"=>'',"itd_key"=>'');
        //$this->session->unset_userdata($arr_sesion);
        $arr_sesion= array("itd_nm"=>'',"itd_lvl"=>'',"itd_key"=>$this->create_key(),"itd_user_unit"=>'',
        "err_login"=>"","err_pass_count"=>"","err_period"=>"","nm1"=>"");
        $err_login=1;
        $err_pass=0;
        $err_period=0;
        /*
        Error Login
            0 or "" : No error Login
            1       : User Doesn't exists 
            2       : Password missmatch'
            3       : User disabled
            4       : User Locked
            5       : User locked due to no login for certain period
            6       : User Locket due to wrong password for certain times
        */
        if(is_array($arr_data))
        {
            if(count($arr_data)>=1)
            {
                if($arr_data[0]["user_active"]==1)
                {
                    if($arr_data[0]["user_locked"]!=1)
                    {
                        if($arr_data[0]["days_last_login"]>=$arr_par[0]["user_expired_days"] && $arr_data[0]["user_lvl"]>0)
                        {
                            $err_login=5;
                            $err_period=$arr_par[0]["user_expired_days"];
                        }
                        else    
                        {
                            if($arr_data[0]["user_pass"]==md5($param["up"]))
                            {
                                if($arr_data[0]["days_last_change_pass"]>=$arr_par[0]["user_pass_expired_days"] && $arr_data[0]["user_lvl"]>0)
                                { //echo base_url()."index.php/itd/frm_change_pass";
                                    $arr_sesion["nm1"] = $arr_data[0]["user_id"];
                                    $this->M_itd->set_user_info($param["ud"],'wrong_pass_count',0);
                                    $this->M_itd->set_user_info($param["ud"],'res_last_log');
                                    $this->session->set_userdata($arr_sesion);
                                    header("location: " . base_url()."index.php/itd/frm_change_pass");
                                    return 0;
                                }
                                else
                                {
                                    $this->M_itd->set_user_info($param["ud"],'res_last_log');
                                    $this->M_itd->set_user_info($param["ud"],'wrong_pass_count',0);
                                    
                                    $arr_sesion["itd_uid"] = $arr_data[0]["user_id"];
                                    $arr_sesion["itd_nm"] = $arr_data[0]["user_name"];
                                    $arr_sesion["nm1"] = $arr_data[0]["user_id"];
                                    $arr_sesion["itd_lvl"] = $arr_data[0]["user_lvl"];
                                    $arr_sesion["itd_user_unit"] = $arr_data[0]["user_unit"];
                                    $this->isLogin=true;                               
                                }
                            }
                            else
                            {
                                if($arr_data[0]["user_wrong_pass"]+1>=$arr_par[0]["user_pass_wrong_count"] && $arr_data[0]["user_lvl"]>0)
                                {
                                    $err_login=6;
                                    $err_period=$arr_par[0]["user_pass_wrong_count"];
                                    $err_pass=$arr_data[0]["user_wrong_pass"]+1;
                                    $this->M_itd->set_user_info($param["ud"],'wrong_pass_count',$err_pass);
                                    $this->M_itd->set_user_info($param["ud"],'lock',1);
                                }
                                else
                                {
                                     $err_login=2;
                                     $err_pass=$arr_data[0]["user_wrong_pass"]+1;
                                     $err_period=$arr_par[0]["user_pass_wrong_count"];
                                     $this->M_itd->set_user_info($param["ud"],'wrong_pass_count',$err_pass);
                                }
                            }
                        }
                    }
                    else
                        $err_login=4;
                }
                else 
                    $err_login=3;
            }
        }
        $arr_sesion["err_login"] = $err_login;
        $arr_sesion["err_pass_count"] = $err_pass;
        $arr_sesion["err_period"] = $err_period;
        $this->session->set_userdata($arr_sesion);
        header("location: " . base_url());
    }
    function do_logout()
    {
        $arr_sesion= array("itd_uid"=>'',"itd_nm"=>'',"itd_lvl"=>'');
        $this->session->unset_userdata($arr_sesion);
        $this->isLogin=false;
        header("location: " . base_url());
    }
    function list_trx()
    {
        $param=$this->input->post();
        $this->load->model("M_itd");
        $tday= getdate();
        $cdt =$tday["mon"]."/".$tday["mday"]."/".$tday["year"];
        if(cek_date($param["trx_dt"]))
            $cdt = change_dt_format($param["trx_dt"]);
        $data = $this->M_itd->list_trx($cdt,$this->session->userdata('itd_uid'));
        $fields = array("trx_create_dt","trx_valuta_date","trx_due_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }

    public function do_map($v)
    {
        foreach($v as $key => $value){
            if(is_object($value)){
                $this->do_map( (array)$value );
            }else{
                $v[$key] = utf8_encode($value);
            }
        }
        return $v;
    }

    function get_trx()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx($this->session->userdata('itd_uid'),$param["trx_id"],$param["trx_unix"]);
        
		$data = array_map(array($this,'do_map'),$data);
        
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        //print_r($data);
        $fields = array("trx_valuta_date","trx_due_date","trx_date","trx_create_dt","trx_modified_dt","trx_break_dt");
        add_data_dt_str($data,$fields);
        //print_r($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }

    function get_itd_print()
    {
        $param=$this->input->post();
        sql_quot_all($param);
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_itd_print($this->session->userdata('itd_uid'),$param["trx_id"],$param["trx_unix"]);
        
		$data = array_map(array($this,'do_map'),$data);
        
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);

        $fields = array("trx_due_date");
        add_data_dt_str($data,$fields);

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
    function save_to_excel_approved(
        $trx_to, 
        $trx_ccode, 
        $trx_cname, 
        $trx_stype, 
        $trx_ntype, 
        $trx_nominal, 
        $trx_sdate, 
        $trx_edate, 
        $trx_id,
        $trx_status
    ){
        $this->load->model("M_itd");  
        if($trx_sdate=="")
            $trx_sdate='01/01/1900';
        if($trx_edate=="")
            $trx_edate='01/01/1900';
        $trx_sdate = change_dt_format($trx_sdate);
        $trx_edate = change_dt_format($trx_edate);

        $data = $this->M_itd->search_trx_approved(
            $trx_to !== '0' ? $trx_to : '' , 
            $trx_ccode !== '0' ? $trx_ccode : '', 
            $trx_cname !== '0' ? str_replace('%20',' ',$trx_cname) : '', 
            $trx_stype !== '0' ? $trx_stype : 0, 
            $trx_nominal !== '0' ? $trx_nominal : 0+$trx_nominal,
            $trx_ntype !== '0' ? $trx_ntype : 0,
            $trx_sdate !== '0' ? $trx_sdate : '',
            $trx_edate !== '0' ? $trx_edate : '',
            $this->session->userdata('itd_uid'),
            $trx_id !== '0' ? $trx_id : '',
            $trx_status !== '0' ? $trx_status : 0
        );

        $filename="instruksi_deposito_ ".$trx_sdate." s.d ".$trx_edate.".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $this->load->view('intruksi_deposito_excel',array('data' => $data) );
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
        $data = $this->M_itd->search_trx_approved($param["trx_to"],$param["trx_ccode"],$param["trx_cname"],$param["trx_stype"],$param["trx_ntype"],0+$param["trx_nominal"],$param["trx_sdate"],$param["trx_edate"],$this->session->userdata('itd_uid'),$param['trx_id'], $param['status']);
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
        $data = $this->M_itd->search_trx_approved($param["trx_to"],$param["trx_ccode"],$param["trx_cname"],$param["trx_stype"],$param["trx_ntype"],0+$param["trx_nominal"],$param["trx_sdate"],$param["trx_edate"],$this->session->userdata('itd_uid'),$param['trx_id'], $param['status']);
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
        $data = $this->M_itd->list_pic(100,0);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= utf8_convert($data);  
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
        $this->data["r_sdata"]= utf8_convert($data);
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
        $this->data["r_sdata"]= utf8_convert($data);
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
        $this->data["r_sdata"]= utf8_convert($data);
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
        $data = array_map(array($this,'do_map'),$data);

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
    function get_trx_ticket_print($id = 1)
    {
        $this->load->model("M_itd");  
        $data = $this->M_itd->get_trx_ticket_print($id);
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
}
        
?>
