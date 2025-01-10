<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayoutCurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            // NGN
            [
                'currency' => 'NGN',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => false,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // USD
            [
                'currency' => 'USD',
                'requires_account_bank' => false,
                'requires_account_number' => true,
                'requires_destination_branch_code' => false,
                'meta' => json_encode([
                    'fields' => [
                        'routing_number', 'swift_code', 'bank_name', 'beneficiary_name', 'beneficiary_address', 'beneficiary_country',
                    ],
                ]),
                'is_international' => true,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // EUR
            [
                'currency' => 'EUR',
                'requires_account_bank' => false,
                'requires_account_number' => true,
                'requires_destination_branch_code' => false,
                'meta' => json_encode([
                    'fields' => [
                        'bank_name','routing_number', 'swift_code',  'beneficiary_name', 'beneficiary_country', 'postal_code', 'street_number', 'street_name', 'city',
                    ],
                ]),
                'is_international' => true,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // GBP
            [
                'currency' => 'GBP',
                'requires_account_bank' => false,
                'requires_account_number' => true,
                'requires_destination_branch_code' => false,
                'meta' => json_encode([
                    'fields' => [
                        'bank_name', 'routing_number', 'swift_code', 'beneficiary_name', 'beneficiary_country', 'postal_code', 'street_number', 'street_name', 'city',
                    ],
                ]),
                'is_international' => true,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // GHS
            [
                'currency' => 'GHS',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => true,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // KES
            [
                'currency' => 'KES',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => false,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // MWK
            [
                'currency' => 'MWK',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => true,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>false,
                'is_mobile_money'=>true,
                'mobile_money_providers'=>null,
            ],
            // SLL
            [
                'currency' => 'SLL',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => true,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
            // XAF
            [
                'currency' => 'XAF',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => true,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>false,
                'is_mobile_money'=>true,
                'mobile_money_providers'=>null,
            ],
            // XOF
            [
                'currency' => 'XOF',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => true,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>false,
                'is_mobile_money'=>true,
                'mobile_money_providers'=>null,
            ],
            // ZAR
            [
                'currency' => 'ZAR',
                'requires_account_bank' => true,
                'requires_account_number' => true,
                'requires_destination_branch_code' => false,
                'is_international' => false,
                'meta' => null,
                'is_bank'=>true,
                'is_mobile_money'=>false,
                'mobile_money_providers'=>null,
            ],
        ];

        // Add timestamps
        $now = Carbon::now();

        foreach ($currencies as &$currency) {
            $currency['created_at'] = $now;
            $currency['updated_at'] = $now;
        }

        // Insert into the database
        DB::table('payout_currencies')->insert($currencies);
    }
}
