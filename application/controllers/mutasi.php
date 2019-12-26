<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasi extends CI_Controller { 
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
        //echo $this->session->userdata('nama');
        if(trim($this->session->userdata('itd_nm'))!='' && $this->session->userdata('itd_nm'))
            return true;
        return false;
    }
    function v_mutasi($m1=1,$m2=1)
    {
        if($this->isLogin)
        {
            if (0+$m1!=0 && 0+$m2!=0)
            {
                if($this->data["itd_user_unit"] ==3 || $this->data["itd_user_unit"] == 4) 
                    $alink = 'itd_mutasi' . (0+$m1) . (0+$m2) . "_inquiry";
                else
                    $alink = 'itd_mutasi' . (0+$m1) . (0+$m2);
                $this->load->view($alink,$this->data);
            }
            /*switch(0+$m1)
            {
                case 1: 
                    switch(0+$m2)
                    {
                        case 1: $this->load->view('itd_report11',$this->data);
                            break;
                    }             
                    break;
            } */
        }
    }
        
    function list_client_by_code()
    {
        $this->load->model("M_mutasi");
        $param=$this->input->post();
        sql_quot_all($param);
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);
        $data = $this->M_mutasi->list_client_by_code($param["q"]);
        // $data = $this->M_mutasi->ListClient($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_client()
    {
        $this->load->model("M_mutasi");
        $data = $this->M_mutasi->list_client();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_coa()
    {
        $this->load->model("M_mutasi");
        
        $data = $this->M_mutasi->list_coa();
        $fields = array("modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_cli()
    {
        $this->load->model("M_mutasi");
        
        $data = $this->M_mutasi->list_cli();
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_last_balance_date()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $status=isset($param["cstatus"])?0+$param["cstatus"]:0;
        $cdt=isset($param["cdt"])?change_dt_format($param["cdt"]):"1/1/1900";  
        $data = $this->M_mutasi->get_last_balance_date($param["c_code"],$param["c_accno"],$cdt,$status); 
        $fields = array("last_date","last_closed_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_last_date_jasgir_by_user()
    {
        $param=$this->input->post();
        sql_quot_all($param); 
        $this->load->model("M_mutasi");  
        $data = $this->M_mutasi->get_last_date_jasgir_by_user($param["u_id"]); 
        $fields = array("giro_val_date","giro_asof_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_trx()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->list_trx($param["c_code"],$param["c_accno"],$param["c_dt"]); 
        $fields = array("created_dt","modified_dt");
        add_data_dt_tm_str($data,$fields);
        $fields = array("trx_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_balance()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->get_balance($param["c_code"],$param["c_accno"],$param["c_dt"]); 
        $fields = array("balance_date","balance_close_dt");
        add_data_dt_str($data,$fields);
        add_data_dt_t_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function add_trx()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->add_trx($param['c_code'],$param['c_no'],$param['c_dt'],$param['c_catcode'],$param['c_catdesc'],
                                        $param['c_desc'],$param['c_dc'],$param['c_nominal'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_trx()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->edit_trx(0+$param['trx_id'],$param['c_code'],$param['c_no'],$param['c_dt'],$param['c_catcode'],$param['c_catdesc'],
                                        $param['c_desc'],$param['c_dc'],$param['c_nominal'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function del_trx()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_mutasi->del_trx(0+$param['trx_id'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function close_day()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->close_day($param['c_code'],$param['c_no'],$param['c_dt'],$param['gs_bal'],$param['c_rem'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        //$_subject="ITD: Client {$param["c_code"]} balance mutation is closed by {$this->data['uid']}";
        //$_content="Client Code : {$param["c_code"]}<br />Date : {$param["c_dt"]}<br />GS Bal: " . number_format($param["gs_bal"],2,'.',',') . "<br /><br /> ITD Client Services System";
        //$this->_send_notif($_subject,$_content);
        
        //Matiin notif
        /*if(count($data)>0)
        {
            if( $data[0]["hiport_active"]==1 && $data[0]["client_type"]==1 || $data[0]["client_type"]==2)
            {
                $_subject="ITD: Mutation is closed by {$this->data['uid']}. ({$data[0]["client_code"]}-{$data[0]["client_name"]}) ";
                $_content="Client Code : {$data[0]["client_code"]}<br />Date : " . date_format($data[0]["balance_date"],"d M Y") . "<br />Closing Balance: " . number_format($data[0]["balance_close"],2,'.',',') . "<br />Saldo Balance: " . number_format($data[0]["balance_gs"],2,'.',',') . "<br /><br /> ITD Client Services System";
                $this->_send_notif($_subject,$_content);
            }
        } */
        $jasgir = $this->M_mutasi->check_jasgir($param['c_code'],$param['c_no']); 
        if($jasgir[0]['kena_jasgir'] == 1){
            $this->data["jasgir"] = $this->AutoJasaGiro(
                $param['gs_bal'],
                $param['c_dt'], //val date
                $param['c_dt'], //asof date
                $param['c_code'],
                $param['c_no'],
                $jasgir[0]['client_name']
            );
        }else{
            $this->data["jasgir"]= 'Tidak Kena Jasa Giro';
        }
        echo json_encode($this->data);
    }

    function cancel_close_day()
    {
        if($this->data["lvl"]<=5)
        {
            $this->load->model("M_mutasi");  
            $param=$this->input->post();
            sql_quot_all($param); 
            //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
            $param["c_dt"]=change_dt_format($param["c_dt"]);
            $data = $this->M_mutasi->cancel_close_day($param['c_code'],$param['c_no'],$param['c_dt'],$this->data['uid']); 
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
            if(count($data)>0)
            {
                if( $data[0]["hiport_active"]==1 && $data[0]["client_type"]==1 || $data[0]["client_type"]==2)
                {
                    $_subject="ITD: Mutation is cancelled by {$this->data['uid']}. ({$data[0]["client_code"]}-{$data[0]["client_name"]}) ";
                    $_content="Client Code : {$data[0]["client_code"]}<br />Date : " . date_format($data[0]["balance_date"],"d M Y") . "<br /><br /> ITD Client Services System";
                    $this->_send_notif($_subject,$_content);
                }
            }
            //$_subject="ITD: Client {$param["c_code"]} close balance mutation is canceled by {$this->data['uid']}";
            //$_content="Client Code : {$param["c_code"]}<br />Date : {$param["c_dt"]}<br /><br /><br /> ITD Client Services System";
            //$this->_send_notif($_subject,$_content);
        }
        else
        {
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = 0;
            $this->data["r_sdata"]= array();
        }
        echo json_encode($this->data);
    }
    function check_last_balance()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->check_last_balance($param["c_code"],$param["c_no"],$param["c_dt"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function open_day()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->open_day($param["c_code"],$param["c_name"],$param["c_no"],$param["c_dt"],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function open_day_all()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        
        $data = $this->M_mutasi->open_day_all($param["c_code"],$param["c_name"],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function del_client()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        
        $data = $this->M_mutasi->del_client(0+$param['client_id'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_jasgirmon()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        $data = $this->M_mutasi->list_jasgirmon(0+$param["f"],$param["dt1"],$param["dt2"]); 
        $fields = array("giro_val_date","giro_asof_date","created_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_list_jasgirmon()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        $data = $this->M_mutasi->list_jasgirmon(0+$param["f"],$param["dt1"],$param["dt2"]); 
        $fields = array("giro_val_date","giro_asof_date","created_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="jasa_giro.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_jasgirmon',$this->data);
    }
    function del_jasgirmon()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        $data = $this->M_mutasi->del_jasgirmon($param["giro_id"],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_balance()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
         $proc= isset($param["proc"])?$param["proc"]:"ALL";
         $cclient= isset($param["cclient"])?$param["cclient"]:"All";
        $data = $this->M_mutasi->list_balance($param["dt1"],$param["dt2"],$proc,$cclient); 
        $fields = array("balance_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_list_balance()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        $data = $this->M_mutasi->list_balance($param["dt1"],$param["dt2"]); 
        $fields = array("balance_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="balance_{$param["dt1"]}.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_balance',$this->data);
    }
    function get_rekening_mon()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_mutasi->get_rekening_mon($param["c_dt"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function get_client_id()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param);                         
        $data = $this->M_mutasi->get_client_id($param["c_code"],$param["c_no"]); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_mutasi_taxbro()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $today=getdate();
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        if($param["dt1"]=='')
        {
            $param["dt1"]= "{$today["year"]}-{$today["mon"]}-{$today["mday"]}";
            $param["dt2"]= "{$today["year"]}-{$today["mon"]}-{$today["mday"]}";
        }
        
        $data = $this->M_mutasi->list_mutasi_taxbro($param["dt1"],$param["dt2"],$param["coa"],$param["cdoc"]); 
        $fields = array("fb_dt","fb_doc_accepted_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function save_list_mutasi_taxbro()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["dt1"]=change_dt_format($param["dt1"]);
        $param["dt2"]=change_dt_format($param["dt2"]);
        $ccode = isset($param["ccode"])?$param["ccode"]:"";
        $data = $this->M_mutasi->list_mutasi_taxbro($param["dt1"],$param["dt2"],$param["coa"],$ccode); 
        $fields = array("trx_date");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $filename="taxbro_{$param["dt1"]}.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_taxbro',$this->data);
    }
    function compare_balance()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $dt1=change_dt_format($param["dt1"]);
        $dt2=change_dt_format($param["dt2"]);
        
        $data = $this->M_mutasi->compare_balance($dt1,$dt2); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $this->data["r_sdt1"]= $dt1;
        $this->data["r_sdt2"]= $dt2;
        $filename="selisih_{$param["dt1"]}_vs_{$param["dt2"]}.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('itd_mutasi11_compare',$this->data);
    }
    function _send_notif($notif_subject,$notif_content)
    {
        $this->load->model("M_notif");  
        $data = $this->M_notif->get_mail_info('default');   
        if(count($data)>0)
        {
            $this->load->library('My_phpmailer');
            $mail= new My_phpmailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;  
            $mail->Host = $data[0]["mail_host"];
            $mail->Port = $data[0]["mail_port"];
            //$mail->SMTPSecure=true;
            $mail->Username = $data[0]["mail_username"];
            $mail->Password = $data[0]["mail_password"];
            $mail->SMTPDebug =1;
            //$mail->Helo = "helo";

            $mail->From = $data[0]["mail_from"];
            $mail->FromName = $data[0]["mail_fromname"];
            
            $mailto = explode(',', $data[0]["mail_to"]);
            foreach($mailto as $mailaddr)
                $mail->AddAddress($mailaddr);
            $mail->Subject =  $notif_subject;
            $mail->Body = $notif_content;
            $mail->IsHTML(true);
            if($mail->Send())
                return true;
            else
                return false;
        }
        return false;
       
        
    }
    function set_permission()
    {
        $this->load->model("M_mutasi");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $this->M_mutasi->set_permission($param["c_code"],$param["c_no"],$param["c_dt"],$this->data['uid']); 
        //echo json_encode($this->data);
    }
    function v_frekap()
    {
        if($this->isLogin)
        {
            if(isset($_POST['dt1']))
            {
                $this->data['dt']='';
                $dt1=change_dt_format($_POST["dt1"]);
                $this->data['dt']=$_POST["dt1"];
                $this->load->model("M_mutasi");  
                $data = $this->M_mutasi->get_rekap_status($dt1); 
                $this->data['rdata']=$data;
                //$data = $this->M_mutasi->get_rekap_status_opened($dt1); 
                //$this->data['rdata1']=$data;
            }
            $this->load->view("itd_mutasi11_rekap",$this->data);
        }
    }
    function v_rekap()
    {
        if($this->isLogin)
        {
            if(isset($_POST['dt1']))
            {
                $this->data['dt']='';
                $dt1=change_dt_format($_POST["dt1"]);
                $this->data['dt']=$_POST["dt1"];
                $this->load->model("M_mutasi");  
                $data = $this->M_mutasi->get_rekap_status($dt1); 
                $this->data['rdata']=$data;
                //$data = $this->M_mutasi->get_rekap_status_opened($dt1); 
                //$this->data['rdata1']=$data;
            }
            $this->load->view("itd_mutasi11_rekaphtml",$this->data);
        }
    }

    public function backgroundToMutasi()
    {
        if (!$this->session->userdata('itd_uid')) {
            $this->session->set_userdata(array('itd_uid' => 'system'));
        }

        $this->load->model("M_mutasi");
        $date = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d') ;
        $mutasi_client = $this->M_mutasi->coaXmutasiClient($date);

        foreach ($mutasi_client as $key => $value) {
            $start_date = date('Y-m-d H:i:s');
            switch ($value['coa_id']) {                
                case 'C006':
                    $data = $this->M_mutasi->JualSahamToMutasiBackground($value);
                    break;
    
                case 'C007':
                    $data = $this->M_mutasi->JualObligasiToMutasiBackground($value);
                    break;
    
                case 'D004':
                    $data = $this->M_mutasi->BeliSahamToMutasiBackground($value);
                    break;
    
                case 'D005':
                    $data = $this->M_mutasi->BeliObligasiToMutasiBackground($value);
                    break;
    
                case 'D016':
                    $data = $this->M_mutasi->TaxBrokerToMutasiBackground($value);
                    break;
    
                case 'D017':
                    $data = $this->M_mutasi->TaxObligasiToMutasiBackground($value);
                    break;
                
                default:
                    $data = array('msg' => 'coa id tidak dikenali');
                    break;
            }
            $end_date = date('Y-m-d H:i:s');
            $this->M_mutasi->backgroudLog(
                $value['coa_id'],
                $value['client_code'],
                $value['acc_no'],
                $date,
                json_encode($data),
                $start_date,
                $end_date
            );
        }
    }

    public function set_mutasi_trx()
    {
        $this->load->model("M_mutasi");
        $param = $this->input->post();

        switch ($param['coa_id']) {
            case 'C002':
                $data = $this->M_mutasi->SubscribeToMutasi($param);
                break;

            case 'D002':
                $data = $this->M_mutasi->PenempatanToMutasi($param);
                break;

            case 'C003':
                $data = $this->M_mutasi->PencairanToMutasi($param);
                break;

            case 'D001':
                $data1 = $this->M_mutasi->RedemptionToMutasi($param);
                $data2 = $this->M_mutasi->RedemptionToMutasiBatavia($param);
                $data3 = $this->M_mutasi->RedemptionToMutasiBni($param);
                $data4 = $this->M_mutasi->RedemptionToMutasiCustody($param);
                $data5 = $this->M_mutasi->RedemptionToMutasiDiscre($param);
                $data6 = $this->M_mutasi->RedemptionToMutasiMega($param);
                $data7 = $this->M_mutasi->RedemptionToMutasiNiaga($param);
                $data8 = $this->M_mutasi->RedemptionToMutasiNiaga2($param);
                $data9 = $this->M_mutasi->RedemptionToMutasiSyailendra($param);
                $data10 = $this->M_mutasi->RedemptionToMutasiTrimegah($param);

                
                break;
            
            case 'C006':
                $data = $this->M_mutasi->JualSahamToMutasi($param);
                break;

            case 'C007':
                $data = $this->M_mutasi->JualObligasiToMutasi($param);
                break;

            case 'D004':
                $data = $this->M_mutasi->BeliSahamToMutasi($param);
                break;

            case 'D005':
                $data = $this->M_mutasi->BeliObligasiToMutasi($param);
                break;

            case 'D016':
                $data = $this->M_mutasi->TaxBrokerToMutasi($param);
                break;

            case 'D017':
                $data = $this->M_mutasi->TaxObligasiToMutasi($param);
                break;
            
            default:
                $data = array('msg' => 'coa id tidak dikenali');
                break;
        }
        echo json_encode($data);
    }

    public function mutasi_client()
    {
       return $this->load->view('mutasi_client');
    }

    public function mutasi_client_code()
    {
        $this->load->model("M_mutasi");
        $param=$this->input->post();
        sql_quot_all($param);
        $data = $this->M_mutasi->list_client_by_code($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }

    public function check_kategori()
    {
        $this->load->model("M_mutasi");
        $param = $this->input->post();
        sql_quot_all($param);
        $data = $this->M_mutasi->check_kategori($param);
        echo json_encode($data);
    }

    public function list_mutasi_by_group()
    {
        $this->load->model("M_mutasi");
        $param = $this->input->post();
        sql_quot_all($param);

        switch ($param['coa_no']) {
            case 'C001':
                $data = $this->M_mutasi->ListJasaGiro($param['client_code'],$param['acc_no']);
                break;

            case 'C002':
                $data = $this->M_mutasi->ListSubscribe($param['client_code'],$param['acc_no']);
                break;

            case 'D002':
                $data = $this->M_mutasi->ListPenempatan($param['client_code'],$param['acc_no']);
                break;
                
            case 'C003':
                $data = $this->M_mutasi->ListPencairan($param['client_code'],$param['acc_no']);
                break;

            case 'D001':
                $data1 = $this->M_mutasi->ListRedemption($param['client_code'],$param['acc_no']);
                $data2 = $this->M_mutasi->ListRedemptionBatavia($param['client_code'],$param['acc_no']);
                $data3 = $this->M_mutasi->ListRedemptionBni($param['client_code'],$param['acc_no']);
                $data4 = $this->M_mutasi->ListRedemptionCustody($param['client_code'],$param['acc_no']);
                $data5 = $this->M_mutasi->ListRedemptionDiscre($param['client_code'],$param['acc_no']);
                $data6 = $this->M_mutasi->ListRedemptionMega($param['client_code'],$param['acc_no']);
                $data7 = $this->M_mutasi->ListRedemptionNiaga($param['client_code'],$param['acc_no']);
                $data8 = $this->M_mutasi->ListRedemptionNiaga2($param['client_code'],$param['acc_no']);
                $data9 = $this->M_mutasi->ListRedemptionSyailendra($param['client_code'],$param['acc_no']);
                $data10 = $this->M_mutasi->ListRedemptionTrimegah($param['client_code'],$param['acc_no']);
                
                $data = array_merge(
                    $data1,
                    $data2,
                    $data3,
                    $data4,
                    $data5,
                    $data6,
                    $data7,
                    $data8,
                    $data9,
                    $data10
                );
                break;

            case 'C006':
                $data = $this->M_mutasi->ListJualSaham($param['client_code'],$param['acc_no']);
                break;
            case 'C007':
                $data = $this->M_mutasi->ListJualObligasi($param['client_code'],$param['acc_no']);
                break;

            case 'D004':
                $data = $this->M_mutasi->ListBeliSaham($param['client_code'],$param['acc_no']);
                break;
            case 'D005':
                $data = $this->M_mutasi->ListBeliObligasi($param['client_code'],$param['acc_no']);
                break;

            case 'D016':
                $data = $this->M_mutasi->ListTaxBroker($param['client_code'],$param['acc_no']);
                break;

            case 'D017':
                $data = $this->M_mutasi->ListTaxObligasi($param['client_code'],$param['acc_no']);
                break;
            
            default:
                $data = array();
                break;
        }

        echo json_encode($data);
    }

    public function list_mutasi_detail()
    {
        $this->load->model("M_mutasi");
        $param = $this->input->post();
        sql_quot_all($param);
        
        switch ($param['coa_no']) {

            case 'C002':
                $data = $this->M_mutasi->ListSubscribeDetail($param['client_code'], $param['acc_no'], $param['date']);
                break;
            
            case 'D002':
                $data = $this->M_mutasi->ListPenempatanDetail($param['client_code'], $param['acc_no'], $param['date']);
                break;

            case 'C003':
                $data = $this->M_mutasi->ListPencairanDetail($param['client_code'], $param['acc_no'], $param['date']);
                break;

            case 'D001':
                $data1 = $this->M_mutasi->ListRedemptionDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data2 = $this->M_mutasi->ListRedemptionBataviaDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data3 = $this->M_mutasi->ListRedemptionBniDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data4 = $this->M_mutasi->ListRedemptionCustodyDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data5 = $this->M_mutasi->ListRedemptionDiscreDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data6 = $this->M_mutasi->ListRedemptionMegaDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data7 = $this->M_mutasi->ListRedemptionNiagaDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data8 = $this->M_mutasi->ListRedemptionNiaga2Detail($param['client_code'],$param['acc_no'], $param['date']);
                $data9 = $this->M_mutasi->ListRedemptionSyailendraDetail($param['client_code'],$param['acc_no'], $param['date']);
                $data10 = $this->M_mutasi->ListRedemptionTrimegahDetail($param['client_code'],$param['acc_no'], $param['date']);


                $data = array_merge(
                    $data1,
                    $data2,
                    $data3,
                    $data4,
                    $data5,
                    $data6,
                    $data7,
                    $data8,
                    $data9,
                    $data10
                );
                break;
            case 'C006':
                $data = $this->M_mutasi->ListJualSahamDetail($param['client_code'],$param['acc_no'], $param['date']);
                break;

            case 'C007':
                $data = $this->M_mutasi->ListJualObligasiDetail($param['client_code'],$param['acc_no'], $param['date']);
                break;

            case 'D004':
                $data = $this->M_mutasi->ListBeliSahamDetail($param['client_code'],$param['acc_no'], $param['date']);
                break;

            case 'D005':
                $data = $this->M_mutasi->ListBeliObligasiDetail($param['client_code'],$param['acc_no'], $param['date']);
                break;

            case 'D016':
                $data = $this->M_mutasi->ListTaxBrokerDetail($param['client_code'],$param['acc_no'], $param['date']);
                break;

            case 'D017':
                $data = $this->M_mutasi->ListTaxObligasiDetail($param['client_code'],$param['acc_no'], $param['date']);
                break;
            
            default:
                $data = array();
                break;
        }

        echo json_encode($data);
    }

    public function debug()
    {
        // $this->load->model("M_mutasi");
        // $data = $this->M_mutasi->ListIGIncomeTax('000');
        // // $data = $this->M_mutasi->MutasiClient('000D2K','4582601627');
        // // $data = $this->M_mutasi->list_client_by_code('000D2K');
        
        // if ($this->session->userdata('itd_uid')) {
        //     echo var_dump($this->session->all_userdata());
        // }else{
        //     // $this->session->set_userdata(array('itd_uid' => 'system'));
        //     echo var_dump($this->session->all_userdata());
        // }
        
        
        // // echo json_encode($this->session->userdata('itd_uid'));
        // $date = '24-12-2019';
        // $dayOfWeek = date('w', strtotime($date));
        // switch ($dayOfWeek) {
        //     case 5:
        //         $date = date('Y-m-d', strtotime($date.'+3 day'));
        //         break;
        //     case 6:
        //         $date = date('Y-m-d', strtotime($date.'+2 day'));
        //         break;
        //     default:
        //         $date = date('Y-m-d', strtotime($date.'+1 day'));
        //         break;
        // }
        // echo $date;
    }

    public function AutoJasaGiro($GSBalance = 0, $valdate = '1900-01-01', $asofdate = '1900-01-01', $client_code = '', $acc_no = '', $client_name = '', $sumNetJasgir = 0)
    {
        $rate = $this->RateJasgir($GSBalance);
        if(!$rate){
            return 'Nominal kurang untuk membuat jasa giro';
            die();
        }

        $giro_year = 365;
        $CreditInterest = ($rate*$GSBalance)/$giro_year;
        $pajak          = 20/100;

        $whtax          = $CreditInterest*$pajak;
        $netJasgir      = $CreditInterest-$whtax;
        $totalSaldo     = $GSBalance+$netJasgir;

        $dayOfWeek      = date('w', strtotime($asofdate));
        $sumNetJasgir   = $netJasgir + $sumNetJasgir;
        $valdate        = date('Y-m-d H:i:s', strtotime($valdate));
        $asofdate       = date('Y-m-d', strtotime($asofdate.'+1 day'));

        switch ($dayOfWeek) {
            case 5:
                $this->AutoJasaGiro($totalSaldo, $valdate, $asofdate, $client_code, $acc_no, $client_name, $sumNetJasgir);
                break;
            case 6:
                $this->AutoJasaGiro($totalSaldo, $valdate, $asofdate, $client_code, $acc_no, $client_name, $sumNetJasgir);
                break;
            default:
                $mutasiGiro = array(
                    'giro_val_date' => $valdate,
                    'giro_asof_date' => $asofdate,
                    'giro_rate' => $rate*100,
                    'giro_tenor' => 1,
                    'giro_year' => $giro_year,
                    'client_code' => $client_code,
                    'client_name' => $client_name,
                    'acc_no' => $acc_no,
                    'giro_nominal' => $GSBalance,
                    'giro_interest' => $CreditInterest,
                    'giro_interest_tax' => $whtax,
                    'giro_interest_net' => $sumNetJasgir,
                    'created_by' => $this->session->userdata('itd_uid'),
                    'created_dt' => date('Y-m-d H:i:s')
                );
                $this->load->model("M_mutasi");
                $setMutasiGiro = $this->M_mutasi->SetMutasiGiro($mutasiGiro);
                $jasgirToMutasi = $this->M_mutasi->JasgirToMutasi();
                return "Total jasa giro : ".$sumNetJasgir;
                break;
        }
        
    }
    public function RateJasgir($GSBalance)
    {
        if($GSBalance >= 100000000 && $GSBalance <= 500000000){
            return 1.5/100;
        }else if($GSBalance >= 500000000 && $GSBalance <= 5000000000){
            return 2/100;
        }else if($GSBalance >= 5000000000){
            return 2.5/100;
        }
        return false;
    }
}
        
?>