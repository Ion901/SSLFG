<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;

class SportiviFilter extends AbstractFilter
{
    public const FULLNAME    = 'fullName';
    public const AGE         = 'age';

    /**
     * Get the callbacks for filtering.
     *
     * @return array
     */
    protected function getCallbacks(): array
    {
        return [
            self::FULLNAME => [$this, 'premiantName'],
            self::AGE => [$this, 'premiantAge'],

        ];
    }
    public function premiantName(Builder $builder, $value)
    {
        $builder->where('fullName', 'like', "%{$value}%");
    }

    public function premiantAge(Builder $builder, $value)
    {
        $builder->where('age', $value);
    }

}
