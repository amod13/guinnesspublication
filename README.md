## Laravel Modular Base Architecture Project

Yo project chai Laravel 10 ma based modular architecture use garera banayako ho. Yo project ma clean code principles, repository pattern, service layer, ra DTOs use gariyako xa.

## Features

-   Modular Structure: Each module has its own controllers, models, views, services, and repositories.
-   Service Layer: Business logic lai services ma separate gariyako xa.
-   Repository Pattern: Data access logic lai repositories ma separate gariyako xa.
-   DTOs: Data Transfer Objects use gariyako xa data transfer ko lagi.
-   Blade Templating: Laravel ko blade templating engine use gariyako xa views ko
    lagi.
-   Authentication: Built-in authentication system use gariyako xa.
-   RESTful APIs: API endpoints banayako xa for various modules.

## Installation

1. Clone the repository:
    ```
    git clone
    ```
2. Navigate to the project directory:
   '''
   cd laravel-modular-base
   '''
3. Install dependencies using Composer:
   ''''
   composer install
   '''
4. Copy the `.env.example` file to `.env`:
   '''
   cp .env.example .env
   '''
5. Generate application key:
   '''
   php artisan key:generate
   '''
6. Configure your database settings in the `.env` file.
7. Run migrations to set up the database:
   ''''
   php artisan migrate
   '''
8. Run Seeder
   ''
   php artisan db:seed
   '''
9. Start the development server:
   '''
   php artisan serve
   '''

## Usage

-   Access the application in your browser at `http://localhost:8000`.
-   Login Url `http://localhost:8000/auth/lpgin`.

## Login Details

Default Admin User: superadmin
Default Password: 123456

## Documentation

For detailed documentation on how to use and extend this modular architecture, please refer to the [Documentation]

## Artisan Command Using Make In Modular

1.  module Make
    '''
    php artisan module:make ModuleName
    '''
2.  Module With Basic Crud
    '''
    php artisan module:make-crud ModuleName EntityType
    ''''
3.  Migration Create
    '''
    php artisan module:make-migration ModuleName CreateEntityTable
    '''
4.  Model Create
    ''''
    php artisan module:make-model ModuleName EntityName
    '''
5.  Controller Create
    ''''
    php artisan module:make-controller ModuleName EntityNameController
    '''
6.  Service Create
    ''''



## 🧩 Slug Generation Utility

**Folder In**
 App\Core\Utils

**Purpose**
This service automatically generates a unique, URL-friendly slug for any model or table field.

**Usage Example**
if (isset($data['name'])) {
$data['slug'] = SlugGeneratorService::generateSlug(
TableName::class, 
$data['name'],
'slug' 
);
}

**Parameters**
Parameter Description
TableName The model class or database table where uniqueness should be checked.
Field name The source field used to generate the slug (e.g. $data['name']).
'slug' The column where the generated slug will be stored.

**✅ Example Output**
If name = "Everest Base Camp Trek",
then generated slug → everest-base-camp-trek.

**Tip**
If a slug already exists, it automatically appends a counter — e.g.,
everest-base-camp-trek-1, everest-base-camp-trek-2, etc.


## Media Library Image Usages Way

1. edit ko lagi src ma
   ---isset($data['record']) ? $data['record']->getMediaUrl('pdf_file') : null
2. store ra update ko lagi Service ma yo rakhne
   // Handle media ID
   if (!empty($data['thumbnail_image_media_id'])) {
   $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
   }
3. request ra dto ma rakhna abasyak hunxa jaile pani file_name sanga suffix ma (media_id jodiyara aauxa)
   --Like this file name thumbnail_image xa vani [thumbnail_image_media_id]


## Language Switching 
**Folder In**
 App\Core\Http\Controllers\LanguageController.php
 value ma 
**Purpose**
Yo controller le user ko session ma language preference set garxa. User le kun language ma site rakheko xa tehi anusar 
content display garna sakinxha.
**Usage Example**
Route::get('/switch-language/{lang}', [LanguageController::class, 'switchLanguage'])->
name('switch.language');
**Parameters**
Parameter Description
lang URL parameter ho jun le user le select gareko language code (e.g., 'en','np')->default(en)->set hunxa 



## Installed Packages List Document
**propose For Used::**
 Extract/merge existing PDF pages


**Purpose of Using the Package**
--The GeneratePdf Helper Class is utilized to determine and display how many pages are allowed to be published or viewed within a PDF document.

**Installed packages:**
✅ setasign/fpdi

-   PDF manipulation
    Artsan Command - composer require setasign/fpdi
    **Propose**
    Used for importing, extracting, and merging pages from existing PDF files.

✅ setasign/fpdf

-   PDF creation dependency
    Artsan Command - composer require setasign/fpdf
    **Propose**
    Provides the base functionality for creating and managing PDF pages.
    This package is required by FPDI.

**Note**: Yo documentation continuously update huncha. Latest version ko lagi repository check garne.
