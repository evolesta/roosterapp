<html>
<body>
<p>Hallo {{ $name_manager }},</p>

<p>Er is een nieuwe verlofaanvraag ingediend. Log in op de applicatie om deze te beoordelen.</p>

<p>Details:</p>

<p><b>Aanvrager:</b> {{ $name_user }}<br>
    <b>Reden:</b> {{ $reason }}<br>
    <b>Startdatum:</b> {{ $start }}<br>
    <b>Einddatum:</b> {{ $end }}<br>
    <b>Aantal uren:</b> {{ $hours }}<br>
</p>

<p>Met vriendelijke groet,<br>
    Het RoosterApp Team</p>
</body>
</html>
