<?php

namespace App\Http\Controllers\Api;

use App\Billing;
use App\Http\Controllers\Controller;
use App\Jobs\BillingJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Psy\Util\Json;

class BillingController extends Controller
{
    /**
     *
     * @return Json
     * This method sends the billing request to the BillingJob
     * and then returns a string response to the user
     * while the task is dispatched ater 10 minutes
     */
    public function billAccount(){
            // call the job
           BillingJob::dispatch()
               ->onConnection('database')
               ->delay(now()->addSecond(10));



           return response()
               ->json('Billing request Status Notification was send to your Email', 200);
    }
}
