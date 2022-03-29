//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb.
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

var recordButton = document.getElementById("recordButton");
//var stopButton = document.getElementById("stopButton");
var messageSuccess = document.getElementById("message-success");
var messageWarning = document.getElementById("message-warning");

//add events to those 2 buttons
recordButton.addEventListener("click", startRecordingClick);
//stopButton.addEventListener("click", stopRecording);

var recordingStopInterval = null;

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function startRecordingClick(){
    sleep(10).then(() => { startRecording(); });
}

function startRecording() {
	console.log("recordButton clicked");

	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/

    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia()
	*/

	recordButton.disabled = true;
	//stopButton.disabled = false;

	/*
    	We're using the standard promise based getUserMedia()
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/
	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext({
			sampleRate: 44100,
		});

		//update the format
		//document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		/*  assign to gumStream for later use  */
		gumStream = stream;

		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/*
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})

		//start the recording process
		rec.record()

		console.log("Recording started");

		recordingStopInterval = setInterval(function(){
			stopRecording();
			clearInterval(recordingStopInterval);
		}, 2100);

	}).catch(function(err) {
	  	//enable the record button if getUserMedia() fails
    	recordButton.disabled = false;
    	//stopButton.disabled = true;
	});
}

function stopRecording() {
	//console.log("stopButton clicked");
	clearInterval(recordingStopInterval);

	//disable the stop button, enable the record too allow for new recordings
	//stopButton.disabled = true;
	recordButton.disabled = false;

	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to predictRecording
	rec.exportWAV(predictRecording);
}

function predictRecording(blob) {
	var filename = new Date().toISOString();
    var xhr=new XMLHttpRequest();

    xhr.onload=function(e) {
        if(this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            console.log(this.response);
            console.log(this);

            var json = JSON.parse(this.responseText);

            if(json['status'] === 'OK')
                $('#phone').text(json['result']);
            //var json = JSON.parse(this.responseText);
            //$('#result').html(json['result']);
        }

        if(this.readyState === 3){
            $('#phone').text("Error...");
        }
    };

    xhr.onerror=function (){
        $('#result').html("Error...");
    }

    var fd=new FormData();
    fd.append("mediafile", blob, filename);
    xhr.open("POST","/predict",true);
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhr.send(fd);
}
