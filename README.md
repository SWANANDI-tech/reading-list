# Reading List

A small Laravel app to keep track of books I want to read, am reading,
or have finished. You can add, edit and delete books, and filter the
list by status (To read, Reading, Finished). No login is needed.

## How to run

Requirements: PHP 8.2 or newer, Composer.

```bash
git clone https://github.com/SWANANDI-tech/reading-list.git
cd reading-list
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

On Windows PowerShell, use `copy .env.example .env` instead of `cp`.

If `php artisan migrate` asks to create the SQLite database file, answer yes.
Then open http://localhost:8000 in your browser.

## AI usage

- I used Claude to explain how Laravel resource routes, controllers,
  Blade layouts and validation work, and to guide me through each step.
- Claude gave me the code step by step, and I typed it into my files,
  tested it in the browser, and fixed errors (for example a wrongly named
  form file and a broken table row).
- I made one commit per step and I understand every line I committed.