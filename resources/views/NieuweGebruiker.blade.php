<html>
<body>
    <p>Hallo {{ $naam }},</p>

    <p>Er is een nieuw account voor je aangemaakt in de RoosterApp!<br>
    Om de registratie te voltooien, moet je het account activeren.</p>

    <p>Je gebruikersnaam is: <b>{{ $gebruikersnaam }}</b></p>

    <p>Om de registratie af te ronden, klik je op onderstaande link:</p>
    <p><a href="<?= env('FRONT_END_URL')?>/activateUser/{{ $id }}"></a><?= env('FRONT_END_URL')?>/activateUser/{{ $id }}</p>

    <p>Veel succes met het registreren van je uren!</p>
    <p><B>RoosterApp V2 - bericht is automatisch gegenereerd</B></p>
</body>
</html>
