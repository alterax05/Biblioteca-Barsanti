<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Promemoria di consegna libro</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Promemoria di consegna libro</h1>

    <p>Gentile {{ $utente->nome }},</p>

    <p>Le ricordiamo che il libro <strong>"{{ $prestito->libro->titolo }}"</strong> deve essere consegnato entro il <strong>{{ $prestito->data_scadenza }}</strong></p>

    <p>Mancano solo <strong>{{ $giorniMancanti }} giorni</strong> alla scadenza del prestito.</p>

    <p>Per favore, provveda a consegnare il libro alla biblioteca il prima possibile.</p>

    <p>Grazie per la collaborazione.</p>

    <p>Cordiali saluti,</p>

    <p>La biblioteca scolastica</p>
</body>
</html>
