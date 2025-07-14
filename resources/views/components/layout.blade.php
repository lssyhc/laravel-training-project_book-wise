<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookWise</title>
    @vite('resources/css/app.css');
</head>

<body class="bg-slate-100 text-slate-800">
    <div class="container mx-auto p-4 md:p-8">
        {{ $slot }}
    </div>
</body>

</html>
