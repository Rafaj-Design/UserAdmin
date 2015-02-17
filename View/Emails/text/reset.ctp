Hi <?= $firstname; ?>,


Your AppStore username is: "<?= $username; ?>"

Please click this link to reset your password (or copy the URL to the address bar): <?= $newpasswd_url; ?>?password_token=<?= $password_token; ?>


<?= $servername; ?> admin


From: <?= $this->Html->url('/', true); ?>

