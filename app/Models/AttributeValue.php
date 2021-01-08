<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValue extends Model
{
    /**
     * @var string
     */
    protected $table = 'attribute_values';

    /**
     * @var string[]
     */
    protected $fillable = [
        'attribute_id', 'value', 'price'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'attribute_id' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
