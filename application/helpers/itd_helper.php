<?php  
function sql_quot($str_val)
{
    return str_replace("'","''",trim($str_val));
}
function sql_quot_all(&$arr)
{
    array_walk($arr,"remove_bad_string");  
}
function trim_all_array_items(&$arr)
{
    array_walk($arr,"item_trim");
}
function item_trim(&$item1,$key)
{
    $item1=trim($item1);
}
function remove_bad_string(&$item1,$key)
{
    $item1 = str_replace("'","''",trim($item1));
    //$item1 = str_replace(";","",trim($item1));
}

function remove_bad_sql($str_val)
{
    $item1 = str_replace("'","''",trim($str_val));
    //$item1 = str_replace(";","",trim($str_val));
    return $item1;
}

function str_sql_number($val,$nil = true)
{
    if($nil)
        return (trim($val)=='')?"NULL":(0+$val);
    else
        return 0+$val;
}
function str_sql_string($val,$nil = false)
{
    if($nil)
        return (trim($val)=='')?"NULL":"";
    else
        return trim($val);
}

function make_dt_rite($str_dt,$delm)
{
    
    $tmp_dt = explode($delm,trim($str_dt));
    if(count($tmp_dt)==3)
    {
        $d0 = strlen(trim($tmp_dt[0]))>2?substr('0000'. trim($tmp_dt[0]),-4):substr('0000'. trim($tmp_dt[0]),-2);
        $d1 = strlen(trim($tmp_dt[1]))>2?substr('0000'. trim($tmp_dt[1]),-4):substr('0000'. trim($tmp_dt[1]),-2);
        $d2 = strlen(trim($tmp_dt[2]))>2?substr('0000'. trim($tmp_dt[2]),-4):substr('0000'. trim($tmp_dt[2]),-2);
        return  $d0 . $delm . $d1 . $delm . $d2; 
    }
    else
        return "";
}
function cek_date($str_dt,$no=1)                                          
{
    if($no==1)
        return preg_match('/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/',make_dt_rite($str_dt,'-'));
    elseif($no==2)
        return preg_match('/^([0-9]{2})/([0-9]{2})/([0-9]{4})$/',make_dt_rite($str_dt,'/'));
    elseif($no==3)
        return preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/',make_dt_rite($str_dt,'-'));
    else
        return preg_match('/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/',make_dt_rite($str_dt,'-'));
}
function is_there_empty_val($arr,$excp = array())
{
    foreach($arr as $key => $item)
        if(trim($item)=="" && !in_array($key,$excp))
            return true;
    return false;
}
function change_dt_format($str_dt,$tipe=1)
{
    if (cek_date($str_dt))
    {
        if($tipe==1)
            return preg_replace('/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/','${2}/${1}/${3}',make_dt_rite($str_dt,'-'));
        if($tipe==500)
            return preg_replace('/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/','${3}-${2}-${1}',make_dt_rite($str_dt,'-'));
        elseif($tipe==2)
            return preg_replace('/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/','${1}/${2}/${3}',make_dt_rite($str_dt,'-'));
        else
            return preg_replace('/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/','${2}/${1}/${3}',make_dt_rite($str_dt,'-'));
    }
    else
        return preg_replace('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/','${2}/${1}/${3}',make_dt_rite($str_dt,'/'));
    return "";
}

function get_str_now($tipe=1)
{
    $now=getdate();
    if ($tipe==1)
        return $now["mon"] . "/" . $now["mday"] . "/" . $now["year"];
    else
        return $now["year"] . "-" . $now["mon"] . "-" . $now["mday"];
}
function get_str_sum($str)
{   
    if(ctype_digit($str))
    {
        $jml =0;
        for($i=0;$i<strlen($str);$i++)
        {
            $jml += $str{$i};
        }
        return $jml;
    }
    else
        return 0;
}
function get_str_mul($str1,$str2)
{   
    if(ctype_digit($str1) & strlen($str1)==6)
    {
        $str3='000000';
        for($i=0;$i<strlen($str1);$i++)
        {
            $str3{$i} = '' . ((0+$str1{$i})  * (0+$str2{$i}) );
        }
        return $str3;
    }
    else
        return '000000';
}
function get_dt_sum($dt)
{
    $y = substr($dt,2,2);
    $m = substr($dt,5,2);
    $d =  substr($dt,8,2);
    $sumdate = '' . (0+$y+$m+$d);
    return $sumdate;
}
function encode_time($tm)
{
    return preg_replace('/^([0-9]{2}):([0-9]{2})$/','${1}.${2}',$tm);   
}
function decode_time($tm)
{
    return preg_replace('/^([0-9]{2}).([0-9]{2})$/','${1}:${2}',$tm);   
}
function check_row($r,$rf)
{
    $arr_err = array(0,count($r)+2,false);
    $arr_err[0]=true;
    $count_rf = count($rf);
    if(count($r)==$rf)
        $arr_err[1]=true;
    else
        $arr_err[0]=false;
    for($i=0;$i<count($r);$i++)
    {
        if($i<$count_rf)
        {
            if($rf[$i]=='s')
                $arr_err[$i+2]=true;
            elseif($rf[$i]=='n')
            {
                if(is_numeric($r[$i]))
                    $arr_err[$i+2]=true;
                $arr_err[0]= $arr_err[0] & $arr_err[$i+2];
            }
            elseif($rf[$i]=='d1')
            {
                if(cek_date($r[$i],2))
                {
                    list($m,$d,$y) = split('/',$r[$i]);
                    $dm = (0+$m) <13 && (0+$m)>0?true:false;
                    $dm = $dm & ( (0+$d) <32 && (0+$d)>0?true:false);
                    $dm = $dm & ((0+$y)>0?true:false);
                    $arr_err[$i+2]=$dm;
                    $arr_err[0]= $arr_err[0] & $arr_err[$i+2];
                }
            }
            elseif($rf[$i]=='d2')
            {
                if(cek_date($r[$i],3))
                {
                    list($y,$m,$d) = split('-',$r[$i]);
                    $dm = (0+$m) <13 && (0+$m)>0?true:false;
                    $dm = $dm & ( (0+$d) <32 && (0+$d)>0?true:false);
                    $dm = $dm & ((0+$y)>0?true:false);
                    $arr_err[$i+2]=$dm;
                    $arr_err[0]= $arr_err[0] & $arr_err[$i+2];
                }
            }
            
        }
            
    }
    return $arr_err;
}
function add_data_dt_str(&$pdata,$fields)
{
    //print_r($pdata);
    for ($i=0;$i<count($pdata);$i++)
    {
        foreach($fields as $item)
        {
            if(is_object($pdata[$i][$item]))
                $pdata[$i][$item."_s"] = date_format($pdata[$i][$item],"d-m-Y");
            else
                $pdata[$i][$item."_s"] ="";
        }
    }
}
function add_data_dt_tm_str(&$pdata,$fields)
{
    //print_r($pdata);
    for ($i=0;$i<count($pdata);$i++)
    {
        foreach($fields as $item)
        {
            if(is_object($pdata[$i][$item]))
                $pdata[$i][$item."_st"] = date_format($pdata[$i][$item],"d-m-Y h:m:s");
            else
                $pdata[$i][$item."_st"] ="";
        }
    }
}
function add_data_dt_t_str(&$pdata,$fields)
{
    //print_r($pdata);
    for ($i=0;$i<count($pdata);$i++)
    {
        foreach($fields as $item)
        {
            if(is_object($pdata[$i][$item]))
                $pdata[$i][$item."_t"] = date_format($pdata[$i][$item],"h:m:s");
            else
                $pdata[$i][$item."_t"] ="";
        }
    }
}

function str_to_number($strnumber,$abs=false)
{
    //if (substr($strnumber,0,1)=='(')
    //    $a = '-' . str_replace(')','',str_replace('(','',str_replace(',','',$strnumber)));
    //else
        $a = str_replace(',','',$strnumber);    alert('asssuu');
    if($abs)
        return abs(0+$a);
    else
        return ($a*1);
    
}
//function diff

function utf8_convert($array)
{
    array_walk_recursive($array,'konver');
    return $array;
}
function konver(&$item,$key)
{
    if(is_string($item))
    {
        if(!mb_detect_encoding($item,'utf-8',true))
        {
            $item = utf8_encode($item);
        }
    }
}
?>
