<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorInformationRequest;
use App\Http\Requests\UpdateDoctorInformationRequest;
use App\Models\DoctorInformation;

class DoctorInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDoctorInformationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorInformationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorInformation  $doctorInformation
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorInformation $doctorInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorInformation  $doctorInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorInformation $doctorInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDoctorInformationRequest  $request
     * @param  \App\Models\DoctorInformation  $doctorInformation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorInformationRequest $request, DoctorInformation $doctorInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorInformation  $doctorInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorInformation $doctorInformation)
    {
        //
    }
}
