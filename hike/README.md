
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

## Step First Model and create migration

```php 
php artisan make:model -m Hike

   INFO  Model [\hike\app\Models\Hike.php] created successfully.

   INFO  Migration [hike\database\migrations/2024_05_26_063941_create_hikes_table.php] created successfully.

```
-m: The -m flag indicates that you want to also create a migration file along with the model. 

- Migrations are like version control for your database, allowing you to modify your database schema over time in a structured and organized way. 

- Each migration file contains instructions on how to alter the database schema, such as creating tables, adding columns, etc.


Folder Models \hike\app\Models\Hike.php


```php 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hike extends Model
{
    use HasFactory;
}

```
Folder Models Migration

```php 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hikes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hikes');
    }
};


```
