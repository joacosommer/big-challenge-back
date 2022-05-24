<?php

namespace App\Http\Controllers;

use App\Events\UploadPrescription;
use App\Http\Requests\DigitalOceanDeleteRequest;
use App\Http\Requests\DigitalOceanStoreRequest;
use App\Http\Requests\DigitalOceanUpdateRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use App\Services\CdnService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoSpacesController extends Controller
{
    private $cdnService;

    public function __construct(CdnService $cdnService)
    {
        $this->cdnService = $cdnService;
    }

    public function store(DigitalOceanStoreRequest $request, Submission $submission): SubmissionResource
    {
        $file = $request->file('file');
        $fileName = (string) Str::uuid();
        $folder = config('filesystems.disks.do.folder');

        Storage::put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );

        $submission->update([
            'file' => $fileName,
            'status' => Submission::STATUS_DONE,
        ]);

        event(new UploadPrescription($submission));

        return (new SubmissionResource($submission))->additional(['meta' => [
            'message' => 'Prescription file uploaded',
            'status' => 200,
        ]]);
    }

    public function delete(DigitalOceanDeleteRequest $request, Submission $submission): SubmissionResource
    {
        $fileName = $submission['file'];
        $folder = config('filesystems.disks.do.folder');

        Storage::delete("{$folder}/{$fileName}");
        $this->cdnService->purge($fileName);

        $submission->update([
            'file' => null,
            'status' => Submission::STATUS_IN_PROGRESS,
        ]);

        return (new SubmissionResource($submission))->additional(['meta' => [
            'message' => 'Prescription file deleted',
            'status' => 200,
        ]]);
    }

    public function update(DigitalOceanUpdateRequest $request, Submission $submission): SubmissionResource
    {
        $file = $request->file('file');
        $fileName = $submission['file'];
        $folder = config('filesystems.disks.do.folder');

        Storage::put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );
        $this->cdnService->purge($fileName);

        event(new UploadPrescription($submission));

        return (new SubmissionResource($submission))->additional(['meta' => [
            'message' => 'Prescription file updated',
            'status' => 200,
        ]]);
    }
}
