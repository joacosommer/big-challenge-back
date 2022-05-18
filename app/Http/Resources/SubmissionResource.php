<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'patient_id' => $this['patient_id'],
            'doctor_id' => $this['doctor_id'],
            'title' => $this['title'],
            'date_symptoms_start' => $this['date_symptoms_start'],
            'description' => $this['description'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'status' => $this['status'],
            'file' => $this['file'],
        ];
    }
}
