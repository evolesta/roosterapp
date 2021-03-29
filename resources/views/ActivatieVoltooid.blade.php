<html>
<body>
<p>Hallo {{ $naam }},</p>

<p>Je account voor de RoosterApp is geactiveerd. Je kan hiermee nu inloggen!<br>
Het opgegeven wachtwoord is ingesteld.</p>
<p>Gebruik onderstaande link om in te loggen:</p>
<p><a href="<?= env('FRONT_END_URL') ?>"><?= env('FRONT_END_URL') ?></a></p>
<p>Succes met registreren!</p>
<p>Met vriendelijke groet,<br>
Het RoosterApp Team</p>
</body>
</html>
