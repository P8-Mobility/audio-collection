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
    <h1>Test the model</h1>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <select class="form-select" id="model" name="model">
                    <option value="" selected>Default</option>
                    @foreach($models AS $model)
                    <option value="{{ $model }}">{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="word" class="form-label">Word</label>
                <select class="form-select" id="word" name="word">
                    @foreach($words AS $word => $phonemes)
                    <option @if($word == "pære") selected @endif phonemes="{{ $phonemes }}" value="{{ $word }}">{{ $word }} ({{ $phonemes }})</option>
                    @endforeach
                </select>
            </div>
            <div id="controls">
                <button id="recordButton">Record</button>
            </div>
            <p><small>Recording stops automatically after 2 seconds.</small></p>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div id="result">
                <h3>Model used:</h3>
                <span id="used-model"></span>
                <br>
                <h3 style="margin-top: 25px;">Predicted phonemes:</h3>
                <span id="phone"></span>
                <br>
                <h3 style="margin-top: 25px;">Response text (danish):</h3>
                <span id="response-dan"></span>
                <br>
                <h3 style="margin-top: 25px;">Response text (arabic):</h3>
                <span id="response-ara"></span>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/recorder.js"></script>
<script src="/js/predict.js"></script>
</body>
</html>
