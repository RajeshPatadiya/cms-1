<?php namespace Devise\Search;

use App;

/**
 * Class PageSearch is an example of how you could search
 * for pages using the SearchableModelTrait
 *
 * @package Devise\Search
 */
class PageSearch extends \DvsPage
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    public $searchableType = "Page";

    /**
     * @var LanguageDetector
     */
    public $LanguageDetector;

    /**
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'meta_keywords' => 3,
            'title' => 4,
            'meta_description' => 3,
            'dvs_fields.json_value' => 2,
        ],
        'joins' => [
            'dvs_page_versions' => ['dvs_page_versions.page_id', 'dvs_pages.id'],
            'dvs_fields' => ['dvs_page_versions.id', 'dvs_fields.page_version_id'],
        ]
    ];

    public function scopeSearch($query, $search)
    {
        $query = $this->createSearchQuery($query, $search);

        // only show the languages that are active
        $language = App::make('Devise\Languages\LanguageDetector')->current();
        $query->where('language_id', $language->id);

        // exclude pages that don't have a live page version currently
        $now = new \DateTime;
        $query->where('starts_at', '<', $now);
        $query->where(function($query) use ($now)
        {
            $query->where('ends_at', '>', $now);
            $query->orWhereNull('ends_at');
        });

        return $query;
    }
}