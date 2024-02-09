<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

        <title>Monitoring</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>

        @livewireStyles
        @powerGridStyles
    </head>
    <body class="antialiased px-10 py-8 bg-gray-50">


        <div class="bg-white p-4 border border-gray-200 rounded">
            {{-- ⚡<livewire:live_wire_fm_class_schedule/>

            <livewire:monitoring_schedule_livewire/> --}}
        </div>

        <!-- Scripts -->
        @livewireScripts
        @powerGridScripts
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            window.addEventListener('showAlert', event => {
                alert(event.detail.message);
            })
        </script>
    </body>
</html>
