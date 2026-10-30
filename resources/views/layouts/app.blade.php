<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ShelfLife')</title>

    <style>
        /* ---------- Pastel colour palette (change a colour here and it changes everywhere) ---------- */
        :root {
            --bg: #fdf7fb;            /* soft pink-cream page background */
            --ink: #3f3556;           /* dark purple text */
            --muted: #8b82a3;         /* grey-purple small text */
            --lavender: #8e7cc3;      /* main button colour */
            --lavender-dark: #7463ad;
            --lavender-soft: #efe9f8; /* pill background */
            --line: #f0e8f4;          /* thin lines */
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }
        a { color: var(--lavender-dark); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 20px; }

        /* ---------- Pastel gradient banner ---------- */
        .banner {
            background: linear-gradient(135deg, #cdb8f0, #f8c8dc 55%, #ffe0c2);
            color: var(--ink);
            padding: 34px 0 0;
            margin-bottom: 28px;
            border-radius: 0 0 28px 28px;
        }
        .banner h1 { margin: 0 0 6px; font-size: 2.3rem; }
        .banner p  { margin: 0 0 18px; opacity: 0.85; }

        /* ---------- Top menu ---------- */
        .nav { display: flex; gap: 10px; padding-bottom: 18px; }
        .nav a {
            background: rgba(255, 255, 255, 0.55);
            color: var(--ink);
            padding: 7px 18px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.92rem;
        }
        .nav a:hover { background: rgba(255, 255, 255, 0.85); text-decoration: none; }
        .nav a.on { background: #fff; box-shadow: 0 2px 6px rgba(120, 90, 160, 0.18); }

        /* ---------- Stat cards (each one has its own pastel colour) ---------- */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(120, 90, 160, 0.10);
        }
        .stat-card .label { font-size: 0.85rem; color: var(--ink); opacity: 0.75; }
        .stat-card .number { font-size: 2.1rem; font-weight: 700; margin-top: 4px; }
        .stat-total    { background: #e8defa; }   /* lavender */
        .stat-to_read  { background: #ffe9d6; }   /* peach    */
        .stat-reading  { background: #d9ecfb; }   /* sky blue */
        .stat-finished { background: #d8f3e3; }   /* mint     */

        /* ---------- White card ---------- */
        .card {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(120, 90, 160, 0.10);
            margin-bottom: 24px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }
        .card-header h2 { margin: 0; font-size: 1.3rem; }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-block;
            border: none;
            border-radius: 12px;
            padding: 9px 18px;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .btn-primary { background: var(--lavender); color: #fff; }
        .btn-primary:hover { background: var(--lavender-dark); text-decoration: none; }
        .btn-danger { background: #ffdede; color: #b03a3a; padding: 5px 12px; font-size: 0.85rem; }
        .btn-danger:hover { background: #ffc7c7; }

        /* ---------- Search box + filter pills ---------- */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }
        .filters { display: flex; flex-wrap: wrap; gap: 8px; }
        .pill {
            background: var(--lavender-soft);
            color: var(--ink);
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 0.9rem;
        }
        .pill:hover { background: #e3d9f3; text-decoration: none; }
        .pill.active { background: var(--lavender); color: #fff; }
        .search { display: flex; gap: 8px; }
        .search input[type="text"] { width: 200px; padding: 7px 14px; border-radius: 999px; }

        /* ---------- Table ---------- */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
            padding: 10px 12px;
            border-bottom: 2px solid var(--line);
        }
        td { padding: 14px 12px; border-bottom: 1px solid var(--line); }
        tbody tr:hover { background: #fcf8ff; }
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
        .badge-to_read  { background: #ffe9d6; color: #a0552a; }
        .badge-reading  { background: #d9ecfb; color: #2b5f8a; }
        .badge-finished { background: #d8f3e3; color: #1e7048; }

        .stars { color: #f2b84b; letter-spacing: 2px; white-space: nowrap; }
        .stars .off { color: #e6dff0; }
        .empty { text-align: center; color: var(--muted); padding: 30px 0; }

        /* ---------- Forms ---------- */
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        .hint { color: var(--muted); font-size: 0.82rem; margin-top: 5px; }
        input[type="text"], select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e3dbee;
            border-radius: 12px;
            font-size: 1rem;
            background: #fff;
            color: var(--ink);
        }
        input[type="text"]:focus, select:focus {
            outline: 2px solid #c3b1e8;
            border-color: var(--lavender);
        }
        .error { color: #c0392b; font-size: 0.85rem; margin-top: 5px; }
        .form-actions { display: flex; align-items: center; gap: 16px; }

        /* ---------- Success message ---------- */
        .flash {
            background: #d8f3e3;
            color: #1e7048;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        /* ---------- History timeline ---------- */
        .month-title { margin: 22px 0 10px; font-size: 1.05rem; color: var(--lavender-dark); }
        .month-title:first-child { margin-top: 0; }
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin-bottom: 8px;
            background: #fcf8ff;
            border-left: 5px solid #cdb8f0;
            border-radius: 10px;
        }
        .history-item .meta { color: var(--muted); font-size: 0.85rem; }

        footer { text-align: center; color: var(--muted); padding: 20px 0 40px; font-size: 0.9rem; }

        /* ---------- Phones ---------- */
        @media (max-width: 700px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 420px) {
            .stats { grid-template-columns: 1fr; }
            .search input[type="text"] { width: 140px; }
        }
    </style>
</head>
<body>

    <header class="banner">
        <div class="container">
            <h1>@yield('heading', 'ShelfLife')</h1>
            <p>@yield('subheading', 'Keep track of the books you want to read, are reading, or have finished')</p>

            {{-- Top menu: the page you are on gets the white "on" style --}}
            <nav class="nav">
                <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.index', 'books.create', 'books.edit') ? 'on' : '' }}">My books</a>
                <a href="{{ route('books.history') }}" class="{{ request()->routeIs('books.history') ? 'on' : '' }}">History</a>
            </nav>
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