<?php

namespace App;
use Baum\Node;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Category extends Node
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'allfiles' => 'array'
    ];

    public function scopeSearch($query , $keywords)
    {

        $keywords = explode(' ',$keywords);

        foreach ($keywords as $keyword)
        {
            $query->where('name' , 'LIKE' , '%' . $keyword . '%')
                  ->orWhere('parent_id' , 'LIKE' , '%' . $keyword . '%');
        }

        return $query;
    }

    /**
     * @return array
     */
    public static function getTree()
    {
        return static::getNestedList('name', 'id', '-- ');
    }

    /**
     * @param int $categoryId
     * @return array|null
     */
    public static function getChildren($categoryId)
    {
        $cat_count =  Category::where('parent_id', $categoryId)->get();
        return $cat_count->count();

    }

    /**
     * @param Category $category
     * @return array|null
     */
    public static function getBreadcrumbs($category)
    {
        return $category->ancestorsAndSelf()->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sheets()
    {
        return $this->hasMany(Sheet::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
