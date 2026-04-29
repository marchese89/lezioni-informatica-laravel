<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Ordine completato</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">

    <h2>Gentile {{ $user->name }} {{ $user->surname }},</h2>

    <p>
        Il tuo ordine è stato completato con successo.
    </p>

    <p>
        In allegato trovi la tua fattura in formato PDF.
    </p>

    <br>

    <p>
        Dettagli ordine:
    </p>

    <ul>
        <li><b>Data:</b> {{ $data }}</li>
        <li><b>Totale:</b> {{ $total }} €</li>
    </ul>

    <br>

    <p>
        Grazie per aver scelto il nostro servizio.
        <br>
        <br>
        <br>
        <br>
        <br>
        <b>Lezioni Informatica</b>
    </p>

</body>

</html>
