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
     *
     * The handle gets all the records marked as not billed ( value of 0),
     *   chunks the records to 5 (can be increased if desired) and calls an anonymous function
     *     function that loops through the collection and adds the "username and amount_to_bill"
     *       to the requestBody Array which is send to the Api for billing
     */
    public function handle()
    {
           Billing::notBilled()->chunk(5, function(Collection $billing_info) {
            // at this line billing_info is a collection.
            // And the Eloquent/Collection does not have update method
            $requestBody = [];

            $billing_info->each( function($user) use (&$requestBody){
                $requestBody[] =
                    [
                        'username' => $user->username,
                        'amount_to_bill' => $user->amount_to_bill
                    ];
            });


            /**
             * call the thirdParty api
             * THIS IS A MOCK OF THE API CALL
             *
             * BillIngApiServer::billUser($requestBody);
             */


               /**
                * Loops through the collection and updates the Billing table to show with
                * record was send for billing assuming that all send records will be
                * billed successfully
                */
            // update the billing table to show which account was has been billed
            $billing_info->each(function(Billing $billing) {
                $billing->update([
                        'billed' => 1,
                        'bill_date' => now()
                    ]);
            });

        });
    }
}
