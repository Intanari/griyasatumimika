<?php

namespace Tests\Unit;

use App\Services\MidtransService;
use Tests\TestCase;

class MidtransServiceTest extends TestCase
{
    public function test_normalize_status_maps_midtrans_states(): void
    {
        $service = new MidtransService;

        $this->assertSame('paid', $service->normalizeStatus('settlement', 'accept'));
        $this->assertSame('paid', $service->normalizeStatus('capture', null));
        $this->assertSame('expired', $service->normalizeStatus('expire'));
        $this->assertSame('failed', $service->normalizeStatus('cancel'));
        $this->assertSame('pending', $service->normalizeStatus('pending'));
    }
}
