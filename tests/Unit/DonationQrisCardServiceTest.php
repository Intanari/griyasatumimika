<?php

namespace Tests\Unit;

use App\Models\Donation;
use App\Services\DonationQrisCardService;
use Tests\TestCase;

class DonationQrisCardServiceTest extends TestCase
{
    public function test_build_filename_uses_order_id_and_donor_name(): void
    {
        $donation = new Donation([
            'order_id'   => 'PJ-TEST1234-1710000000',
            'donor_name' => 'Agung Hendi Temorubun',
        ]);

        $filename = (new DonationQrisCardService)->buildFilename($donation);

        $this->assertSame(
            'pembayaran-qris-pj-test1234-1710000000-agung-hendi-temorubun.png',
            $filename,
        );
    }
}
