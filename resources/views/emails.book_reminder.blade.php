<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Promemoria di consegna libro</title>
</head>
<body>
    <h1>Promemoria di consegna libro</h1>

    <p>Gentile {{ $utente->nome }},</p>

    <p>Le ricordiamo che il libro "{{ $prestito->libro->titolo }}" deve essere consegnato entro il {{ $prestito->data_scadenza }}</p>

    <p>Per favore, provveda a consegnare il libro alla biblioteca il prima possibile.</p>

    <p>Grazie per la collaborazione.</p>

    <p>Cordiali saluti,</p>

    <p>La biblioteca scolastica</p>
</body>
</html>
