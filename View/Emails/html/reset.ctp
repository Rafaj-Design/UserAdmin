<?= $this->element('Email/top'); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td colspan="3" height="56"></td>
    </tr>
    
    <!-- EMAIL TITLE -->
    <tr>
        <td colspan="3" style="text-align: center; font-size: 48px; font-weight: bold; color: #e74c3c; letter-spacing: -1px;">Password Reset</td>
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
        	A reset password has been requested for your account on <?= $servername; ?>. To finish the process please click Activate My Account link below and follow the instructions. If you haven't requested the password reset, please discard this email.
        	<br />
        	<br />
        	Your username is: <strong><?= $username; ?></strong>
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
                    <td valign="middle" width="50%" height="50" style="background-color: #e74c3c; text-align: center;"><a href="<?= $newpasswd_url; ?>?password_token=<?= $password_token; ?>" style="font-weight: bold; font-size: 22px; color: white; text-decoration: none;">Reset My Password</a></td>
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
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac mollis purus. Vestibulum mattis diam ac iaculis tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla sed fermentum erat. Phasellus pulvinar neque non lacus facilisis feugiat. 
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