<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PisteRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
        [
            'type' => 'FeatureCollection',
            [
                'type' => 'feature',
                'properties' => [
                    'id' => $this->id,
                    'longueur' => $this->longueur,
                ],
                'geometry' => [
                    'Type' => 'LineString',
                    'coordinates' => GeometryResource::collection($this->whenLoaded('geometries')),
                ],
            ]

        ];
    }
}
