<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//ini controler subscript
class Subsrd extends CI_Controller { 
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
    function v_subsrd()
    {
        if($this->isLogin)
        {                             
            if($this->data["itd_user_unit"] ==3 || $this->data["itd_user_unit"] == 4) 
                $this->load->view("subsrd_inquiry",$this->data);
            else
            {
                $this->load->view("subsrd",$this->data);
            }
            
        }
    }
    function v_dlg1()
    {
        if($this->isLogin)
            $this->load->view("subsrd_dlg1",$this->data);
    }
    function list_client_by_code()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        $param["q"]=isset($param["q"])?$param["q"]:'';
        sql_quot_all($param);
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);
        $data = $this->M_subsrd->list_client_by_code($param["q"]);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    
    function open_day()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);             //print_r($param);
        $data = $this->M_subsrd->open_day($param['c_code'],$param['c_dt'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function close_day()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);             //print_r($param);
        $data = $this->M_subsrd->close_day($param['c_code'],$param['c_dt'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function cancel_close_day()
    {
        if($this->data["lvl"]<=5)
        {
            $this->load->model("M_subsrd");  
            $param=$this->input->post();
            sql_quot_all($param); 
            //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
            $param["c_dt"]=change_dt_format($param["c_dt"]);             //print_r($param);
            $data = $this->M_subsrd->cancel_close_day($param['c_code'],$param['c_dt'],$this->data['uid']); 
            $this->data["r_success"] = 1;
            $this->data["r_num_rows"] = count($data);
            $this->data["r_sdata"]= $data;
        }
        else
        {
            $this->data["r_success"] = 0;
            $this->data["r_num_rows"] = 0;
            $this->data["r_sdata"]= array();
        }
        echo json_encode($this->data);
    }
    function get_status()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        $data = $this->M_subsrd->get_status($param['c_code'],$this->data['uid']); 
        $fields = array("subsrd_date",'last_closed');
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function list_data()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_subsrd->list_data($param['c_code'],$param['c_dt'],$this->data['uid']); 
        $fields = array("subsrd_date","modified_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data; 
        echo json_encode($this->data);
    }
    function view_rekap_data()
    {            
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        
        if(!isset($param["c_dt"]))
            $param["c_dt"]='01-01-1900';
        if(!isset($param["c_code"]))
            $param["c_code"]='';
        sql_quot_all($param);      
        $this->data["dt"]= $param["c_dt"];
        $param["c_dt"]=change_dt_format($param["c_dt"]); 
        
        $data = $this->M_subsrd->list_sa($param["c_code"],$this->data["uid"]); 
        $this->data["r_num_rows_h"] = count($data);
        $this->data["r_sdata_h"]= $data;
        $arr_h=array();                         
        foreach($data as $rec_item) 
            $arr_h[$rec_item["sa_id"]]=0;
        
        $data = $this->M_subsrd->rekap_data($param["c_code"],$param["c_dt"],$this->data["uid"]); 
                                                
        $data_row=0;
        foreach($data as $rec_item)
        {
            foreach($this->data["r_sdata_h"] as $rec_item1)
            {                                     
                if($rec_item[$rec_item1["sa_id"]]>0)
                {
                    $data[$arr_h[$rec_item1["sa_id"]]][$rec_item1["sa_id"]]=$rec_item[$rec_item1["sa_id"]];
                    if($arr_h[$rec_item1["sa_id"]]!=$data_row)
                        $data[$data_row][$rec_item1["sa_id"]]=0;                    
                    $arr_h[$rec_item1["sa_id"]]++; 
                }
            }
            $data_row++;
        }
        $data_row=0;
        foreach($data as $rec_item)
        {
            $ada=false;
            foreach($this->data["r_sdata_h"] as $rec_item1)
            {                                     
                if($rec_item[$rec_item1["sa_id"]]>0)
                    $ada=true;
            }
            //echo ($ada?'1':'0')  . '|';
            if(!$ada)
                break;
            $data_row++;
        }
        array_splice($data,$data_row);
                                                         
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        $this->load->view("subsrd_rekap",$this->data);
    }
    function list_sa()
    {
        $this->load->model("M_subsrd");
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);
        $data = $this->M_subsrd->list_sa($param["b_code"],$this->data['uid']);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function add_subsrd()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        $param["c_dt"]=change_dt_format($param["c_dt"]);             //print_r($param);
        $data = $this->M_subsrd->add_subsrd($param['c_code'],$param['c_dt'],$param['c_said'],$param['c_accsrc'],$param['c_accdst'],$param['c_desc'],$param['c_nominal'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function edit_subsrd()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        //$param["c_dt"]=change_dt_format($param["c_dt"]);             //print_r($param);
        //$data = $this->M_subsrd->edit_subsrd($param['c_id'],0+$param['c_nominal'],$this->data['uid']); 
        $data = $this->M_subsrd->edit_subsrd($param['c_id'],$param['c_said'],$param['c_accsrc'],$param['c_accdst'],$param['c_desc'],$param['c_nominal'],$this->data['uid']); 
        
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function del_subsrd()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    echo 
        //$param["c_dt"]=change_dt_format($param["c_dt"]);             //print_r($param);
        $data = $this->M_subsrd->del_subsrd($param['c_id'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    }
    function print_instruksi_cs($c_code,$c_dt,$c_gdt,$c_bank='')
    {
        $c_date=change_dt_format($c_dt); 
        $c_gdate=change_dt_format($c_gdt); 
        $c_bank=isset($c_bank)?$c_bank:'';
        $this->load->model("M_subsrd");  
        $data = $this->M_subsrd->get_instruksi_param('IPBRR',$this->data['uid']);                
        $this->data["r_sparam"]= $data;
        $data = $this->M_subsrd->get_balance_status($c_code,$c_date,$this->data['uid']);         
        $this->data["r_status"]= $data;
        $data = $this->M_subsrd->rekap_bal_per_bank($c_code,$c_date,$c_bank,$c_gdate,$this->data['uid']);       
        $arr_bank=array();
        $arr_bank_data=array();
        $bank='';
        $i=0;
        foreach($data as $rec1)
        {
            if($bank!=$rec1["bank_code_src"].'_'.$rec1["acc_no_src"])
            {
                $arr_bank[$i]['bank_code_src']=$rec1["bank_code_src"];
                $arr_bank[$i]['bank_name_src']=$rec1["bank_name_src"];
                $arr_bank[$i++]['acc_no_src']=$rec1["acc_no_src"];
                $bank=$rec1["bank_code_src"].'_'.$rec1["acc_no_src"];
            }
            $arr_bank_data[$bank][]=array("src_no"=>$rec1["acc_no_src"],"src_name"=>$rec1["acc_name_src"],"src_bank"=>$rec1["bank_name_src"],
                "dst_no"=>$rec1["acc_no_dst"],"dst_name"=>$rec1["acc_name_dst"],"dst_bank"=>$rec1["bank_name_dst"],"balance"=>$rec1["balance"]);
        }
        $this->data["r_sdata"]= $data; 
        $this->data["r_sbank"]= $arr_bank;           // print_r($arr_bank);
        $this->data["r_sbank_data"]= $arr_bank_data;  //print_r($arr_bank_data);
        $this->load->view("subsrd_print_instruksi_cs",$this->data);
    }
    function get_balance_status()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param); 
        //$data = $this->M_itd->list_client_by_code($param["client_code"]);    
        $param["c_dt"]=change_dt_format($param["c_dt"]);
        $data = $this->M_subsrd->get_balance_status($param['c_code'],$param['c_dt'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
       echo @json_encode($this->data);
    }
    function get_bank_by_client()
    {
        $this->load->model("M_subsrd");  
        $param=$this->input->post();
        sql_quot_all($param);     
        $data = $this->M_subsrd->get_bank_by_client($param['c_code'],$this->data['uid']); 
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
       echo @json_encode($this->data);
    }
    
    
}
        
?>