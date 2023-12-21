<link rel="stylesheet" href="<?=NIKICAR_PLUGIN_URL?>/templates/css/admin.css">
<div class="wrap">
    <h1>Налаштування</h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'nikicar_plugin_settings' ); ?>
        <?php do_settings_sections( 'nikicar_plugin_settings' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">TOKEN ТЕЛЕГРАМ БОТА</th>
                <td><input class="w100" type="text" name="telegram_bot" value="<?php echo esc_attr( get_option('telegram_bot'));?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">TELEGRAM CHANNEL ID</th>
                <td><input class="w100" type="text" name="telegram_channel_id" value="<?php echo esc_attr( get_option('telegram_channel_id'));?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">ENCRYPT KEY</th>
                <td><input class="w100" type="text" name="encrypt_key" value="<?php echo esc_attr( get_option('encrypt_key'));?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">SMS СЕРВІС TOKEN</th>
                <td><input class="w100" type="text" name="sms_service_token" value="<?php echo esc_attr( get_option('sms_service_token'));?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">SMS СЕРВІС (нікнейм відправника, має бути зарєєстрований сервісом)</th>
                <td><input class="w100" type="text" name="sms_service_sender" value="<?php echo esc_attr(get_option('sms_service_sender'));?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">SMS СЕРВІС (мінімальна сумма баланса при якій надходить попередження в грн)</th>
                <td><input class="w100" type="text" name="sms_service_min_notify_balance" value="<?php echo esc_attr( get_option('sms_service_min_notify_balance'));?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">SMS ТЕКСТ ПОВІДОМЛЕННЯ</th>
                <td><textarea class="w100" rows="7" name="sms_text"><?php echo esc_attr( get_option('sms_text'));?></textarea></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Чи надсилати SMS повідомлення, після підтвердження замовлення?</th>
                <td><input type="checkbox" <?=esc_attr(get_option('sms_enabled'))?'checked':''?> name="sms_enabled"/></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
