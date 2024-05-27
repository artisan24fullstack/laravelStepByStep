
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

## First Request 

```php 
php artisan make:request Admin\HikeFormRequest

   INFO  Request [\hike\app\Http\Requests\Admin\HikeFormRequest.php] created successfully.

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HikeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
```


- change HikeFormRequest in 

### Authorization Method change in true

- The authorize method is used to determine if the current user is authorized to make the request. 
- Returning false here means that by default, users are not allowed to submit forms using this request.

### Fields and Their Validation Rules

- The rules() method you've shown is part of a Laravel form request class, which is used to define validation rules for incoming HTTP requests. 
- This method returns an array where each key corresponds to a field in the request payload, 
and the value specifies one or more validation rules that the corresponding field must adhere to. 
- Let's break down the validation rules you've provided:
```php 

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'distance' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'elevation_gain' => 'required|integer|min:0',
            'description' => 'required|string',
        ];
    }
```
 
 - remove function show() in Admin HikeController (route ->except(['show']))

## Create Views and add function index in Controller

- add index in HikeController

```php 

use App\Models\Hike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

    public function index()
    {
        return View('admin.hike.index', [
            'hikes' => Hike::orderBy('created_at', 'desc')->paginate(25)
        ]);
    }
```

- add Admin layout 

1) - create a folder (admin) in views 
- with file admin.blade.php  (layout admin)

2) - create a sub folder (hike) 
- with file index.blade.php  (list hike in admin)


## Add function create in Controller, add file (form) and folder shared with

- add function create in Controller
```php 
    public function create()
    {
        return View('admin.hike.form', [
            'hike' => new Hike(),
        ]);
    }
```

- modify function store in Controller for error HikeFormRequest $request

```php 

use App\Http\Requests\Admin\HikeFormRequest;

   public function store(HikeFormRequest $request)
    {
        //
    }
```

- add file (form.blade.php) in hike 


- add folder shared with components (flash, input, checkbox, select )


## Add protected $fillable in Models hike

- The $fillable property within a model class is used to specify which fields (columns) 
of the database table associated with that model can be mass assigned. 

- Mass assignment is a feature in Laravel that allows you to create or update multiple model attributes at once using an array of values.
```php 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hike extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'distance',
        'duration',
        'elevation_gain',
        'description',
    ];
}

```

Error Add [name] to fillable property to allow mass assignment on [App\Models\Hike].

## add function store, edit and update


- add @include('shared.flash') in layout (admin.blade.php)

```php 
    /**
     * Store a newly created resource in storage.
     */
    public function store(HikeFormRequest $request)
    {
        $hike = Hike::create($request->validated());
        return to_route('admin.hike.index')->with('success', 'Le hike a bien été créé');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hike $hike)
    {
        return View('admin.hike.form', [
            'hike' => $hike,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HikeFormRequest $request, Hike $hike)
    {
        $hike->update($request->validated());
        return to_route('admin.hike.index')->with('success', 'Le hike a bien été modifié');
    }

```

## add function delete

> folder hike > file (form.blade.php) and code next

```php 
    <form action="{{ route('admin.hike.destroy', $hike) }}" method="post">

        @csrf
        @method('delete')
        <button class="btn btn-danger">Supprimer</button>
    </form>
```

```php 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hike $hike)
    {
        $hike->delete();
        return to_route('admin.hike.index')->with('success', 'Le hike a bien été supprimé');
    }
```

## FRONT

> Http\Controllers

## create HomeController

```php 
php artisan make:controller HomeController

   INFO  Controller [\hike\app\Http\Controllers\HomeController.php] created successfully.
```


> routes\web.php 

## replace page welcome 

```php 
Route::get('/', function () {
    return view('welcome');
});
```

- by and add use App\Http\Controllers\HomeController;

```php 
(head page web.php) use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

```

- The line Route::get('/', [HomeController::class, 'index']); 

In Laravel is a route definition that maps a GET request to the root URL (/) 
of your application to a specific action within a controller. Here's a breakdown of what each part means:

> Route::get: 
- This specifies that the route responds to HTTP GET requests. 
- Laravel supports various HTTP verbs such as GET, POST, PUT, DELETE, etc., and you can define routes for these verbs using methods like Route::get, Route::post, Route::put, etc.

> '/': 
- This is the URI pattern that the route matches. 
- A / indicates the root of your application. 
- So, this route will match when someone visits the homepage of your website.

> [HomeController::class, 'index']: 
- This is an array where the first element is the controller class that handles the request, 
and the second element is the method within that controller that should be executed. 

- In this case, HomeController::class refers to the (HomeController class), and ('index') refers to the index method within that class.

> HomeController::class:
- This uses the fully qualified class name syntax to refer to the HomeController. 
- It ensures that Laravel knows exactly which class to use, even if there might be multiple classes named HomeController in different namespaces.

> 'index': 
- This is the name of the method within the HomeController that should be invoked when the route is matched. 
- The index method typically serves as the entry point for displaying a listing of resources, such as a home page or a list of items.

-----------------------------------------------------------------------

## create function index in HomeController

```php 
<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hikes = Hike::orderBy('created_at', 'desc')->limit(4)->get();
        return view('home', ['hikes' => $hikes]);
    }
}
```


> Model: Hike
- Hike refers to a model class in Laravel. 
- Models represent tables within your database, and they allow you to interact with those tables using object-oriented syntax. 
- In this case, Hike likely corresponds to a table named hikes.

> Query Components
- orderBy('created_at', 'desc')

> Order By: 
- This method sorts the results of the query based on the created_at column. 
- The created_at column typically stores the timestamp when each record was inserted into the database.

> Direction: 
- The 'desc' argument specifies that the sorting should be done in descending order. 
- This means the records will be ordered from newest to oldest based on their creation time.

> limit(4)
- This method restricts the number of records returned by the query to the first 4 records after applying the orderBy clause.
- Since the records are ordered by created_at in descending order, this effectively limits the query to the 4 most recently created records.

> get()
- Finally, the get() method executes the query and retrieves the results. 
- Without calling get(), the query would just build up the SQL statement but wouldn't actually run it against the database.

> Function: view() 
- is a helper function provided by Laravel that generates a view. 
- A view in Laravel is a template file that contains HTML markup. 
- It's responsible for presenting data to the user in a structured format.

> View Name: 'home'
- specifies the name of the view file that should be rendered. 
- Laravel looks for this file in the resources/views directory (home.blade.php). 
- So, the actual path to the view would be resources/views/home.blade.php unless otherwise configured.

> Data Passing: ['hikes' => $hikes]
- This part of the function call is an associative array that maps keys to values. 
- In this case, the key is 'hikes', and the value is the variable $hikes.

## create layout base and page home

> base.blade.php
- create layout base (front application)

> home.blade.php
- create page home (listing hikes) with a loop foreach and a include ('hike.card')

```php 
@foreach ($hikes as $hike)
    <div class='col'>
        @include('hike.card')
    </div>
@endforeach
```

> hike card.blade.php
- component card with info 

```php 
<div class="card">
    <div class='card-body'>
        <h5>
            <a href="/">{{ $hike->name }}</a>
        </h5>
        <p class='card-text'>
            {{ $hike->distance }} km - {{ $hike->duration }} min
        </p>
        <p class='card-text'>
            {{ $hike->description }}
        </p>
        <div class="text-primary" style="font-size: 1.4rem;">
            {{ $hike->elevation_gain }}
        </div>

    </div>
</div>

```

## Detail hike (HikeController with show and Model with slug)

> http\Controller
- create HikeController for front application (different admin\HikeController )

```php 
php artisan make:controller HikeController
```

- with function show and $hike->getSlug();
```php 
public function show(string $slug, Hike $hike)
    {
        $expectedSlug = $hike->getSlug();

        if ($slug !== $expectedSlug) {
            return to_route('hike.show', ['slug' => $expectedSlug, 'hike' => $hike]);
        }

        return view('hike.show', [
            'hike' => $hike
        ]);
    }
```

> Models\hike

- add function getSlug()
- (head) add use Illuminate\Support\Str;

```php 
use Illuminate\Support\Str;

    /**
     * permet  de créer un slug à partir du name
     */
    public function getSlug()
    {
        return Str::slug($this->name);
    }
```

> routes\web

- add route get hikes/{slug}-{hike} with regex (id, slug)
- (head) use App\Http\Controllers\HikeController as PublicHikeController;

```php 
use App\Http\Controllers\HikeController as PublicHikeController;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::get('/hikes/{slug}-{hike}', [PublicHikeController::class, 'show'])->name('hike.show')->where([
    'hike' => $idRegex,
    'slug' => $slugRegex
]);
```

> resources\views\hike

- modify page card ()

```php 
    <a href="{{ route('hike.show', ['slug' => $hike->getSlug(), 'hike' => $hike]) }}">{{ $hike->name }}</a>
```


- add page show (show.blade.php)

```php 
@extends('base')

@section('title', $hike->name)


@section('content')
    <div class="container mt-5">

        <h1>{{ $hike->name }} </h1>

        <div class="text-primary" style="font-size: 1.4rem;">
            {{ $hike->description }}
        </div>

        <hr>
        <div class="mt-4">
            <div class="row">
                <div class="col-8">
                    <h2>Caractéristiques</h2>
                    <table class="table table-striped">
                        <tr>
                            <td>Distance</td>
                            <td>{{ $hike->distance }} km</td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td>{{ $hike->duration }} min</td>
                        </tr>
                        <tr>
                            <td>Elevation gain</td>
                            <td>{{ $hike->elevation_gain }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-4">
                    <h2>Tags</h2>
                    <ul class="list-group">

                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
```
