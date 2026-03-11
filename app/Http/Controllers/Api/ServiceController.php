<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Traits\ApiResponse;

class ServiceController extends Controller
{
    use ApiResponse;
    public function index()
    {   
        $service = Service::all();
        return $this->success($service, 'Services Fetched Successfully');
    }

    public function show($id)
    {   
        $service = Service::find($id);
        if($service){
            return $this->success($service, 'Get the service successfully');
        }
        return $this->error('Service Not Found', 404);
    }
}
