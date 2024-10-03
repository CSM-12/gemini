<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Capture and Send Image</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <h1>Capture and Send Image</h1>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="captureButton">Capture Image</button>

    <script>
        $(document).ready(function() {
            // Set CSRF token in the header for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Get access to the camera
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    var video = document.getElementById('video');
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(error) {
                    console.error('Error accessing camera:', error);
                });

            // Capture the image and send to backend
            $('#captureButton').click(function() {
                var video = document.getElementById('video');
                var canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var imageData = canvas.toDataURL('image/jpeg'); // Change format as needed

                // Send captured image to backend (Laravel)
                $.ajax({
                    url: "/process-image",
                    type: "POST",
                    data: {
                        image: imageData
                    },
                    success: function(response) {
                        console.log('Response from server:', response);
                        // Handle response if needed
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>
