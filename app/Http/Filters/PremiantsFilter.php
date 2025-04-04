<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;


class PremiantsFilter extends AbstractFilter
{
    public const FULLNAME    = 'fullName';
    public const AGE         = 'age';
    public const WEIGHT      = 'weight';
    public const PLACE       = 'place';
    public const COMPETITION = 'competition';

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
            self::WEIGHT => [$this, 'premiantWeight'],
            self::PLACE => [$this, 'premiantPlace'],
            self::COMPETITION => [$this, 'competition'],
        ];
    }
    public function premiantName(Builder $builder, $value)
    {
        $builder->whereHas('athlet', function ($query) use ($value){
            $query->where('fullName', 'like', "%{$value}%");
        });
    }

    public function premiantAge(Builder $builder, $value)
    {
        $builder->whereHas('athlet', function ($query) use ($value){
            $query->where('age', $value);
        });
    }

    public function premiantWeight(Builder $builder, $value)
    {
        $builder->where('weight', $value);
    }
    public function premiantPlace(Builder $builder, $value)
    {
        $builder->where('place', $value);
    }
    public function competition(Builder $builder, $value)
    {
        $builder->whereHas('competition', function ($query) use ($value) {
            $query->where('name', 'like', "%{$value}%");
        });
    }

}
