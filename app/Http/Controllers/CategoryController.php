<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Automations;
use Tinify\Source;
use Tinify\Tinify;


class CategoryController extends Controller
{

    public function __construct (){
        $this->optimizer = new Tinify();
        $this->optimizer->setKey("dlPPcwgBlTrplzpCbnJgxGkyPM0561M7");
    }
    //
    public function getAllCategories (){
        $category = Category::select('id','name','url','icon','icon2','icon3','metaDescription','metaTitle')->get();
        $success =  $category;

        return response()->json($success, 200);
    }
    public function getAllActive (){
        $category = Category::with(["automations.automationType","automations" => function($q){
            $q->where('status', '=', 1);
        }])->get();

        return response()->json($category, 200);
    }

    public function getAllAutosHome () {
        $user = Category::select('id', 'name', 'icon2','url')->with(['automations' => function ($query) {
            $query->select('category_id','id', 'name','shortDescription','url');
            $query->orderBy('id','DESC');
        }])->limit(5)->get()->each(function($q){
            $q->limitRelationship('automations', 8);
        });
        $success =  $user;

        return response()->json($success, 200);
    }
    public function getAllAutosHomeMobile () {
        $user = Category::select('id','icon2','url')->with(['automations' => function ($query) {
            $query->select('category_id','id', 'name','shortDescription','url');
            $query->orderBy('id','DESC');
        }])->limit(8)->get()->each(function($q){
            $q->limitRelationship('automations', 1);
        });
        $success =  $user;

        return response()->json($success, 200);
    }

    public function listAll (){
        $categories = Category::with(['automations','automations.automationType'])->get();
        return view('category.list')->with('categories', $categories);
    }

    public function addCat (Request $request){

        $category = new Category;

        $iconName = time().'.'.$request->icon->getClientOriginalName();
        $file = Source::fromBuffer(file_get_contents($request->file('icon')->getPathname()));
        $file->toFile(public_path('images')."/".$iconName);

        $iconName2 = time().'.'.$request->icon2->getClientOriginalName();
        $file = Source::fromBuffer(file_get_contents($request->file('icon2')->getPathname()));
        $file->toFile(public_path('images')."/".$iconName2);

        $iconName3 = time().'.'.$request->icon3->getClientOriginalName();
        $file = Source::fromBuffer(file_get_contents($request->file('icon3')->getPathname()));
        $file->toFile(public_path('images')."/".$iconName3);


        $category->name = $request->name;
        $category->url = $request->url;
        $category->metaDescription = $request->metaDescription;
        $category->metaTitle = $request->metaTitle;
        $category->icon = "/"."images/".$iconName;
        $category->icon2 = "/"."images/".$iconName2;
        $category->icon3 = "/"."images/".$iconName3;
        $category->related = $request->related;
        $category->save();
        return redirect('admin/category/list');
    }

    public function editCat (Request $request) {
        $categories = Category::find($request->id);
        $related = Automations::all();
        return view('category.form', compact('categories','related'));
    }

    public function addCatView (){
        $related = Automations::all();
        return view('category.form', compact('related'));
    }

    public function updateCat (Request $request){
        $category = Category::find($request->id);

        if(isset($request->icon)){
            $iconName = time().'.'.$request->icon->getClientOriginalName();  
            $file = Source::fromBuffer(file_get_contents($request->file('icon')->getPathname()));
            $file->toFile(public_path('images')."/".$iconName);
            $category->icon = "/"."images/".$iconName;
        }
        if(isset($request->icon2)){
            $iconName2 = time().'.'.$request->icon2->getClientOriginalName();  
            $file = Source::fromBuffer(file_get_contents($request->file('icon2')->getPathname()));
            $file->toFile(public_path('images')."/".$iconName2);
            $category->icon2 = "/"."images/".$iconName2;
        }

        if(isset($request->icon3)){
            $iconName3 = time().'.'.$request->icon3->getClientOriginalName();  
            $file = Source::fromBuffer(file_get_contents($request->file('icon3')->getPathname()));
            $file->toFile(public_path('images')."/".$iconName3);
            $category->icon3 = "/"."images/".$iconName3;
        }

        $category->name = $request->name;
        $category->metaDescription = $request->metaDescription;
        $category->metaTitle = $request->metaTitle;
        $category->url = $request->url;
        $category->related = $request->related;

        $category->save();
        return redirect('admin/category/list');

    }

    public function deleteCat (Request $request){
        $auto = Category::find($request->id);

        $auto->delete();
        return redirect('admin/category/list');
    }

}
