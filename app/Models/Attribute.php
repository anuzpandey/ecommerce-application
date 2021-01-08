<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{

    /**
     * @var string
     */
    protected $table = 'attributes';

    /**
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'frontend_type',
        'is_filterable',
        'is_required'
    ];

    /**
     * @var string[]
     */
    protected $casts  = [
        'is_filterable' =>  'boolean',
        'is_required'   =>  'boolean',
    ];

    /**
     * @return HasMany
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

