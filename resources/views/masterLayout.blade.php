<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

    <title>@yield('page-title')</title>

    {{-- Master layout CSS Style --}}
    <style>
        body {
            background-color: #E0FBE2;
        }

        nav {
            height: 60px;
            background-color: #06D001;
            position: fixed;
            top: 0px;
            z-index: 1000;
        }

        #navbar_placeholder {
            height: 60px;
        }

        #brand {
            color: white;
        }

        /* Container */
        .max-700 {
            width: 100%;
            max-width: 700px;
        }

        #sidebar_menu {
            width: 25%;
            max-width: 300px;
        }

        .overflow-container {
            overflow-x: scroll;
        }

        #menu_bar_placeholder {
            width: 25%;
            max-width: 300px;
        }
    </style>

    @yield('page-style')

</head>

<body>

    {{-- Navbar --}}
    <nav class="w-100 d-flex px-2 justify-content-between align-items-center">
        <h1 id="brand">Driver Assist</h1>
    </nav>
    {{-- Navbar Placeholder --}}
    <div id="navbar_placeholder" class="w-100"></div>


    <div class="w-100 d-flex justify-content-center align-items-center flex-column flex-nowrap">

        {{-- Content --}}
        @yield('page-content')

    </div>

</body>

{{-- JQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{-- Bootstrap Script CDN --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

{{-- Google Charts Script CDN --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

{{-- DataTables CDN Script --}}
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>


{{-- Javascript --}}

<script>

// $(document).ready(function() {

    


    // Get Month Name By Month Number
    function getMonthName(monthNumber) {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        if (monthNumber < 1 || monthNumber > 12) {
            throw new Error("Month number must be between 1 and 12");
        }

        return monthNames[monthNumber - 1];
    }

    // Text-To-Speach
    function speak(context) {
        // Create a new SpeechSynthesisUtterance object
        var msg = new SpeechSynthesisUtterance();

        // Set the text to be spoken
        msg.text = context;

        // Set additional properties (optional)
        msg.volume = 1; // Volume (0 to 1)
        msg.rate = 1; // Rate (0.1 to 10)
        msg.pitch = 1.2; // Pitch (0 to 2)
        msg.lang = 'en-IN'; // Language

        // Speak the text
        window.speechSynthesis.speak(msg);
    }

    // Add Chat
    function addChat(text, role) {
        var role_class = '';
        if(role == 'user'){
            role_class = 'bg-success-subtle';
        }
        else{
            role_class = 'bg-info-subtle';
        }
        chat = '<div class="w-100 rounded border my-2 p-1 ' + role_class + '">' + text + '</div>';
        $('#chat_box').append(chat);
    }

    // Data Tables
    let table = new DataTable('.dataTable', {
        order: [] // Disable initial sorting
    });


    
</Script>

{{-- Page Scripts --}}
@stack('page-script')


</html>
