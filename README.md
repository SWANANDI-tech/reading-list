# ShelfLife

ShelfLife is a small Laravel web app for keeping track of books. You can add books, mark each one as To read, Reading or Finished, rate the ones you finish, and look back at everything you have read on a History page.

## Features

- Add, edit and delete books (delete asks for confirmation)
- Status for each book: To read, Reading or Finished
- Filter books by status and search by title or author
- Star rating (1 to 5) for finished books
- "Start reading" and "Mark finished" buttons for quick updates
- History page that groups finished books by month, with a yearly reading goal bar
- Pastel design that works on phones and computers
- No login needed

## Requirements

- PHP 8.2 or newer
- Composer
- Git

## Setup steps

1. Download the project:

   ```
   git clone https://github.com/YOUR-USERNAME/YOUR-REPO-NAME.git
   cd YOUR-REPO-NAME
   ```

2. Install the PHP packages:

   ```
   composer install
   ```

3. Create the settings file:

   - Windows: `copy .env.example .env`
   - Mac or Linux: `cp .env.example .env`

4. Generate the app key:

   ```
   php artisan key:generate
   ```

5. Create the database tables (if it asks to create the SQLite database file, answer yes):

   ```
   php artisan migrate
   ```

6. (Optional) Add sample books so the site is not empty:

   ```
   php artisan db:seed
   ```

7. Start the website:

   ```
   php artisan serve
   ```

8. Open http://localhost:8000/books in your browser.

## How to use

- Click **+ Add book** to add a book.
- Use the **All / To read / Reading / Finished** pills to filter, or type in the search box.
- Click **Start reading** or **Mark finished** in a row to move a book forward.
- Open **History** in the top menu to see finished books and your yearly goal.

## AI usage

I used Claude (an AI assistant by Anthropic) while building this project. It helped me to:

- Plan the structure of the app (model, controller, routes, views)
- Write and explain code for the pages, the search and filters, the star rating, the history page and the sample-data seeder
- Design the pastel styling and layout
- Learn the Git commands for making commits

I typed the code into my own project, ran it, tested each feature in the browser, and fixed errors myself. I made the final choices about the name, colours and features.

## Author

Swanandi Nimbalkar