<?php

namespace App\Http\Controllers\Mobile\User\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettlementAccountProcessorController extends Controller
{
    //process local settlement account - where currency is not USD, GBP or EUR
    public function processLocalSettlementAccount(Request $request)
    {

    }
}
