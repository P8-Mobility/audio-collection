<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dataindsamling</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dataindsamling</h1>
        <p>Hej, vi er en 8. semesters software-gruppe, som  dette semester undersøger muligheden for at hjælpe danskere der har arabisk som modersmål med dansk udtale.<br>
            Derfor har vi brug for din hjælp til at indsamle data med korrekt udtale.<br>
            Optagelserne er selvfølgelig anonyme :)</p>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <h3>Instruktioner</h3>
                <ul>
                    <li>1. Tryk på "optag"</li>
                    <li>2. Sig ordet <strong>"pære"</strong> én gang</li>
                    <li>3. Tryk på "upload" under lydfilen</li>
                </ul>
                <div id="controls">
                    <button id="recordButton" class="btn btn-danger">Optag</button>
                    <!--<button id="stopButton" disabled>Stop</button>-->
                </div>
                <p><small>Optagelsen stoppes automatisk efter 2 sekunder. Du er må gerne oploade flere optagelser!</small></p>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
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
