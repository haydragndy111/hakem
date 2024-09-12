<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *    title="Cube26 API Documentation",
 *    version="1.0.0",
 * )
 */
class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->user = Auth::guard('sanctum')->user();
        // dd($this->user);
        $this->user_data = [];
        if ($this->user) {
            $this->user_data = [
                'id' => $this->user->id,
                'user_name' => $this->user->user_name,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
            ];
        }

    }

}
