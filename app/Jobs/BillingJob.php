<?php

namespace App\Jobs;

use App\Billing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BillingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $max_user_per_bill = 10;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Billing::notBilled()->get()->chunk($this->max_user_per_bill, function($billing_info){
            $requestBody = array();

            $billing_info->each( function($user) use (&$requestBody){
                $requestBody[] =
                    [
                        'username' => $user->username,
                        'amount_to_bill' => $user->amount_to_bill
                    ];
            });

            // call the thirdParty api
            /*
             * THIS IS A MOCK OF THE API CALL
             *
             * BillIngApiServer::billUser($requestBody);
             */


            // update the billing table to show which account was has been billed
            $billing_info->update(
                [
                    'billed' => 1,
                    'bill_date' => now()
                ]
            );
        });
    }
}
