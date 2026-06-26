@props(["title" => "Dashboard"])

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="NoteAI Dashboard — Gestiona tus notas con inteligencia artificial">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ $title }} — NoteAI</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="flex min-h-screen bg-slate-50 font-sans antialiased text-slate-700">
    <x-sidebar.sidebar />

    <div class="flex-1 flex flex-col min-h-screen">
        <x-header.header :$title />

        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>