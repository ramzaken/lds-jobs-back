<?php
namespace App\Http\Controllers\Skill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use Validator;
use Config;
use Exception;

class SkillController extends Controller
{
    public function search(Request $request){
        $result     =   Skill::where('name', 'LIKE', '%'.$request['search'].'%')->get();
        return response()->json($result);
    }
}