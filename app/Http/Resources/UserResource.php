<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this['first_name'],
            'last_name' => $this['last_name'],
            'date_of_birth' => $this['date_of_birth'],
            'gender' => $this['gender'],
            'phone_number' => $this['phone_number'],
            'address' => $this['address'],
            'email' => $this['email'],
            'patient_info' => new PatientResource($this['patientInformation']),
            'doctor_info' => new DoctorResource($this['doctorInformation']),
        ];
    }
}
