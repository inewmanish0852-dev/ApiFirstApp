<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Traits\ApiResponse;

class PageController extends Controller
{
    use ApiResponse;
    public function about()
    {
        $about = Page::where('slug','about')->first();
        if($about){
            return $this->success($about, 'About Fetched Successfully');
        }
        return $this->error('About Not Found', 404);
    }

    public function terms()
    {
        $terms = Page::where('slug','terms')->first();
        if($terms){
            return $this->success($terms, 'Terms Fetched Successfully');
        }
        return $this->error('Terms Not Found', 404);
    }

}
