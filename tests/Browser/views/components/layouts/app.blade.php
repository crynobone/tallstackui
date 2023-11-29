<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    @tallStackUiScript
    @tallStackUiStyle
</head>
<body>
    <x-dialog />
    <x-toast />
    {!! $slot !!}
</body>
</html>
