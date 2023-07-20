<?php
namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Validator;
use Config;
use Exception;

class JobController extends Controller
{
    public function fetch(){
        $result     =   Job::get();
        return response()->json($result);
    }

}