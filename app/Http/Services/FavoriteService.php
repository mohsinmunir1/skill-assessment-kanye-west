<?php

namespace App\Http\Services;


use App\Http\Repositories\FavoriteRepository;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FavoriteService
{

    /**
     * @param FavoriteRepository $favoriteRepository
     */
    public function __construct(
        private FavoriteRepository $favoriteRepository
    ) {}

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->favoriteRepository->create($data);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->favoriteRepository->all();
    }

    /**
     * @param Favorite $favorite
     * @return bool
     */
    public function delete(Favorite $favorite): bool
    {
        return $this->favoriteRepository->delete($favorite);
    }

}
