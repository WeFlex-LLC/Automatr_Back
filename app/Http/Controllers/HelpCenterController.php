<?php

namespace App\Http\Controllers;

use App\Models\HelpCenter;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function getAllHs () {
        $auto = HelpCenter::all();
        $success =  $auto;

        return response()->json($success, 200);
    }
    public function listAll () {
        $hs = HelpCenter::all();
        return view('helpcenter.list')->with('ffqs',$hs);
    }

    public function addHs (Request $request) {
        $hs = new HelpCenter;

        $hs->question = $request->question;
        $hs->answer = $request->answer;

        $hs->save();

        return redirect('admin/helpCenter/list');
    }

    public function editHs (Request $request){
        $hs = HelpCenter::find($request->id);

        return view('helpcenter.form')->with('ffqs',$hs);
    }

    public function updateHs (Request $request){
        $hs = HelpCenter::find($request->id);

        $hs->question = $request->question;
        $hs->answer = $request->answer;

        $hs->save();

        return redirect('admin/helpCenter/list');
    }

    public function deleteHs (Request $request){
        $hs = HelpCenter::find($request->id);

        $hs->delete();
        return redirect('admin/helpCenter/list');
    }


}
