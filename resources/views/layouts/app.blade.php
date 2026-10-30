<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ShelfLife')</title>

    {{-- All the styling lives here, so no extra installs are needed --}}
    <style>
        /* ---------- Basics ---------- */
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f1f3f6;          /* light grey page background */
            color: #1f2937;
        }
        a { color: #2563eb; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 20px; }

        /* ---------- Blue gradient banner ---------- */
        .banner {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #fff;
            padding: 40px 0;
            margin-bottom: 28px;
        }
        .banner h1 { margin: 0 0 8px; font-size: 2.2rem; }
        .banner p  { margin: 0; opacity: 0.9; }

        /* ---------- Stat cards ---------- */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);   /* 4 in a row on wide screens */
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .stat-card .label { color: #6b7280; font-size: 0.85rem; }
        .stat-card .number { font-size: 2rem; font-weight: 700; margin-top: 4px; }

        /* ---------- White card ---------- */
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .card-header h2 { margin: 0; font-size: 1.3rem; }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-block;
            border: none;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; text-decoration: none; }
        .btn-danger { background: #dc2626; color: #fff; padding: 5px 10px; font-size: 0.85rem; }
        .btn-danger:hover { background: #b91c1c; }

        /* ---------- Filter pills ---------- */
        .filters { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
        .pill {
            background: #e5e7eb;
            color: #374151;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 0.9rem;
        }
        .pill:hover { background: #d1d5db; text-decoration: none; }
        .pill.active { background: #2563eb; color: #fff; }   /* selected pill = solid blue */

        /* ---------- Table ---------- */
        .table-wrap { overflow-x: auto; }   /* lets the table scroll on small phones */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            padding: 10px 12px;
            border-bottom: 2px solid #e5e7eb;
        }
        td { padding: 14px 12px; border-bottom: 1px solid #eef0f3; }
        tbody tr:hover { background: #f8fafc; }   /* highlight row on hover */
        .actions { display: flex; align-items: center; gap: 12px; }
        .actions form { margin: 0; }

        /* ---------- Status badges ---------- */
        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-to_read   { background: #fef3c7; color: #92400e; }  /* yellow */
        .badge-reading   { background: #dbeafe; color: #1e40af; }  /* blue   */
        .badge-finished  { background: #dcfce7; color: #166534; }  /* green  */

        .empty { text-align: center; color: #9ca3af; padding: 30px 0; }

        /* ---------- Forms ---------- */
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input[type="text"], select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            background: #fff;
        }
        input[type="text"]:focus, select:focus {
            outline: 2px solid #3b82f6;     /* blue outline when you click in */
            border-color: #3b82f6;
        }
        .error { color: #dc2626; font-size: 0.85rem; margin-top: 5px; }
        .form-actions { display: flex; align-items: center; gap: 16px; }

        /* ---------- Success message ---------- */
        .flash {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        footer { text-align: center; color: #9ca3af; padding: 20px 0 40px; font-size: 0.9rem; }

        /* ---------- Phones: stat cards stack ---------- */
        @media (max-width: 700px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 420px) {
            .stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="banner">
        <div class="container">
            <h1>@yield('heading', 'My Reading List')</h1>
            <p>@yield('subheading', 'Keep track of the books you want to read, are reading, or have finished')</p>
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer>ShelfLife | Laravel Project</footer>

</body>
</html>