<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class City extends Eloquent
{
    protected $collection = 'cities_collection';

    public function getCode()
    {
        return [
            'code' => $this->id
        ];
    }
}
