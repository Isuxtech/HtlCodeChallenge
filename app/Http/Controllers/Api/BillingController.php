<?php

namespace App\Http\Controllers\Api;

use App\Billing;
use App\Http\Controllers\Controller;
use App\Jobs\BillingJob;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function billAccount(){
            // call the job
           BillingJob::dispatch()->delay(now()->addSecond(10));

           return response()
               ->json('Billing request Status Notification was send to your Email', 200);
    }
}
