<?= $this->element('Email/top'); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td colspan="3" height="56"></td>
    </tr>
    
    <!-- EMAIL TITLE -->
    <tr>
        <td colspan="3" style="text-align: center; font-size: 48px; font-weight: bold; color: #e74c3c; letter-spacing: -1px;">Invitation</td>
    </tr>
    <tr>
        <td colspan="3" height="56"></td>
    </tr>
    
    <!-- TOP CONTENT -->
    <tr>
        <td valign="top" width="11%"></td>
        <td valign="top" width="78%" style="line-height: 24px; font-size: 16px;">
        	Hi <?= $firstname; ?> <?= $lastname; ?>,
        	<br />
        	<br />
        	You have been invited participate to a LiveUI account. To finish the registration please click Activate My Account link below and follow the instructions.
        </td>
        <td valign="top" width="11%"></td>
    </tr>
    <tr>
        <td colspan="3" height="56"></td>
    </tr>
    
    <!-- ACTION ROW-->
    <tr>
        <td colspan="3" style="background-color: #424648;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td valign="top" colspan="3" height="32"></td>
                </tr>
                <tr>
                    <td valign="top" width="25%" class="content-padding"></td>
                    <td valign="middle" width="50%" height="50" style="background-color: #e74c3c; text-align: center;"><a href="<?= $reg_url; ?>?registration_token=<?= $registration_token; ?>" style="font-weight: bold; font-size: 22px; color: white; text-decoration: none;">Activate My Account</a></td>
                    <td valign="top" width="25%" class="content-padding"></td>
                </tr>
                <tr>
                    <td valign="top" colspan="3" height="32"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="56"></td>
    </tr>
    
    <!-- BOTTOM CONTENT -->
    <tr>
        <td valign="top" width="11%"></td>
        <td valign="top" width="78%" style="line-height: 24px; font-size: 16px;">
            Once registered, you will be able to access the LiveUI admin panel.
            <br />
            <br />
            Thank you,
            <br />
            <br />
            <?= $servername; ?> Team
        </td>
        <td valign="top" width="11%"></td>
    </tr>
    <tr>
        <td colspan="3" height="56"></td>
    </tr>
</table>
<?= $this->element('Email/bottom'); ?>