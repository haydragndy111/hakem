<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use Symfony\Component\HttpFoundation\Response;

class SpecializationController extends ApiController
{
    public function index()
    {
        $specializations = Specialization::all();
        $specializationsCollection = SpecializationResource::collection($specializations);

        return response()->api($specializationsCollection, Response::HTTP_OK);
    }
}
