# Admin Panel Setup

Follow these steps to enable the admin panel and create an admin user.

1. Run the migration SQL:
   - Open phpMyAdmin (http://localhost/phpmyadmin) or use the MySQL CLI and execute the file `db_admin_migration.sql` in the project root.
   - This will:
     - Add an `is_admin` column to `users`.
     - Create `notices`, `news`, and `gallery` tables.
     - Insert a sample admin account: username `admin` with password `admin123` (MD5).

2. Change the admin password immediately:
   - Login at `login.php` using the admin account.
   - Go to `users.php` or update via SQL:

     UPDATE users SET password = MD5('your_new_password_here') WHERE username = 'admin';

3. File upload directories:
   - News images are saved to `Picture/news/` and gallery images to `Picture/gallery/`.
   - The admin scripts create these directories if they don't exist, but ensure PHP has write permission to `Picture/`.

4. Admin pages:
   - Visit `admin/index.php` after logging in as an admin.
   - Manage Notice (`admin/notices.php`), News (`admin/news.php`), and Gallery (`admin/gallery.php`).

5. Public pages:
   - The front-end pages `activities.php` (news now appears here), `notice.php`, and `gallery.php` now render content from the database.

6. Security notes / Next steps:
   - Consider switching from MD5 to a stronger password hashing algorithm (password_hash / password_verify).
   - Add CSRF protection and validation for uploads if you expect untrusted users.
   - Back up the database before running migrations.

If you want, I can also add a user management UI to create/remove admins and implement password change forms.
