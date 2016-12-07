<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\uploadedFile;

use App\Http\Requests;
use Carbon\Carbon;
use DB;

use App\Category;
use App\Subcategory;
use App\Tag;
use App\User;
use App\Post;


class PostController extends Controller
{
  private $user;

  public function __construct(){
    //$this->user = Auth::user();
  }
  public function addPost(){
    $categories = Category::get();
    $tags = Tag::get();
    return view('posts.add',compact('categories','tags'));
  }

  public function storePost(Request $request){

    $this->validate($request,[
			'title' => 'required|min:10|max:150',
			'body' => 'required|min:50',
			'photo' => 'required|mimes:jpeg,bmp,png|max:2000',
			'cover' => 'required|mimes:jpeg,bmp,png|max:2000',
			'category' => 'required',
			'tags' => 'required|min:1|max:5'
		]);

    $title = $request->input('title');
    $body = $request->input('body');
    $subcategory_id = $request->input('category');
    $tags = $request->tags;
    $category_id = Subcategory::where('id',$subcategory_id)->value('category_id');
    $deadline = str_replace('T',' ',$request->input('deadline'));

    // Photo
    $photo = $request->file('photo');
    $targetLocation = base_path().'/public/assets/postPhotos/';
    $targetName=microtime(true)*10000 . '.' . $photo->getClientOriginalExtension();
    $photo->move($targetLocation, $targetName);
    $photoPath = '/assets/postPhotos/'.$targetName;

    Post::create([
			'title' => $title,
			'body' => $body,
      'deadline' => $deadline,
      'company_id' => 1,
      'image' => $photoPath,
      'category_id' => $category_id,
      'subcategory_id' => $subcategory_id,
      'published' => 1,
			]);

    // Tags
    $lastPostID = Post::orderBy('id', 'desc')->first()->id;
    foreach($tags as $tag){
      DB::table('post_tag')->insert([
        'post_id' => $lastPostID,
        'tag_id' => $tag,
        'created_at' => Carbon::now(),
      ]);
    }

  }
}
