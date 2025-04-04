<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{
    public const TITLE     = 'post_title';
    public const CATEGORY  = 'category';
    public const FROM_DATE = 'from_date';
    public const TO_DATE   = 'to_date';

    /**
     * Get the callbacks for filtering.
     *
     * @return array
     */
    protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::CATEGORY => [$this, 'category'],
            self::FROM_DATE => [$this, 'fromDate'],
            self::TO_DATE => [$this, 'toDate'],
        ];
    }
    public function title(Builder $builder, $value)
    {
        $builder->where('post_title', 'like', "%{$value}%");
    }

    public function category(Builder $builder, $value)
    {
        $builder->where('id_category', $value);
    }

    public function fromDate(Builder $builder, $value)
    {
        $builder->where('post_date', '<=', $value);
    }
    public function toDate(Builder $builder, $value)
    {
        $builder->where('post_date', '>=', $value);
    }
}
