<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\blog_tag;
use App\Models\Tag;
use Faker\Core\Blood;
use Illuminate\Http\Request;
use Tinify\Source;
use Tinify\Tinify;

class BlogController extends Controller
{
    public function __construct (){
        $this->optimizer = new Tinify();
        $this->optimizer->setKey("dlPPcwgBlTrplzpCbnJgxGkyPM0561M7");
    }

    public function getAllBlogs (){
        //$auto['blog'] = Blog::with('tags')->get();
        $auto['blog'] = Blog::all();
        $auto = $this->getBlogTagsName($auto);
        $auto['count'] = $auto['blog']->count();
        $success =  $auto;

        return response()->json($success, 200);
    }

    public function getBlogTagsName ($auto){
        foreach ($auto['blog'] as $key => $blog){
            if(isset($auto['blog'][$key]['tags'])){
                $auto['blog'][$key]['tags'] = Tag::select('name')->whereIn('id',$auto['blog'][$key]['tags'])->get(); 
            }
            
        }

        return $auto;
    }

    public function getBlogByPage (Request $request) {
        $all = Blog::all();
        $auto['blog'] = Blog::offset($request->offset)->limit($request->limit)->orderBy('id', 'DESC')->get();
        $auto = $this->getBlogTagsName($auto);
        $auto['count'] = $all->count();
        $success =  $auto;

        return response()->json($success, 200);
    }

    public function getOneBlog (Request $request) {
        $blog = Blog::select('url','shortDescription','tags','thumbnail','coverPhoto','content','metaDescription','metaTitle','updated_at','read_duration')->where('url', '=',$request->url)->get();
        $lastest = Blog::select('url','shortDescription','tags','thumbnail','shortContent','read_duration')->where('url','!=',$request->url)->orderBy('id', 'desc')->take(3)->get();
        $success['blog'] = $blog;
        $success = $this->getBlogTagsName($success);
        $success['lastest'] = $lastest;
        foreach ($success['lastest'] as $key => $blog){
            if(isset($success['lastest'][$key]['tags'])){
                $success['lastest'][$key]['tags'] = Tag::select('name')->whereIn('id',$success['lastest'][$key]['tags'])->get(); 
            }
            
        }
        
        

        return response()->json($success, 200);
    }


    public function listAll (){
        $blogs = Blog::all();
        return view('blog.list')->with('blogs', $blogs);
    }
    public function addBlogView (){
        $tags = Tag::all();
        return view('blog.form', compact('tags'));
    }

    

    public function addBlog (Request $request){
        $blog = new Blog;

        $thumbnail = time().'_'.$request->thumbnail->getClientOriginalName();  
        $file = Source::fromBuffer(file_get_contents($request->file('thumbnail')->getPathname()));
        $file->toFile(public_path('images')."/".$thumbnail);

        $coverPhoto = time().'_'.$request->coverPhoto->getClientOriginalName();  
        $file = Source::fromBuffer(file_get_contents($request->file('coverPhoto')->getPathname()));
        $file->toFile(public_path('images')."/".$coverPhoto);


        $blog->shortDescription = $request->shortDescription;
        $blog->url = $request->url;
        $blog->thumbnail = "/"."images/".$thumbnail;
        $blog->coverPhoto = "/"."images/".$coverPhoto;
        $blog->content = $request->content;
        $blog->metaDescription = $request->metaDescription;
        $blog->metaTitle = $request->metaTitle;
        $blog->tags = $request->tags;
        $blog->updated_at = $request->publishDate;
        $blog->shortContent = $request->shortContent;
        $blog->read_duration = $request->read_duration;
        //$blog->blog_tag = implode(',', $request->tags);
        $blog->save();
        return redirect('admin/blog/list');
    }

    public function editBlog (Request $request){
        $blogs = Blog::find($request->id);
        $tags = Tag::all();
        return view('blog.form', compact('tags','blogs'));
    }

    public function updateBlog (Request $request){
        $blog = Blog::find($request->id);
        
        if(isset($request->thumbnail)){
            $thumbnail = time().'_'.$request->thumbnail->getClientOriginalName();  
            $file = Source::fromBuffer(file_get_contents($request->file('thumbnail')->getPathname()));
            $file->toFile(public_path('images')."/".$thumbnail);
            $blog->thumbnail = "/"."images/".$thumbnail;
        }

        if(isset($request->coverPhoto)){
            $coverPhoto = time().'_'.$request->coverPhoto->getClientOriginalName();  
            $file = Source::fromBuffer(file_get_contents($request->file('coverPhoto')->getPathname()));
            $file->toFile(public_path('images')."/".$coverPhoto);
            $blog->coverPhoto = "/"."images/".$coverPhoto;
        }

        


        $blog->shortDescription = $request->shortDescription;
        $blog->url = $request->url;
        $blog->content = $request->content;
        $blog->tags = $request->tags;
        $blog->metaDescription = $request->metaDescription;
        $blog->metaTitle = $request->metaTitle;
        $blog->shortContent = $request->shortContent;
        $blog->updated_at = $request->publishDate;
        $blog->read_duration = $request->read_duration;
        //$blog->blog_tag = implode(',', $request->tags);
        $blog->save();
        return redirect('admin/blog/list');
    }


    public function deleteBlog (Request $request){
        $blog = Blog::find($request->id);

        $blog->delete();
        return redirect('admin/blog/list');
    }

    public function searchBlog (Request $request){
        $names = Blog::select('shortDescription')->get();
        $tags = Tag::select('id')->where('name','LIKE','%'.$request->searchKey.'%')->groupBy('id')->get();
        $blog = Blog::select('id','url','shortDescription','thumbnail','updated_at','tags','shortContent')->where('content','LIKE','%'.$request->searchKey.'%','or',)->orWhere('shortDescription','LIKE','%'.$request->searchKey.'%')->orWhere(function($query) use($tags){
            foreach($tags as $tag){
                $query->orwhereJsonContains('tags',strval($tag->id));
            }
           

        })->groupBy('id')->get();
        $data = Blog::select('id','url','shortDescription','thumbnail','updated_at','tags','shortContent','read_duration')->where('content','LIKE','%'.$request->searchKey.'%','or',)->orWhere('shortDescription','LIKE','%'.$request->searchKey.'%')->orWhere(function($query) use($tags){
            foreach($tags as $tag){
                $query->orwhereJsonContains('tags',strval($tag->id));
            }
           

        })->groupBy('id')
        ->offset($request->offset)->limit('6')
        ->orderBy('updated_at','DESC')
        ->get();
        $success['blog'] = $data;
        $success['blogAutoComplite'] = $names;
        $success = $this->getBlogTagsName($success);
        $success['count'] = $blog->count();
        return response()->json($success, 200);
    }
}
