
## Step Database

.env remove next and change DB_CONNECTION=sqlite

```php 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Error in lagagon : could not find driver (SQL: PRAGMA foreign_keys = ON;)

Activate : (extension=pdo_sqlite) and (extension=sqlite3)

## Step Migrate DB with sqlite

```php 
php artisan migrate
```
- WARN  The SQLite database does not exist: \hike\database\database.sqlite.

  Would you like to create it? (yes/no) [no]
  yes

```php 
INFO  Preparing database.

  Creating migration table ................................................................................. 14ms DONE

INFO  Running migrations.

  2014_10_12_000000_create_users_table ..................................................................... 12ms DONE
  2014_10_12_100000_create_password_reset_tokens_table ...................................................... 6ms DONE
  2019_08_19_000000_create_failed_jobs_table ............................................................... 14ms DONE
  2019_12_14_000001_create_personal_access_tokens_table .................................................... 23ms DONE
```

## Step Extension sqlite

- SQLite v0.14.1 alexcvzz
- SQLite Viewer v0.4.14 Florian Klampfer
- SQLite3 Editor v1.0.187 yy0931

