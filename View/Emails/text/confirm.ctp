Hi <?= $firstname; ?>,


Please click this link to confirm your account (or copy the URL to the address bar): <?= $login_url; ?>users/login?registration_token=<?= $password_token; ?>


<?= $servername; ?> admin


From: <?= $this->Html->url('/', true); ?>

