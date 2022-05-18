<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
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
