<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class CompetitionFilter extends AbstractFilter
{
    /**
     * Create a new class instance.
     */
    public const NAME      = 'name';
    public const LOCATION  = 'location';
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
            self::NAME => [$this, 'name'],
            self::LOCATION => [$this, 'location'],
            self::FROM_DATE => [$this, 'fromDate'],
            self::TO_DATE => [$this, 'toDate'],
        ];
    }
    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function location(Builder $builder, $value)
    {
        $builder->where('location','like', "%{$value}%");
    }

    public function fromDate(Builder $builder, $value)
    {
        $builder->where('date', '<=', $value);
    }
    public function toDate(Builder $builder, $value)
    {
        $builder->where('date', '>=', $value);
    }
}
