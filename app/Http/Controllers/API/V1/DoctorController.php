<?php

namespace App\Http\Controllers\API\V1;

use App\Constants\DoctorConstants;
use App\Http\Controllers\ApiController;
use App\Http\Resources\DoctorCardResource;
use App\Http\Resources\DoctorCollection;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends ApiController
{
    public function index(Request $request)
    {
        try {
            $doctors = Doctor::all();

            $doctorsCollection = DoctorCollection::collection($doctors);

            return response()->api($doctorsCollection, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->apiError('something wrong', Response::HTTP_OK);
        }
    }

    public function featuredIndex(Request $request)
    {
        $doctors = Doctor::isFeatured()->get();

        $doctorsCollection = DoctorCardResource::collection($doctors);
        return response()->api($doctorsCollection, Response::HTTP_OK);
    }
}
