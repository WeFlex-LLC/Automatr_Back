<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function listAll (){
        $tags = Tag::all();
        return view('tag.list')->with('tags', $tags);
    }

    public function editTag (Request $request){
        $tags = Tag::find($request->id);

        return view('tag.form')->with('tags',$tags);
    }

    public function updateTag (Request $request){
        $tags = Tag::find($request->id);

        $tags->name = $request->name;

        $tags->save();
        return redirect('admin/tag/list');
    }

    public function addTag (Request $request){
        $tags = new Tag;

        $tags->name = $request->name;

        $tags->save();
        return redirect('admin/tag/list');
    }

    public function deleteTag (Request $request){
        $tags = Tag::find($request->id);

        $tags->delete();
        return redirect('admin/tag/list');
    }
}
