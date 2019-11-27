<?php

namespace Indy\LaravelConfiguration;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    /**
     * The cache key
     *
     * @var string
     */
    const CACHE_KEY = '__configurations__';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'configurations';

    /**
     * Guarded fields instead of fillable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The possible configuration type value
     *
     * @var array
     */
    protected static $types = [
        'string' => 'String',
        'int' => 'Int',
        'float' => 'Float',
        'serialized' => 'Serialized',
        'json' => 'Json',
    ];

    /**
     * No timestamp for this model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get configration value type
     *
     * @return array
     */
    public static function getTypes()
    {
        return static::$types;
    }

    /**
     * Get configration value type
     *
     * @return string
     */
    public static function getType($key)
    {
        if (isset(static::$types[$key])) {
            return static::$types[$key];
        }

        return '';
    }

    /**
     * Returns configuration settings
     *
     * @return array
     */
    public static function settings()
    {
        return self::pluck('value', 'name')->toArray();
    }

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::created(function ($configuration) {
            cache()->forget(static::CACHE_KEY);
        });

        self::updated(function ($configuration) {
            cache()->forget(static::CACHE_KEY);
        });

        self::deleted(function ($configuration) {
            cache()->forget(static::CACHE_KEY);
        });
    }
}
