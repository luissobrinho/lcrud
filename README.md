# LCrud

**LCrud** - An incredibly powerful and some say magical CRUD maker for Laravel

[![Latest Version](https://img.shields.io/packagist/v/luissobrinho/lcrud.svg)](https://packagist.org/packages/luissobrinho/lcrud)
[![Build Status](https://travis-ci.org/LuissobrinhoInc/lcrud.svg?branch=develop)](https://travis-ci.org/LuissobrinhoInc/lcrud)
[![Packagist](https://img.shields.io/packagist/dt/luissobrinho/lcrud.svg)](https://packagist.org/packages/luissobrinho/lcrud)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/luissobrinho/lcrud)

It can generate magical CRUD prototypes rapidly with full testing scripts prepared for you, requiring very little editing. Following SOLID principals it can construct a basic set of components pending on a table name provided in the CLI. The CRUD can be used with singular table entities think: 'books' or 'authors' but, you can also build CRUDs for combined entities that is a parent, and child like structure: 'books_authors'. This will generate a 'books_authors' table and place all components of the authors (controller, service, model etc) into a Books namespace, which means you can then generate 'books_publishers' and have all the components be added as siblings to the authors. Now let's say you went ahead with using the Laracogs starter kit, then you can autobuild your CRUDs with them bootstrapped, which means they're already wrapped up as view extensions of the dashboard content which means you're even closer to being done your application.

##### Author(s):
* [Luis Eduardo Altino](https://github.com/luissobrinho) ([ads.luis.sobrinho@gmail.com](mailto:ads.luis.sobrinho@gmail.com))

## Requirements

1. PHP 7+
2. OpenSSL

## Compatibility and Support

| Laravel Version | Package Tag | Supported |
|-----------------|-------------|-----------|
| 6.x - 7.x | 1.5 | yes |

## Documentation

```
php artisan lcrud:new {name or snake_names}
{--api}
{--ui=bootstrap}
{--serviceOnly}
{--withBaseService}
{--withFacade}
{--withoutViews}
{--migration}
{--schema}
{--relationships}
```

## Config
The config is published in `config` where you can specify namespaces, locations etc.

## Templates
All generated components are based on templates. There are basic templates included in this package, however in most cases you will have to conform them to your project's needs. If you have published the assets during the installation process, the template files will be available in `resources/lcrud/crud`.

Test templates are treated differently from the other templates. By default there are two test templates provided, one integration test for the generated service, and one acceptance test. However, the Tests folder has a 'one to one' mapping with the tests folder of your project. This means you can easily add tests for different test levels matching your project. For example, if you want to create a unit test for the generated controller, you can just create a new template file, for instance `resources/lcrud/crud/Tests/Unit/ControllerTest.txt`. When running the CRUD generator, the following file will then be created: `tests/unit/NameOfResourceControllerTest.php`.

## API
The API option will add in a controller to handle API requests and responses. It will also add in the API routes assuming this is v1.

```
yourapp.com/api/v1/books
```

## UI
There is only one supported CSS framework (Bootstrap). Without the UI option specified the LCrud will use the plain HTML view which isn't very nice looking.

Both expect a dashboard parent view, this can be generated with the following commands:
```
--ui=bootstrap
```

These re-skin your views with either of the CSS frameworks.

## Service Only
The service only will allow you to generate CRUDs that are service layer and lower this includes: Service, Model, and Tests with the options for migrations. It will skip the Controllers, Routes, Views, etc. This keeps your code lean, and is optimal for relationships that don't maintain a 'visual' presence in your site/app such as downloads of an entity.

## With Base Service
If you opt in for this the LCrud will generate a BaseService which this CRUD's service will extend from. This can be handy when you want to reduce code duplication.

## With Facades
If you opt in for Facades the CRUD will generate them, with the intention that they will be used to access the service. You will need to bind them to the app in your own providers, but you will at least have the Facade file generated.

## Migration
The migration option will add the migration file to your migrations directory, using the schema builder will fill in the create table method. The Schema and Relationships require this since they expect to modify the migration file generated.

## Schema
*Requires migration option*

You can define the table schema with the structure below. The field types should match what would be the Schema builder.

```
--schema="id:increments,name:string"
```

The following column types are available:

* id
* bigIncrements
* increments
* bigInteger
* binary
* boolean
* char
* date
* dateTime
* decimal
* double
* enum
* float
* integer
* ipAddress
* json
* jsonb
* longText
* macAddress
* mediumInteger
* mediumText
* morphs
* smallInteger
* string
* text
* time
* tinyInteger
* timestamp
* uuid

#### Want further definitions?

```
--schema="id:increments|first,user_id:integer|unsigned,name:string|nullable|after('id'),age:integer|default(0)"
```

You can even handle some parameters such as:

```
--schema="id:increments|first,user_id:integer|unsigned,name:string(45)"
```

## Relationships
*Requires migration option*

You can specify relationships, in order to automate a few more steps of building your CRUDs. You can set the relationship expressions like this:

```
relation|class|column
```

or something like:

```
hasOne|App\Author|author
```

This will add in the relationships to your models, as well as add the needed name_id field to your tables. Just one more thing you don't have to worry about.
The general relationships handled by the HTML rendered are:

```
hasOne
hasMany
belongsTo
```

!!! warning "The CRUD currently doesn't support `belongsToMany` that is to say it does not currently create a relational table"

## Examples
The following components are generated:

#### Files Generated

* Controller
* Api Controller (optional)
* Service
* CreateRequest
* UpdateRequest
* Model
* Facade (optional)
* Views (Bootstrap or Semantic or CSS framework-less)
* Tests
* Migration (optional)
Appends to the following Files:
* app/Http/routes.php
* database/factories/ModelFactory.php

#### Single Word Example (Book):
```
php artisan lcrud:new Book
--migration
--schema="id:increments,title:string,author:string"
```

When using the default paths for the components, the following files will be generated:

* app/Http/Controllers/BookController.php
* app/Http/Requests/BookCreateRequest.php
* app/Http/Requests/BookUpdateRequest.php
* app/Models/Book/Book.php
* app/Services/BookService.php
* resources/views/book/create.blade.php
* resources/views/book/edit.blade.php
* resources/views/book/index.blade.php
* resources/views/book/show.blade.php
* database/migrations/create_books_table.php
* tests/BookIntegrationTest.php
* tests/BookServiceTest.php

#### Snake Name Example (Book_Author):
```
php artisan lcrud:new Book_Author
--migration
--schema="id:increments,firstname:string,lastname:string"
--withFacade
```

When using the default paths for the components, the following files will be generated:

* app/Facades/Books/AuthorServiceFacade.php
* app/Http/Controllers/Books/AuthorController.php
* app/Http/Requests/Books/AuthorCreateRequest.php
* app/Http/Requests/Books/AuthorUpdateRequest.php
* app/Models/Books/Author/Author.php
* app/Services/Books/AuthorService.php
* resources/views/book/author/create.blade.php
* resources/views/book/author/edit.blade.php
* resources/views/book/author/index.blade.php
* resources/views/book/author/show.blade.php
* database/migrations/create_book_authors_table.php
* tests/Books/AuthorIntegrationTest.php
* tests/Books/AuthorServiceTest.php

#### Single Name Example (Book with API):
```
php artisan lcrud:new Book
--api
--migration
--schema="id:increments,title:string,author:string"
```

When using the default paths for the components, the following files will be generated:

* app/Http/Controllers/Api/BookController.php
* app/Http/Controllers/BookController.php
* app/Http/Requests/BookCreateRequest.php
* app/Http/Requests/BookUpdateRequest.php
* app/Models/Book/Book.php
* app/Services/BookService.php
* resources/views/book/create.blade.php
* resources/views/book/edit.blade.php
* resources/views/book/index.blade.php
* resources/views/book/show.blade.php
* database/migrations/create_books_table.php
* tests/BookIntegrationTest.php
* tests/BookServiceTest.php

This is an example of what would be generated with the CRUD builder. It has all basic CRUD methods set.

## Table CRUD

The table CRUD is a wrapper on the CRUD which will parse the table in the database and build the CRUD from that table.

*You must make sure the name matches the table name case wise*

```
php artisan lcrud:table {name or snake_names}
{--api}
{--ui=bootstrap}
{--serviceOnly}
{--withFacade}
{--relationships}
```

# LForm

**LForm** - A remarkably magical form and input maker tool for Laravel.

The LForm package provides a set of tools for generating HTML forms with as little as 1 line of code. Don't want to write boring HTML, neither do we. The LForm will generate error containers, all fields defined by either the table or object column types, or if you prefer to have more control define a config.

Time to publish those assets!
```
php artisan vendor:publish --provider="Luisobrinho\LForm\LFormProvider"
```

----

# LForm Guide

## Blade Directives

```php
@form_maker_table();
@form_maker_object();
@form_maker_array();
@form_maker_columns();
```

## Helpers

```php
form_maker_table();
form_maker_object();
form_maker_array();
form_maker_columns();
```

## Facades

```php
LForm::fromTable();
LForm::fromObject();
LForm::fromArray();
LForm::getTableColumns();
```

## Common Components

## Simple Fields

These components are the most simplistic:

```
class: 'a css class'
reformatted: true|false // Reformats the column name to remove underscores etc
populated: true|false // Fills in the form with values
idAndTimestamps: true|false // ignores the id and timestamp columns
```

### Columns

Columns is an array of the following nature which can be used in place of the columns component in any of the fromX methods:

```php
[
    'id' => [
        'type' => 'hidden',
    ],
    'name' => [
        'type' => '', // defaults to standard text input
        'placeholder' => 'User Name Goes Here!',
        'alt_name' => 'User Name',
        'custom' => 'custom DOM attributes etc',
        'class' => 'css class names',
        'before' => '<span class="input-group-addon" id="basic-addon1">@</span>',
        'after' => '<span class="input-group-addon" id="basic-addon2">@example.com</span>',
    ],
    'job' => [
        'type' => 'select',
        'alt_name' => 'Your Job',
        'custom' => 'multiple', // custom attributes like multiple, disabled etc
        'options' => [
            'key 1' => 'value_1',
            'key 2' => 'value_2',
        ]
    ],
    'roles' => [
        'type' => 'relationship',
        'class' => 'App\Repositories\Roles\Roles',
        'label' => 'name' // the field for the label in the select input generated
    ]
]
```

Types supported in the Column Config:

* text (converts to textarea)
* password
* checkbox
* checkbox-inline
* radio
* select
* hidden
* number
* float
* decimal

_** If no type is set the LForm will default to a standard text input_

Columns with the following names will not be displayed by default: id, created_at, updated_at. You would need to override this setting in the creation of the form.

### View

You can create a custom view that the LForm will use: This is an example:

```blade
<div class="row">
    <div class="form-group {{ $errorHighlight }}">
        <label class="control-label" for="{!! $labelFor !!}">{!! $label !!}</label>
        <div class="row">
            {!! $input !!}
        </div>
    </div>
    {!! $errorMessage !!}
</div>
```

## fromTable()

```
LForm::fromTable($table, $columns = null, $class = 'form-control', $view = null, $reformatted = true, $populated = false, $idAndTimestamps = false)
```

### Example:

```
LForm::fromTable('users')
```

The fromTable method will crawl the specified table and build the form out of the columns and types of coloumns. You can freely customize it (see below) the basic above example will result in:

```haml
<div class="form-group ">
    <label class="control-label" for="Name">Name</label>
    <input  id="Name" class="form-control" type="" name="name" placeholder="Name">
</div>
<div class="form-group ">
    <label class="control-label" for="Email">Email</label>
    <input  id="Email" class="form-control" type="" name="email" placeholder="Email">
</div>
<div class="form-group ">
    <label class="control-label" for="Password">Password</label>
    <input  id="Password" class="form-control" type="" name="password" placeholder="Password">
</div>
<div class="form-group ">
    <label class="control-label" for="Remember_token">Remember Token</label>
    <input  id="Remember_token" class="form-control" type="" name="remember_token" placeholder="Remember Token">
</div>
```

## fromObject()

Within the same rules as above we can rather than provide a table string we can insert an object such as `Auth::user()` or any single object retrieved from the database.

```
fromObject($object, $columns = null, $view = null, $class = 'form-control', $populated = true, $reformatted = false, $idAndTimestamps = false)
```

## fromArray()

From array works in the same context as fromTable, and fromObject, we're able to in this case provide a simple array list of properties. The key difference with fromArray is that we can provide these in one of two formats:

```php
[ 'name', 'birthday' ]
```

OR

```php
[ 'name' => 'string', 'birthday' => 'date' ]
```

The full list of field types compatible are:

* integer
* string
* datetime
* date
* float
* binary
* blob
* boolean
* datetimetz
* time
* array
* json_array
* object
* decimal
* bigint
* smallint

```blade
fromArray($array, $columns = null, $view = null, $class = 'form-control', $populated = true, $reformatted = false, $idAndTimestamps = false)
```

## getTableColumns()

The getTableColumns method utilizes Doctrines Dbal component to map your database table and provide the columns and types. This is perfect initial builds of an editor form off an object.

Example:

```blade
LForm::fromObject(Books::find(1), LForm::getFromColumns('books'))
```

This will build the form off the columns of the table. Though the fromObject will scan through the object, but providing the table columns as the columns input allows the inputs to be set to thier correct type.
```

----

# InputMaker Guide

The nice part about the input maker is that its the core of the form maker only pulled out. So this way you can reduce your HTML writing significanly with its blade directives or helpers.

## Blade Directives

```blade
@input_maker_label()
@input_maker_create()
```

## Helpers

```
input_maker_label();
input_maker_create();
```

## Facades

```php
InputMaker::label();
InputMaker::create();
```

## Common Components

## Simple Fields For Everything!

The label generator is the easiest:

```
input_maker_label('name', ['class' => 'something'])
```

The input generator has a few more parts:

```
input_maker_create($name, $field, $object = null, $class = 'form-control', $reformatted = false, $populated = true)
```

The $field paramter is an array which can be highly configured.

### Example $feild Config

```php
[
    'type' => '', // defaults to standard text input
    'placeholder' => 'User Name Goes Here!',
    'alt_name' => 'User Name',
    'custom' => 'custom DOM attributes etc',
    'class' => 'css class names',
    'before' => '<span class="input-group-addon" id="basic-addon1">@</span>',
    'after' => '<span class="input-group-addon" id="basic-addon2">@example.com</span>',
]
```

For Relationships:
```blade
[
    'model' => 'Full class as string',
    'label' => 'visible name for the options',
    'value' => 'value for the options',
]

// Example without User:
@input_maker_create('roles', ['type' => 'relationship', 'model' => 'App\Repositories\Role\Role', 'label' => 'label', 'value' => 'name'])

// Example with User:
@input_maker_create('roles', ['type' => 'relationship', 'model' => 'App\Repositories\Role\Role', 'label' => 'label', 'value' => 'name'], $user)
```

Types supported in the Config:

* string
* text (converts to textarea)
* password
* checkbox
* checkbox-inline
* radio
* select
* hidden
* number
* float
* decimal
* relationship

_** If no type is set the InputMaker will default to a standard text input_

----

## License
LCrud is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Bug Reporting and Feature Requests
Please add as many details as possible regarding submission of issues and feature requests

### Disclaimer
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
