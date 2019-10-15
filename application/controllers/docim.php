<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Docim extends CI_Controller { 
    var $isLogin;
    var $data;          
    var $ip='172.25.115.30';
    var $base_dir = "F:/DBDOCIM/DB/";
    var $tmp_dir = "F:/DBDOCIM/TMP/";
    function __construct()
    {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->library('session');      
        $this->isLogin =   $this->is_login();
        $this->data = array("r_login"=>$this->isLogin,"r_success"=>0, "r_err_desc"=>"", "r_num_rows"=>0, "r_sdata"=>"",
                "url"=>base_url(),"nm"=>$this->session->userdata('itd_nm'),"uid"=>$this->session->userdata('itd_uid'),"lvl"=>$this->session->userdata('itd_lvl'),
                "itd_key"=>$this->session->userdata('itd_key')); 
         //system('net use R: "\\172.25.115.30\data_docim" custody1 /user:usr_it /persistent:no');                
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
    function get_docim_search()
    {
       $param=$this->input->post();
        sql_quot_all($param);
            
        $param["s_sdt"]=change_dt_format($param["s_sdate"]);
        $param["s_edt"]=change_dt_format($param["s_edate"]);
        $param["i_sdt"]=change_dt_format($param["i_sdate"]);
        $param["i_edt"]=change_dt_format($param["i_edate"]);
        $param["s_sdt"]=$param["s_sdt"]==''?'1900-01-01':$param["s_sdt"];
        $param["s_edt"]=$param["s_edt"]==''?'1900-01-01':$param["s_edt"];
        $param["i_sdt"]=$param["i_sdt"]==''?'1900-01-01':$param["i_sdt"];
        $param["i_edt"]=$param["i_edt"]==''?'1900-01-01':$param["i_edt"];
        $this->load->model("M_docim");
        $data = $this->M_docim->get_docim_search($param["c_id"],$param["f_id"],$param["b_id"],$param["s_sdt"],$param["s_edt"],$param["i_sdt"],$param["i_edt"]);
        
        $fields = array("scan_dt","instruction_dt","letter_dt");
        add_data_dt_str($data,$fields);
        $this->data["r_success"] = 1;
        $this->data["r_num_rows"] = count($data);
        $this->data["r_sdata"]= $data;
        echo json_encode($this->data);
    } 
    function v_docim_search()
    {
        if($this->isLogin)
            $this->load->view('docim_dlg_search',$this->data);
    }
    function v_docim_listing()
    {
        if($this->isLogin)
            $this->load->view('docim_dlg_listing',$this->data);
    }
    function open_doc($fname="")
    {
        if (trim($fname)=="")
            return 0;
        $docid= 0+ substr($fname,0,strlen($fname)-36);
        $docname=substr($fname,2,32);
        $this->load->model("M_docim");
        $data = $this->M_docim->get_docim($docid);
        if(count($data)>0)
        {
            if($docname=md5($data[0]["filename"]))
            {                                 
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="'. $fname . '"');
                
                $arr = explode('-',$s_dt);
                $folder=date_format($data[0]['scan_dt'],"dmY");
                $filename = $this->base_dir . $folder . '/' . $data[0]["filename"];
                $handle = fopen($filename, "rb");
                $contents = fread($handle, filesize($filename));
                fclose($handle);
                echo $contents; 
            }
            else
                echo "Data tidak ditemukan";
        }                                                       
        else
            echo "Data tidak ditemukan";
    }
    function v_tmp_folder()
    {                                  
        if (is_dir($this->tmp_dir)) {  
            echo "<table width=\"100%\" border=\"0\">";
            $brs=0;
            if ($dh = opendir($this->tmp_dir)) {
                while (($file = readdir($dh)) !== false) {
                    if($file!='.' && $file!='..' && filetype($this->tmp_dir . $file)=='dir')
                    {
                        if ($brs % 4 ==0)
                            echo "<tr>";
                        echo "<td width=\"25%\" ><input type=\"checkbox\" name=\"c_dirlist\" value=\"{$file}\" />{$file}</td>";
                        $brs++;
                        if ($brs % 4 ==0)
                            echo "</tr>";
                    }
                }
                closedir($dh);
            }
            echo "</table>";
        }
    }
    function do_docim_listing() 
    {
        $param=$this->input->post();
        $dir_list= explode(",",$param["dir_list"]);
        if(count($dir_list)>0 && $param["dir_list"]!='')
        {
            $this->load->model("M_docim");
            foreach($dir_list as $dir)
            {
                if ($dh = opendir($this->tmp_dir . $dir)) 
                {
                    $nfile=0;
                    $ffile=0;
                    if ($this->_is_ddmmyyyy_nodim($dir))
                    {
                        if (is_file($this->tmp_dir . $dir . '/Thumbs.db'))
                            unlink($this->tmp_dir . $dir . '/Thumbs.db');    
                        if(!is_dir($this->base_dir . $dir))
                            mkdir($this->base_dir . $dir,0777,true);
                        $this->M_docim->create_docim_tmp($this->_ddmmyyyy_2_yyyymmdd_nodim($dir));
                        while (($file = readdir($dh)) !== false) 
                        { 
                            if($file!='.' && $file!='..' && filetype($this->tmp_dir . $dir . '/' . $file)=='file')
                            {
                                if(strtoupper(substr($file,-3))=="PDF")
                                {
                                    $ffile++;
                                    $arr_desc = explode("-",substr($file,0,strlen($file)-4));
                                    if(count($arr_desc)==7)
                                    {
                                        if($this->_is_ddmmyyyy_nodim($arr_desc[1]) && $this->_is_ddmmyyyy_nodim($arr_desc[3]))
                                        {
                                            
                                            $this->M_docim->insert_docim_tmp($arr_desc[2],$arr_desc[4],$arr_desc[0],$this->_ddmmyyyy_2_yyyymmdd_nodim($dir),$this->_ddmmyyyy_2_yyyymmdd_nodim($arr_desc[1]),$this->_ddmmyyyy_2_yyyymmdd_nodim($arr_desc[3]),0+trim($arr_desc[5]),$file,$this->data["uid"]);
                                            if(is_file($this->base_dir . $dir . '/' . $file))    
                                                unlink($this->base_dir . $dir . '/' . $file);
                                            rename($this->tmp_dir . $dir . '/' . $file,$this->base_dir . $dir . '/' . $file);
                                            $nfile++;
                                            $ffile--;
                                        }
                                    }
                                }
                            }
                        }
                        $this->M_docim->copy_docim_tmp($this->_ddmmyyyy_2_yyyymmdd_nodim($dir));
                        echo "<br />Dir {$dir} listing {$nfile} files and failed {$ffile} files..\n";
                    }
                    closedir($dh);
                    if($ffile==0)
                        rmdir($this->tmp_dir . $dir );                    
                }
            }                                             
        }
    }
    function _is_ddmmyyyy_nodim($args_dt)
    {
        if($args_dt!="" && strlen(trim($args_dt))==8)
        {
            $tgl= 0+substr(trim($args_dt),0,2);
            $bln= 0+substr(trim($args_dt),2,2);
            $th= 0+substr(trim($args_dt),4,4);
            if(checkdate($bln,$tgl,$th))
                return true;   
        }
        return false;
    }
    function _ddmmyyyy_2_yyyymmdd_nodim($args_dt)
    {
        if($args_dt!="" && strlen(trim($args_dt))==8 )
        {
            $tgl= 0+substr(trim($args_dt),0,2);
            $bln= 0+substr(trim($args_dt),2,2);
            $th= 0+substr(trim($args_dt),4,4);
            if(checkdate($bln,$tgl,$th))
            {
                return $th . "-" . $bln . "-" . $tgl;   
            }
        }
        return "";
    }       
}
        
?>