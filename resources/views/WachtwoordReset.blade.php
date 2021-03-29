<html>
<body>
<p>Hallo {{ $name }},</p>

<p>Er is een nieuw wachtwoord voor je aangevraagd via 'wachtwoord vergeten'.<br>
Klik op onderstaande link om een nieuw wachtwoord in te stellen:</p>

<p><a href="<?= env('FRONT_END_URL') ?>/set-password/{{ $id }}"><?= env('FRONT_END_URL') ?>/set-password/{{ $id }}</a></p>

<p>Heb je dit zelf niet aangevraagd? Dan mag je deze e-mail negeren.</p>

<p>Met vriendelijke groet,<br>
<b>RoosterApp</b></p>

</body>
</html>
