<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DOCdnService implements CdnService
{
    public function purge(string $fileName): void
    {
        $folder = config('filesystems.do.folder');
        Http::asJson()->delete(
            config('filesystems.disks.do.cdn_endpoint') . '/cache',
            [
                'files' => ["{$folder}/{$fileName}"],
            ]
        );
    }
}
