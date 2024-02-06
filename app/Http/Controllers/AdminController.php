<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listAll (){
        $admins = Admin::all();
        //return View::make('automation.list')->with('autos', $auto);
        return view('admin.list')->with('admins', $admins);
    }

    public function addAdmin (Request $request){
        $admin = new Admin;

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);

        $admin->save();
        return redirect('admin/manage/list');
    }

    public function editAdmin (Request $request){

        $admins = Admin::find($request->id);
        return view('admin.form', compact('admins'));

    }

    public function updateAdmin (Request $request){

        $admin = Admin::find($request->id);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);

        $admin->save();
        return redirect('admin/manage/list');

    }

    public function deleteAdmin (Request $request){
        $admin = Admin::find($request->id);

        $admin->delete();
        return redirect('admin/manage/list');

    }
}
