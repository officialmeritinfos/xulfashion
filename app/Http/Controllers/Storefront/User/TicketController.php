<?php

namespace App\Http\Controllers\Storefront\User;

use App\Http\Controllers\BaseController;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;

class TicketController extends BaseController
{
    use Helpers,Themes;
    //landing page
    public function landingPage(Request $request,$subdomain)
    {
        $web = GeneralSetting::find(1);
        echo "Redirecting...";
        return redirect()->to($web->ticketHelpDesk);
    }
    //new ticket page
    public function newTicket(Request $request,$subdomain)
    {
        $web = GeneralSetting::find(1);
        echo "Redirecting...";
        return redirect()->to($web->ticketHelpDesk);
    }
}
