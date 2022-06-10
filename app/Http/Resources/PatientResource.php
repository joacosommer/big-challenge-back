<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'weight' => $this['weight'],
            'height' => $this['height'],
            'insurance_provider' => $this['insurance_provider'],
            'current_medications' => $this['current_medications'],
            'allergies' => $this['allergies'],
        ];
    }
}
