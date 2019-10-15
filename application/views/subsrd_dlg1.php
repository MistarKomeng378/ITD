<?php if(5) { ?>
    <form action="<?php echo $url;?>index.php/subsrd/print_instruksi_cs" target="printPage"  method="post" id="frm_subsrd_instruksi_cs">
    <table width="100%">
        <tr>
            <td width="25%">Client</td>
            <td width="1%">:</td>
            <td>
                <span id="dlgSubsrd_client_code_s"></span> -
                <span id="dlgSubsrd_client_name_s"></span>
            </td>
        </tr>
        <tr>
            <td>Bank</td>
            <td>:</td>
            <td>
                <select id="dlgSubsrd_bank">
                </select>
            </td>
        </tr>
        <tr>
            <td>Balance Date</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrd_bal_dt" style="width:80px;text-align: center;" class="dtpick"  /></td>
        </tr>
        <tr>
            <td>Instruction Date</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrd_print_dt" style="width:80px;text-align: center;" class="dtpick"  /></td>
        </tr>
    </table>
    <input type="hidden" id="dlgSubsrd_client_code_h" /> 
    </form>
<?php } ?>