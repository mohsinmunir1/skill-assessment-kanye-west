<?php

namespace App\Http\Repositories;

use App\Models\Favorite;

class FavoriteRepository extends BaseRepository
{
    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }
}
