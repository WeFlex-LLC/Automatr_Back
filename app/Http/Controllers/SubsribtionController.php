<?php

namespace App\Http\Controllers;

use App\Models\subsribtion;
use Illuminate\Http\Request;
use Validator;

class SubsribtionController extends Controller
{
    public function addSub (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subsribtions'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $sub = new subsribtion;

        $sub->email = $request->email;

        $sub->save();

        return response()->json(['success' => 'Email successfuli added'], 200);
    }
}
