
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
Folder Models Migration create_hikes_table

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
## Step DB in Model Hike

- change Model Hike in 

```php 
    public function up(): void
    {
        Schema::create('hikes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('distance', 8, 2);
            $table->integer('duration'); // Assuming duration is in minutes
            $table->integer('elevation_gain');
            $table->text('description')->nullable(); // Optional description field
            $table->timestamps();
        });
    }

```
 and 

```php 
php artisan migrate
```

Error Migration 
```php 
php artisan migrate:rollback --step=1
```


## First Controller

 ```php 
php artisan make:controller Admin\HikeController


   INFO  Controller [\hike\app\Http\Controllers\Admin\HikeController.php] created successfully.

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HikeController extends Controller
{
    //
}

```
- remove folder Admin and file HikeController.php

 ```php 
php artisan make:controller Admin\HikeController -r
```

-r option in the php artisan make:controller command stands for "resource."

--resource: The --resource option tells Laravel to generate a controller with methods for handling every standard RESTful action (Create, Read, Update, Delete). 

- This includes methods like index(), show(), store(), update(), and destroy(). 

- These methods correspond to different routes that can be defined in your web routes file (web.php) to handle CRUD operations for the "Hike" resource.

## Folder routes and file web.php

- head file add 

```php 
use App\Http\Controllers\Admin\HikeController;
```

```php 
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('hike', HikeController::class)->except(['show']);
});
```

```php 
php artisan route:list
```
- In your terminal will display a table with the following columns:

> Domain: 
- The domain for the route.
> Method: 
- The HTTP method(s) the route responds to (e.g., GET, POST).
> URI: 
- The URI pattern the route matches.
> Name: 
- The name of the route, if one has been assigned.
> Action: 
- The controller action that handles the request.
> Middleware: 
- Any middleware applied to the route.

```php 
  GET|HEAD        admin/hike ........................................... admin.hike.index › Admin\HikeController@index
  POST            admin/hike ........................................... admin.hike.store › Admin\HikeController@store
  GET|HEAD        admin/hike/create .................................. admin.hike.create › Admin\HikeController@create
  PUT|PATCH       admin/hike/{hike} .................................. admin.hike.update › Admin\HikeController@update
  DELETE          admin/hike/{hike} ................................ admin.hike.destroy › Admin\HikeController@destroy
  GET|HEAD        admin/hike/{hike}/edit ................................. admin.hike.edit › Admin\HikeController@edit
```

