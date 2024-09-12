<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'specialization' => $this->specialization->name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'image' => '/doctors/doctor-avatar.jpg',
            'rating' => 2.5,
            'patients_count' => 4,
            'next_available' => '10:00 AM tomorrow',
            'is_favourite' => true,
        ];

        return $data;
    }
}
