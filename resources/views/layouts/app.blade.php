<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reading List</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 0 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        .btn { padding: 6px 12px; background: #2563eb; color: #fff; border: 0; border-radius: 4px; text-decoration: none; cursor: pointer; }
        .btn-danger { background: #dc2626; }
        .error { color: #dc2626; font-size: 14px; }
        .success { background: #dcfce7; padding: 8px; border-radius: 4px; }
        .filters a { margin-right: 8px; }
        .filters a.active { font-weight: bold; }
        label { display: block; margin-top: 12px; }
        input[type=text], select { width: 100%; padding: 6px; }
    </style>
</head>
<body>
    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @yield('content')
</body>
</html>