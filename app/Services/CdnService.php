<?php

namespace App\Services;

/**
 * Class CdnService.
 */
interface CdnService
{
    public function purge(string $fileName): void;
}
