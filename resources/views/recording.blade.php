<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data indsamling</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Data indsamling</h1>
        <p>Hej, vi er en 8. semesters software gruppe, som undersøger mulighed for at hjælpe udlændinge med at udtale dansk korrekt.<br>
            Derfor har vi brug for hjælp til at indsamle data fra jer der kan snakke dansk flydende.<br>
            Optagelserne er selvfølgelig anonyme :)</p>

        <div class="row">
            <div class="col">
                <h3>Instruktioner</h3>
                <ul>
                    <li>1. Tryk på optag</li>
                    <li>2. Sig ordet pære</li>
                    <li>3. Stop optagelse</li>
                    <li>4. Tryk på upload under lydfilen</li>
                </ul>

                <div id="controls">
                    <button id="recordButton">Optag</button>
                    <button id="stopButton" disabled>Stop</button>
                </div>
                <p><small>Optagelsen stoppes automatisk efter 2 sekunder.</small></p>
            </div>
            <div class="col">
                <div id="message-success" class="alert alert-success" role="alert" style="display: none;">
                    Optagelsen er nu gemt!
                </div>
                <div id="message-warning" class="alert alert-warning" role="alert" style="display: none;">
                    Optagelsen er nu slettet...
                </div>
                <ol id="recordingsList"></ol>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/js/recorder.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
