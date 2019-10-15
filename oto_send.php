<?php
define("BASEPATH",'itd');
include('application/config/database.php');
$connectionInfo = array( "UID"=>$db['dbjasgir']['username'],
                         "PWD"=>$db['dbjasgir']['password'],
                         "Database"=>$db['dbjasgir']['database']);
                         
$conn = sqlsrv_connect( $db['dbjasgir']['hostname'], $connectionInfo);

if( $conn === false )
{
     echo "Unable to connect1.</br>";
     die( print_r( sqlsrv_errors(), true));
} 

$tsql = "exec dbo.notif_get_mail_info";
$stmt = sqlsrv_query( $conn, $tsql);

$row_mail = sqlsrv_fetch_array($stmt);


sqlsrv_free_stmt( $stmt); 
sqlsrv_close( $conn);     

$today=date('m/d/Y');
$todaytime=date("H:i");
//$today='3/5/2016';

$connectionInfo = array( "UID"=>$db['default']['username'],
                         "PWD"=>$db['default']['password'],
                         "Database"=>$db['default']['database']);
                         
$conn = sqlsrv_connect( $db['default']['hostname'], $connectionInfo);
                         


if( $conn === false )
{
     echo "Unable to connect2.</br>";
     die( print_r( sqlsrv_errors(), true));
} 

$tsql = "exec dbo.list_trx_due_mail '{$today}'";
$stmt = sqlsrv_query( $conn, $tsql);



$gcode='';
$rmail = array();
$nrow=0;
while($row_data = sqlsrv_fetch_array($stmt)) 
{
    if($gcode!=$row_data['group_code'])
    {
        $rmail[$nrow++]=array("gname"=>$row_data['group_name'],'gmail'=>$row_data['group_mail'],'gmailcc'=>$row_data['group_mail_cc'],"data"=>array());
        $gcode=$row_data['group_code'];
    }
    $rmail[$nrow-1]['data'][]=array('vdt'=>$row_data['trx_valuta_date'],'ddt'=>$row_data['trx_due_date'],"to"=>$row_data['trx_to'],"cn"=>$row_data['trx_client_name'],
                                'nom'=>$row_data['trx_nominal'],'rate'=>$row_data['trx_rate']);
}

sqlsrv_free_stmt( $stmt); 



//echo 'tes';
//print_r($row_mail);
//print_r($rmail);   
$adasendemail=false;
require_once('PHPMailer_v5.1/class.phpmailer.php');     
foreach($rmail as $item1)
{
    if(count($item1['data'])>0)
    {
        
        $mail = new PHPMailer(); // defaults to using php "mail()"

        //$mail->IsSendmail(); // telling the class to use SendMail transport

        //$body             = file_get_contents('contents.html');
        //$body             = eregi_replace("[\]",'',$body);

        $mail->IsSMTP();
        $mail->SMTPAuth = true;  
        $mail->Host = $row_mail['mail_host'];
        $mail->Port = 25;
        //$mail->SMTPSecure=true;
        $mail->Username = $row_mail['mail_username'];
        $mail->Password   = $row_mail['mail_password'];
        $mail->SMTPDebug =1;
        //$mail->Helo = "helo";


        $mail->From = $row_mail['mail_from'];
        $mail->FromName = $row_mail['mail_fromname'];

        $mail->AddReplyTo($row_mail['mail_from'],$row_mail['mail_fromname']);

        $mail->SetFrom($row_mail['mail_from'],$row_mail['mail_fromname']);



        //$mail->Subject    = $row_mail['mail_subject'] . ": {$item1['mi_name']} - {$item1['sa_name']}";
        $mail->Subject    ="TD Maturity notification (" . date_format(date_create($today),'F d, Y') . ")";
        
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        
        
        $str_mail= str_replace(";",",",$item1['gmail']);
        $mailto = explode(',', $str_mail);
        foreach($mailto as $mailaddr)
        {
            if(trim($mailaddr)!='')
                $mail->AddAddress($mailaddr);
        }
        
        $str_mail= str_replace(";",",",$item1['gmailcc']);
        $mailcc = explode(',', $str_mail);
        
        foreach($mailcc as $mailaddr)
        {
            if(trim($mailaddr)!='')
            {
                //echo $mailaddr;
                $mail->AddCC($mailaddr);
            }
        }
        
        $str_pf="<table bgcolor=\"#000000\"><tr bgcolor=\"#F0F0F0\"><td><b>Bank Name</b></td><td><b>Name</b></td><td align=\"right\"><b>Nominal</b></td><td align=\"right\"><b>Rate</b></td><td><b>Valuta Date</b></td><td><b>Due Date</b></td></tr>";
        foreach($item1['data'] as $item2)
        {
            $str_pf.="<tr bgcolor=\"#ffffff\"><td>" . ucwords(strtolower($item2['to'])) ."</td><td>" . ucwords(strtolower($item2["cn"])) . "</td><td align=\"right\">" . number_format($item2["nom"],2,'.',',') . "</td><td align=\"right\">" . number_format($item2['rate'],2,'.',',') . "</td><td>" . date_format($item2['vdt'],"F d, Y") ."</td><td>" . date_format($item2['ddt'],"F d, Y") ."</td></tr>";
        }
        $str_pf.="</table>";
        
        $body = "<body>Dear Clients,<br /><br />Below please find Time Deposit Matured on " . date_format(date_create($today),'F d, Y') . ".<br /> ". $str_pf ."<br />Kindly send instruction regarding the above TD matured. Please ignore if instruction is already sent to us.<br /><i><span style=\"font-size:10.0pt;\">This Email is automatically computer generated. Please do not reply.</span></i><br /><br />Thank you for your kind attention.<br><br><span style=\"font-size:12.0pt;font-family:Mistral;color:#1F497D\">Best Regards,</span><br> <br>Client Services Division<br />Custody Services Group<br><span style=\"font-size:9pt;\">Graha Niaga lt. 7, Jl. Jend Sudirman kav. 58, Jakarta | Ph. (62-61) 250-5252 ext: 37021/37045/37043/37038| Fax. 250-5206/250-5189/527-6051</span></body>";
        //echo $body;
        
        $mail->MsgHTML($body);
        
       if($mail->Send()) {
           echo "mail_send";
           $adasendemail=true;
       }
    }
    
    if($adasendemail)
    {
        $tsql = "insert into itd_reminder_log(run_date,run_time,sended) values('{$today}','{$todaytime}',1)";
        $stmt = sqlsrv_query( $conn, $tsql);
        sqlsrv_free_stmt( $stmt); 
    }
    
    sqlsrv_close( $conn);       
}
/**/
?>