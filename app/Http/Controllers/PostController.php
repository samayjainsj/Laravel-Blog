<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\Tag;

use App\Category;

use Session;

use Purifier;

use Image;

use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all(); without pagination
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        //validate the data
        $this->validate($request,array(
        'title'=>'required|max:255',
        'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
        'category_id' => 'required|integer',
        'body'=>'required',
        'featured_image' => 'sometimes|image'
        ));
        //store in data base
        $post = new Post;
        $post->title=$request->title;
        $post->slug=$request->slug;
        $post->category_id=$request->category_id;
        $post->body=Purifier::clean($request->body);
        //image save in database
        if ($request->hasFile('featured_image')) {
          $image = $request->file('featured_image');
          $filename = time() . '.' . $image->getClientOriginalExtension();
          $location = public_path('images/'. $filename);
          Image::make($image)->resize(800,400)->save($location);

          $post->image = $filename;
        }
        $post->save();

        $post->tags()->sync($request->tags);

        $request->Session()->flash('success','The blog post was successfully save!');

        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $cats = []; //this is array
        foreach ($categories as $category) {
          $cats[$category->id]=$category->name;
        }
        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }
        return view('posts.edit')->withPost($post)->withCategories($cats)->withTags($tags2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // dd($request);
      //validate the data
      $post = Post::find($id);

        $this->validate($request,array(
        'title'=>'required|max:255',
        'category_id'=>'required|integer',
        'slug'=>"required|alpha_dash|min:5|max:255|unique:posts,slug,$id",
        'body'=>'required',
        'featured_image' => 'image'
        ));

      //store in data base
      $post = Post::find($id);
      $post->title = $request->input('title');
      $post->slug = $request->input('slug');
      $post->category_id = $request->input('category_id');
      $post->body = Purifier::clean($request->input('body'));

      if ($request->hasFile('featured_image')) {
        $image = $request->file('featured_image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $location = public_path('images/'. $filename);
        Image::make($image)->resize(800,400)->save($location);
        $oldFileName = $post->image;

        $post->image = $filename;

        Storage::delete($oldFileName);
      }


      $post->save();

      if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync(array());
        }

      $request->Session()->flash('success','The blog post was successfully save!');

      return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $post = Post::find($id);
       Storage::delete($post->image);
       $post->delete();

       Session()->flash('success','The blog post was successfully deleted!');

       return redirect()->route('posts.index',$post->id);
    }
}
