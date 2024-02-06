<?php

namespace App\Http\Controllers;

use App\Models\package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //

    public function addPackage (Request $request){
        $package = new package;

        $package->name = $request->name;
        $package->timeLimit = $request->timeLimit;
        $package->autoLimit = $request->autoLimit;

        $package->save();
        return redirect('admin/package/list');
    }

    public function editPackage (Request $request){
        $packages = package::find($request->id);

        return view('package.form', compact('packages'));

    }

    public function updatePackage (Request $request){
        $package = package::find($request->id);

        $package->name = $request->name;
        $package->timeLimit = $request->timeLimit;
        $package->autoLimit = $request->autoLimit;

        $package->save();

        return redirect('admin/package/list');

    }

    public function deletePackage (Request $request){
        $package = package::find($request->id);
        $package->delete();

        return redirect('admin/package/list');

    }

    public function listAll (){
        $packages = package::all();

        return view('package.list')->with('packages', $packages);

    }
}
