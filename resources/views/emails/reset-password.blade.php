<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body>

    <h2>Reimpostazione Password</h2>

    <p>Ciao!</p>

    <p>Hai ricevuto questa email perché è stato richiesto un reset della password.</p>

    <p>
        <a href="{{ $url }}"
            style="padding:10px 20px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:5px;hover:bg-blue-700;">
            Reimposta Password
        </a>
    </p>

    <p>Il link scadrà tra 60 minuti.</p>

    <p>Se non hai richiesto il reset, ignora questa email.</p>




    <br>

    <p>Cordiali saluti,<br>Lezioni Informatica</p>

    <hr>

    <p>
        Se hai problemi a cliccare il pulsante <strong>"Reimposta Password"</strong>, copia e incolla il link qui sotto
        nel tuo browser:
    </p>

    <p>
        <a href="{{ $url }}">{{ $url }}</a>
    </p>



</body>

</html>
