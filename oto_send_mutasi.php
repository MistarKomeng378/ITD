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


$today=date('m/d/Y');
//$today='2/21/2017';

$tsql = "exec get_mutasi_client_status '{$today}'";
$stmt = sqlsrv_query( $conn, $tsql);
$datahtml="
<table bgcolor=\"#585858\" style=\"font-size:.8em\">
    <tr bgcolor=\"#E0E0E0\">
        <td>No.</td>
        <td>Code</td>
        <td>Nama</td>        
        <td>Account</td>     
        <td>Closed</td>
        <td>Status</td>
        <td align=\"right\">Bal Open</td>
        <td align=\"right\">Bal Trx</td>
        <td align=\"right\">Bal Close</td>
    </tr>";
$irow=0;
$ada=false;
while($row_data = sqlsrv_fetch_array($stmt)) 
{
    $ada=true;
    $color=$row_data['c_status']==0?"style=\"color:#800000\"":"";
    $datahtml.="<tr bgcolor=\"#FFFFFF\" {$color}>
        <td>" . ++$irow . "</td>
        <td>{$row_data['client_code']}</td>
        <td>{$row_data['client_name']}</td>
        <td align=\"center\">{$row_data['c_acc']}</td>
        <td align=\"center\">{$row_data['c_close']}</td>
        <td align=\"center\">" . ($row_data['c_status']==1?"Completed":"<span style=\"color:#800000\">Un-Completed</span>") . "</td>
        <td align=\"right\">" . ($row_data['c_status']==0?"":$row_data['s_open']) . "</td>
        <td align=\"right\">" . ($row_data['c_status']==0?"":$row_data['s_trx']) . "</td>
        <td align=\"right\">" . ($row_data['c_status']==0?"":$row_data['s_close']) . "</td>
    </tr>";
    
}
$datahtml.="</table>";
sqlsrv_free_stmt( $stmt); 


sqlsrv_close( $conn);



//print_r($row_mail);
//print_r($rmail);   
require_once('PHPMailer_v5.1/class.phpmailer.php');     

if($ada)
{
    
    $mail = new PHPMailer(); // defaults to using php "mail()"
    
    $mail->IsSMTP();
    $mail->SMTPAuth = true;  
    $mail->Host = $row_mail['mail_host'];
    $mail->Port = 25;
    $mail->Username = $row_mail['mail_username'];
    $mail->Password   = $row_mail['mail_password'];
    $mail->SMTPDebug =1;
    $mail->From = $row_mail['mail_from'];
    $mail->FromName = $row_mail['mail_fromname'];
    $mail->AddReplyTo($row_mail['mail_from'],$row_mail['mail_fromname']);
    $mail->SetFrom($row_mail['mail_from'],$row_mail['mail_fromname']);
    $mail->Subject    ="Status Mutasi Balance (" . date_format(date_create($today),'F d, Y') . ")";
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    
    $str_mail= str_replace(";",",",$row_mail['mail_to']);
    $mailto = explode(',', $str_mail);
    foreach($mailto as $mailaddr)
    {
        if(trim($mailaddr)!='')
            $mail->AddAddress($mailaddr);
    }
    
    /*$str_mail= str_replace(";",",",$row_mailint['mail_cc']);
    $mailcc = explode(',', $str_mail);
    
    foreach($mailcc as $mailaddr)
    {
        if(trim($mailaddr)!='')
        {
            $mail->AddCC($mailaddr);
        }
    } */
    
    $body = "<body>Dear All,<br /><br />
        Berikut status mutasi balance client hari ini ". date_format(date_create($today),'d F Y') ." : <br />{$datahtml}<br /><u>Agar segera ditindak lanjuti bila masih uncompleted(ada yang belum closing day).</u><br /><br />Regards,<br/>ITD System
    </body>";
    //echo $body;
    
    $mail->MsgHTML($body);
    
   if($mail->Send()) {
       echo "mail_send";
   }
}
    
    //$tsql = "sp_mail_date_update '{$today}'";
    //$stmt = sqlsrv_query( $conn, $tsql);

/**/
?>
