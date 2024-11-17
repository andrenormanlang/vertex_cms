# 📚 Vertex CMS

Welcome to Vertex CMS — a Laravel-based content management system designed for simplicity, scalability, and ease of use! 🌟
🚀 Features

    📝 Dynamic Content Management - Manage posts and pages easily.
    🔒 Authentication - Secure access with built-in user registration and authentication.
    🎨 Blade Templating - Clean front-end built with Laravel Blade.
    🛠️ Admin Panel - Admin interface for managing content and users.
    📊 Database Integration - Uses PostgreSQL for reliable data management.
    🔍 SEO Friendly - Clean URLs and meta tag support to boost search engine rankings.

📂 Project Structure

    Controllers (app/Http/Controllers/)
    Handles requests and responses, including PostController, AdminController, etc.

    Views (resources/views/)
    Blade templates for rendering front-end pages. Find files like index.blade.php, DashBoard.blade.php, and more.

    Routes (routes/web.php)
    Defines the application's endpoints and links them with appropriate controllers.

📦 Installation Guide
Prerequisites

    PHP ^8.0 📦
    Composer ^2.x 🧰
    PostgreSQL 📋
    Node.js (for Vite and asset bundling) 🚀

🔧 Setup Instructions

    Clone the Repository:

git clone https://github.com/andrenormanlang/vertex-cms.git

Navigate to the Project Directory:

cd vertex-cms

Install Dependencies:

composer install
npm install && npm run dev

Environment Setup:

    Copy .env.example to .env:

cp .env.example .env

Update the .env file with your database credentials:

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=vertex
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

Generate Application Key:

php artisan key:generate

Run Database Migrations:

php artisan migrate

Seed the Database (Optional):

php artisan db:seed --class=PostSeeder

Serve the Application:

    php artisan serve

    Your application should now be accessible at http://localhost:8000. 🌐

🛠️ Usage
🌟 Viewing Posts

    Visit the home page (/) to see all posts.
    Click on a post to read more (/posts/{slug}).

✍️ Admin Panel

    Accessible at /admin for logged-in users.
    Create, update, or delete posts and manage users.

🛡️ Authentication

    Users can register and log in to access the DashBoard (/DashBoard) and other protected areas.

🚨 Troubleshooting
🛑 Common Issues

    Blank Page on http://vertex.test:
        Check if the PostController exists and the index method is correctly returning the view.
        Verify database connection in .env and ensure data exists.

    Route Not Defined Error:
        Ensure the route name matches in web.php and Blade templates.
        Use php artisan route:list to verify all routes are correctly registered.

    Database Connection Issue:
        Make sure PostgreSQL is running and the credentials in .env are correct.

🔄 Useful Commands

    Clear cache: php artisan cache:clear 🧹
    List all routes: php artisan route:list 🗺️
    Seed the database: php artisan db:seed 🌱

🤝 Contributing

Contributions are welcome! Feel free to:

    Fork the repo 🍴
    Create a feature branch (git checkout -b feature/new-feature) 🌿
    Commit your changes (git commit -am 'Add new feature') 💬
    Push to the branch (git push origin feature/new-feature) 🚀
    Open a Pull Request ✨

📄 License

This project is licensed under the MIT License. 📜
❤️ Acknowledgements

    Laravel Framework ⚡
    Tailwind CSS for styling 💅
    PostgreSQL for data management 🗄️

📧 Contact

For any questions or support, please reach out at <andrenormanlang@gmail.com>. ✉️

Happy coding! 🎉🚀
