<?php

namespace App\Http\Controllers;

use App\Models\package_users;
use Illuminate\Http\Request;

class PackageUsersController extends Controller
{
    public function addPackage (Request $request) {
        $pu = new package_users;

        $pu->user_id = $request->user_id;
        $pu->package_id = $request->package_id;
        $pu->valid = 1;
        $pu->usedTime = 0;
        $pu->usedAutom = 0;
    }
    public function makeValidPackage (Request $request){
        $pu = package_users::find($request->id);

    }

    public function checkPackage (Request $request){
        $pu = package_users::with(['package'])->where('user_id','=',$request->user()->id)->get();
        return response()->json($pu, 200);
    }

    public function listAll (){
        $package_users = package_users::with(['package_users','package'])->get();
        //return response()->json($package_users[0]->package_users->email);
        return view('userPackage.list')->with('package_users', $package_users);
    }
}
