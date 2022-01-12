<?php namespace Indikator\News\Models;

use Model;

class Categories extends Model
{
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\NestedTree;
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    protected $table = 'indikator_news_categories';

    public $rules = [
        'name'   => 'required',
        'slug'   => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:indikator_news_categories'],
        'status' => 'required|between:1,2|numeric',
        'hidden' => 'required|between:1,2|numeric'
    ];

    protected $slugs = [
        'slug' => 'name'
    ];


    public $belongsToMany = [
        'subscribers' => [
            'Indikator\News\Models\Subscribers',
            'table'    => 'indikator_news_relations',
            'key'      => 'categories_id',
            'otherKey' => 'subscriber_id',
            'order'    => 'name'
        ],
        'posts' => [
            'Indikator\News\Models\Posts',
            'table' => 'indikator_news_posts_categories',
            'order' => 'published_at desc',
            'scope' => 'isPublished',
            'key'      => 'category_id',
            'otherKey' => 'post_id'
        ],
        'posts_count' => [
            'Indikator\News\Models\Posts',
            'table' => 'indikator_news_posts_categories',
            'scope' => 'isPublished',
            'key'      => 'category_id',
            'otherKey' => 'post_id',
            'count' => true
        ]
    ];

    public $hasMany = [
        'posts' => [
            'Indikator\News\Models\Posts',
            'key' => 'category_id'
        ]
    ];

    public $translatable = [
        'name',
        ['slug', 'index' => true],
        'summary',
        'content'
    ];

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param \Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    public function scopeIsActive($query) {
        $query->where('hidden', 2)
            ->where('status', 1);
    }
}
