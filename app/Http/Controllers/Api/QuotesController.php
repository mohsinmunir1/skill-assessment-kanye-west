<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\FavoriteService;
use App\Models\Favorite;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    /**
     * @param FavoriteService $favoriteService
     */
    public function __construct(
        private FavoriteService $favoriteService,
    ) {}

    /**
     * @param int $length
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function index(int $length = 5): JsonResponse
    {
        try {
            $client = new Client();
            $res = $client->get('https://raw.githubusercontent.com/ajzbc/kanye.rest/master/quotes.json');
            $data = json_decode($res->getBody());
            $keys = array_rand($data, $length);
            $quotes = array_map(function ($key) use ($data) {
                return $data[$key];
            }, $keys);

            return response()->json([
                'success' => true,
                'data' => $quotes
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFavorite(Request $request): JsonResponse
    {
        try {
            $this->favoriteService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Successfully saved',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
               'status' => false,
               'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function listFavorite(): JsonResponse
    {
        try {
            $favorite = $this->favoriteService->all();
            return response()->json([
                'success' => true,
                'data' => $favorite
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Favorite $favorite
     * @return JsonResponse
     */
    public function deleteFavorite(Favorite $favorite): JsonResponse
    {
        try {
            $this->favoriteService->delete($favorite);
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
