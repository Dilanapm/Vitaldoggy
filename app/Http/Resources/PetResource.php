<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'species'           => $this->species,
            'breed'             => $this->breed,
            'age_months'        => $this->age_months,
            'age_human'         => $this->age_human ?? null, // accessor opcional
            'gender'            => $this->gender,
            'size'              => $this->size,
            'adoption_status'   => $this->adoption_status,
            'display_photo_url' => $this->display_photo_url, // accessor del modelo
            'thumbnail_url'     => $this->thumbnail_url,
            'flags' => [
                'good_with_kids' => $this->good_with_kids,
                'good_with_dogs' => $this->good_with_dogs,
                'good_with_cats' => $this->good_with_cats,
                'apartment_ok'   => $this->apartment_ok,
            ],
            'location' => [
                'city'  => $this->city,
                'state' => $this->state,
            ],
        ];
    }
}
