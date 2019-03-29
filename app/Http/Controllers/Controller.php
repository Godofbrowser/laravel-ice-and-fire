<?php

namespace App\Http\Controllers;

use App\Concerns\SendsXhrResponse;
use App\Concerns\ValidatesXhrRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests,
		DispatchesJobs,
		ValidatesRequests,
		ValidatesXhrRequests,
		SendsXhrResponse;
}
