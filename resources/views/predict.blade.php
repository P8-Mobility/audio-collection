<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dataindsamling</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Afprøv model</h1>
    <p>Hej, vi er en 8. semesters software-gruppe, som i dette semester undersøger muligheden for at hjælpe danskere der har arabisk som modersmål med dansk udtale.
        Derfor har vi brug for din hjælp til at indsamle data med korrekt udtale.</p>

    <p>Alle optagelser er selvfølgelig anonyme. &#x1F642;</p>

    <p>Vi vil sætte pris på, at du kun optager det adspurgte for at lette vores arbejdsbyrde. På forhånd tak!</p>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div id="controls">
                <button id="recordButton">Optag</button>
            </div>
            <p><small>Optagelsen stoppes automatisk efter 2 sekunder.</small></p>

            <div id="result">
                <span id="phone"></span>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/recorder.js"></script>
<script src="/js/predict.js"></script>
</body>
</html>
