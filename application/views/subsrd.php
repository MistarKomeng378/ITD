<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>
<!-- FORM INPUT SUBSCRIPTION -->
<div style="width: 95%; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">
Subscription Reksadana
</div>
<div style="width: 95%;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <input type="hidden" id="i_subsrd_client_code_h" value="">
        <input type="hidden" id="i_subsrd_bank_code_h" value="">
        <table width="100%" border="0">
            <tr>
                <td width="1%">Code</td>
                <td width="1%">Client Name</td>
                <td width="1%">Last Date</td>  
                <td  width="1%">Last Status</td>  
                <td>Last Closed Date</td>
            </tr>
            <tr>
                <td><input type="text" id="i_subsrd_client_code" style="width:60px;text-align: center;"  /></td>
                <td><input type="text" id="i_subsrd_client_name" style="width:320px;text-align: left;" readonly  /></td>
                <td><input type="text" id="i_subsrd_client_last_date" style="width:90px;text-align: center;" readonly  /></td>
                <td><input type="text" id="i_subsrd_client_status" style="width:90px;text-align: center;" readonly  /></td>
                <td><input type="text" id="i_subsrd_client_closed_date" style="width:90px;text-align: center;" readonly  /></td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
                <td width="100">Selling Agent</td>
                <td width="100">Source Acccount</td>
                <td>Destinantion Account</td>
            </tr>                          
            <tr>
                <td><select id="i_subsrd_sa_code" onchange="get_acc_subsrd($('#i_subsrd_client_code_h').val(),this.value,'0');"></select></td>
                <td><select id="i_subsrd_acc_src"></select></td>
                <td><select id="i_subsrd_acc_dest"></select></td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
                <td width="1%">Tanggal</td>
                <td width="1%">Keterangan</td>
                <td width="1%">Nominal</td>
                <td width="1%"></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" id="i_subsrd_client_dt" style="width:65px;text-align: center;" class="dtpick"  /></td>
                <td><input type="text" id="i_subsrd_desc" style="width:160px;" /></td>
                <td><input type="text" id="i_subsrd_nominal" style="width:90px;text-align: right;"  /></td>
                <td><input type="text" id="i_subsrd_nominal_a" style="width:110px;text-align: right;" readonly /></td>
                <td>
                <div>
                    <input type="button" value="Tambah" id="b_subsrd_add" />
                    <input type="button" value="Ubah" id="b_subsrd_edit" style="display: none;" />
                    <input type="button" value="Hapus" id="b_subsrd_del" style="display: none;" />
                    <input type="button" value="Batal" id="b_subsrd_cancel" style="display: none;" />
                </div>
                </td>
            </tr>
        </table>       
    </div> 
    <div id="tbl_slick_subsrd" style="height: 150px;"></div>
    <div style="display:block; margin:0; padding: 0;" align="center" id="subsrd_rekap">
        
    </div>
</div>

<?php } ?>
<?php } ?>