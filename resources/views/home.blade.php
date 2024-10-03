@extends('masterLayout')

{{-- Page Title --}}
@section('page-title')
    Home
@endsection

{{-- Page Style --}}
@section('page-style')
    <style>
        #massage {
            /* width:70%; */
            /* box-sizing: border-box; */
        }

        .chat_btn {
            width: 10%;
            box-sizing: border-box;
        }
    </style>
@endsection

{{-- page Content --}}
@section('page-content')
    <div class="max-700 rounded shadow bg-light py-2 px-1 my-2 mx-1">
        <h2>Welcome To Drivers Assist!</h2>
    </div>

    {{-- Chat Section --}}
    <div class="max-700 rounded shadow bg-light py-2 px-1 my-2 mx-1" id="chat_box">



    </div>

    <div class="max-700 rounded shadow bg-light py-2 px-1 my-2 mx-1 d-flex justify-content-center">
        <input id="massage" class="d-inline-block rounded border p-1 mx-1 w-75" type="text" placeholder="Say Something...">


        <button id="click_to_send" class="btn btn-success mx-1" onclick="send()"><i class="bi bi-send-fill"></i></button>
        <button id="click_to_record" class="btn btn-primary mx-1" onclick="record()"><i class="bi bi-mic-fill"></i></button>
    </div>
@endsection


{{-- Page Script --}}
@push('page-script')
    {{-- Voice To Text --}}
    <script>
        // Set CSRF token in the header for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Send Message
        function send() {
            var message = document.getElementById('massage').value;

            if (message.trim() != '') {
                console.log(message);
                addChat(message, 'user');

                // AJAX
                $.ajax({
                    url: "{{ route('ajax.gemini') }}",
                    type: "POST",
                    data: {
                        user: message,
                    },
                    success: function(response) {
                        // Handle success
                        addChat(response, 'model');
                        speak(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }

            document.getElementById('massage').value = '';
        }

        // Voice Recognition
        function record() {
            // Check if the browser supports the Web Speech API
            if ('webkitSpeechRecognition' in window) {
                var recognition = new webkitSpeechRecognition();

                // Set properties
                recognition.continuous = true; // Keeps recognition on even after user stops speaking
                recognition.interimResults = true; // Show interim results (partial results) during speech

                // Define the language
                recognition.lang = 'en-US';

                // Start recognition
                recognition.start();

                var interimTranscript = '';
                var finalTranscript = '';

                // Event handlers
                recognition.onresult = function(event) {

                    for (var i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript;
                        } else {
                            interimTranscript += event.results[i][0].transcript;
                        }
                    }

                    console.log('Interim Results:', interimTranscript);
                    console.log('Final Results:', finalTranscript);

                };

                recognition.onerror = function(event) {
                    console.error('Speech recognition error', event.error);

                    // Speak Sorry
                    speak("Sorry, i dont get you!");

                };

                recognition.onend = function() {
                    console.log('Speech recognition ended');

                    if (finalTranscript != '') {
                        addChat(finalTranscript, 'user');

                        // AJAX
                        $.ajax({
                            url: "{{ route('ajax.gemini') }}",
                            type: "POST",
                            data: {
                                user: finalTranscript,
                            },
                            success: function(response) {
                                // Handle success
                                addChat(response, 'model');
                                speak(response);
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error(xhr.responseText);
                            }
                        });
                    }

                };

            } else {
                console.log('Web Speech API is not supported by this browser.');
            }

        }
    </script>
@endpush
