<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    //

    public function listAll (){
        $types = Type::all();
        return view('type.list')->with('types', $types);
    }

    public function editType (Request $request){
        $types = Type::find($request->id);

        return view('type.form')->with('types',$types);
    }

    public function updateType (Request $request){
        $types = Type::find($request->id);

        $types->name = $request->name;

        $types->save();
        return redirect('admin/type/list');
    }

    public function addType (Request $request){
        $types = new Type;

        $types->name = $request->name;

        $types->save();
        return redirect('admin/type/list');
    }

    public function deleteType (Request $request){
        $types = Type::find($request->id);

        $types->delete();
        return redirect('admin/type/list');
    }
}
