<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Specify the models you want to be able to edit with laraPages
    | 'modelId'=>'Nice name',
    | modelId will be used to define the model name with studly_case()
    | so page will be Model App\Page and user App\User
    | Nice name will be what to logged user will see in the navigation menu
    |
    */

    'models' => [
        'page'=>'Pages',
        'user'=>'Users',    
    ],
    
    /*
    |--------------------------------------------------------------------------
    | reports
    |--------------------------------------------------------------------------
    |
    | Define SQL queries for the reports here
    |
    */
    
    'reports' => [
        'nicename' => 'Reports',
        'queries' => [
            'All pages' => 'SELECT * FROM pages',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | adminpath
    |--------------------------------------------------------------------------
    |
    | The url used to login. e.g. 'lp-admin' for www.domain.com/lp-admin
    |
    */

    'adminpath' => 'lp-admin',
    
    /*
    |--------------------------------------------------------------------------
    | media options
    |--------------------------------------------------------------------------
    |
    | Options for media management
    | Set to false to disable media completly
    |
    */

    'media' => [
        'nicename'=>'Media',     # Nicename to show in menu
        'expanded'=>3,           # When treeview is shown auto expand up to 3 levels
        'maxUploadSize'=>'12',   # Maximum size of an uploaded file in megabytes, still limited by php.ini upload_max_filesize and post_max_size
        'folder'=>'media',       # Base folder to store uploaded files. Will be public_path(this)
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    |
    | Specify the users and passwords you want to be able to login to laraPages
    | Hash passwords with bcrypt() or password_hash('xxx', PASSWORD_BCRYPT)
    | Most secure is to put the hash string here, for example:
    | 'admin' => '"$2y$10$ugiFuuMhKZNYHfhdoewkZYUlt1UhkBux3FYDRXcmURhhr/eHC"' 
    | By default get the admin password from LARAPAGES_ADMIN_PASSWORD in .env
    |
    */
	    
    'users' => [
	    'admin' => password_hash(env('LARAPAGES_ADMIN_PASSWORD'), PASSWORD_BCRYPT),
/*
	    'nick' => [
            'password' => password_hash(env('LARAPAGES_ADMIN_PASSWORD'), PASSWORD_BCRYPT),
            'name' => 'Nick de Kruijk',
	    ],
*/
    ],

    /*
    |--------------------------------------------------------------------------
    | userModel
    |--------------------------------------------------------------------------
    |
    | To read the users from a database you can specify a model here.
    |
    */

    'userModel' => [
        'model' => 'App\User',      # The model to use, default null
        'username' => 'email',      # Use this column as username, default 'email'
        'password' => 'password',   # Use this column for the password, default 'password'
        'name' => 'name',           # Use this column for the name, default 'name'
    ],

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    |
    | Specify the views to be used by the parse() method
    |
    */
	    
    'views' => [
	    '404' => 'laraPages::main.404',
	    'page' => 'laraPages::main.page',
    ],

    /*
    |--------------------------------------------------------------------------
    | css
    |--------------------------------------------------------------------------
    |
    | Extra CSS files to load, you can use this to customize the look and feel
    |
    */
	    
    'css' => [
// 	    '/vendor/larapages/css/larapages2.css',
// 	    '/css/lp-admin-custom.css',	    
    ],

];
