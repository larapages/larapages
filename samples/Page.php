<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    
    # Define what the PagesAdminController is allowed to to with the model and how
    public $pagesAdmin=[
        'nicename'=>'Website pages',                # Title to show in header
        'index'=>'title,id',                        # Columns to show in listview
        'active'=>'active',                         # Boolean type column that determines if page is active or not
        'sortable'=>'sort',                         # Data can be sorted by dragging, store values in 'sort' column
        'orderBy'=>'sort',                          # Data is ordered by this column at for descending order you can use something like 'date DESC'
        'treeview'=>'parent',                       # Items can be shown in a treeview, 'parent' column determines parent/child relation
        'expanded'=>3,                              # When treeview is shown auto expand up to 3 levels
        'validate'=>[                               # Laravel validation rules
            'title'=>'required',
            'published_at'=>'date',
            'date'=>'date',
        ],
        'accessors'=>false,                         # Disable accessors when editing model. Use this when accessors modify empty columns for example and you want to leave them blank when editing
        'type'=>[                                   # Column types, this determines the model editing view input types. If ommitted default text input is used
            'active'=>'boolean',
            'published_at'=>'datetime',
            'url'=>'100',
            'html_title'=>'64',
            'description'=>'text',
            'date'=>'date',
            'pictures'=>'media,10',
            'body'=>'longtext',
        ],
        'rename'=>[                                 # Rename columns
            'pictures'=>'Media',
        ],
        'tinymce'=>[                                # List of columns that can contain html and should be edited with TinyMCE
            'body'=>'tinymce options',
        ],
    ];
    
    # Fillable columns, also used by PagesAdminController to build the form so the order matters
    protected $fillable = [
        'active',
        'published_at',
        'title',
        'head',
        'html_title',
        'url',
        'description',
        'date',
        'picture',
        'body',
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'deleted_at', 'published_at'];
    
    # This scope returns only the active pages and in the right order
    public function scopeActiveSorted($query)
    {
        $query->where('active', 1)->orderBy('sort');
    }
    
    # This scope return only the active pages that belong to a certain parent and in the right order
    public function scopeParent($query,$parent)
    {
        $query->where('parent', $parent)->activeSorted();
    }
    
    # If head is empty use the title
    public function getHeadAttribute($value)
    {
        if (!$value) $value=$this->title;
        return $value;
    }
    
    # If html_title is empty use the title
    public function getHtmlTitleAttribute($value)
    {
        if (!$value) $value=$this->title;
        return $value;
    }
    
    # If url is empty create url based on title
    public function getUrlAttribute($value)
    {
        # If url = / then it's actually an empty route
        if ($value=='/') return '';
        
        # No value so create nicely formatted url from title
        if (!$value) $value=str_slug($this->title);

        return $value;
    }

    # Determine fullUrl by include the parent url(s)
    public function getFullUrlAttribute()
    {
        if ($this->parent>0) {
            $parent=Page::findOrFail($this->parent);
            return $parent->fullUrl.'/'.$this->url;
        } else
            return $this->url;
    }

    # If picture is empty return first picture from pictures column
    public function getPictureAttribute($value)
    {
        if (!$value)
            $value=trim(explode(chr(10), trim($this->pictures))[0]);
        return $value;
    }

    # Return the children of the page (subpages)
    public function children()
    {
        return $this->hasMany('App\Page', 'parent');
    }

    # Fetch the navigation tree, usefull for pages not using the @route menthod
    public static function navigation()
    {
        $page=new Page;
        return $page->walk();
    }

    /**
     * Controller method for Route creation
     * In routes.php / web.php use:
     * Route::get('{any}', '\App\Page@route')->where('any', '(.*)');
     */
    public function route($any, Request $request)
    {
        # Start walking the page tree
        $navigationHtml = $this->walk(null, 0, Request::segments());

        # If currentPage isn't set raise a custom 404
        if (!$this->currentPage) abort(404);
        
        # Return the page view
        if ($this->currentPage['parent']>0) $this->currentPage['view']='detail';
		return view($this->currentPage['view']?$this->currentPage['view']:'page', ['page' => $this->currentPage, 'navigationHtml' => $navigationHtml]);
    }

}
