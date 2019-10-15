<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>

<div style="width: 95%; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">
Subscription Reksadana
</div>
<div style="width: 95%;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <input type="hidden" id="i_subsrd_client_code_h" value="0">
            <tr>
                <td>
                    <table width="100%" border="0">
                        <tr>
                            <td width="1%">Code</td>
                            <td width="1%">Client Name</td>
                            <td width="1%">Last Date</td>  
                            <td>Last Status</td>  
                        </tr>
                        <tr>
                            <td><input type="text" id="i_subsrd_client_code" style="width:60px;text-align: center;"  /></td>
                            <td><input type="text" id="i_subsrd_client_name" style="width:320px;text-align: left;" readonly  /></td>
                            <td><input type="text" id="i_subsrd_client_last_date" style="width:90px;text-align: center;" readonly  /></td>
                            <td><input type="text" id="i_subsrd_client_status" style="width:90px;text-align: center;" readonly  /></td>
                        </tr>
                    </table>
                </td>
            </tr>
                          
            <tr>
                <td width="1%">Tanggal</td>
            </tr>
            <tr>
                <td><input type="text" id="i_subsrd_client_dt" style="width:65px;text-align: center;" class="dtpick"  /></td>
            </tr>
        </table>       
    </div> 
    <div style="display:block; margin:0; padding: 0;" align="center" id="subsrd_rekap">
        
    </div>
</div>

<?php } ?>
<?php } ?>