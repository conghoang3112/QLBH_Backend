<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResponseHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ExchangerateController extends ApiController
{
    use ResponseHandlerTrait;

    /**
     * Register default routes
     * @param string|null $role
     * @return void
     */
    public static function registerRoutes(string $role = null): void
    {
        $root = 'exchangerate';
        if ($role == UserRoles::ADMIN) {
            Route::get($root . '/usd', [ExchangerateController::class, 'usd']);
        }
    }

    public function usd()
    {
        $uri = config('exchangerate.api');
        $response = Http::get($uri);
        $status = $response->status();
        if ($status == 200) {
            $data = json_decode($response->body());
            if (empty($data->result)) return $this->getResponseHandler()->fail("result not found");
            if (empty($data->conversion_rates)) return $this->getResponseHandler()->fail("conversion_rates not found");
            if ($data->result != 'success') return $this->getResponseHandler()->fail(['result' => $data->result]);

            return $this->getResponseHandler()->send([
                'base_code' => $data->base_code ?? null,
                'rates' => $data->conversion_rates,
                'time_last_update_unix' => $data->time_last_update_unix ?? null,
                'time_last_update_utc' => $data->time_last_update_utc ?? null,
                'status' => $status,
            ]);
        }
        return $this->getResponseHandler()->fail(['status' => $status]);
    }
}
