<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/images/';
    // The image folder will be created automatically during runtime.

    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function index() {
        $all_posts = $this->post->latest()->get();
        return view('posts.index')->with('all_posts', $all_posts);
        // posts -> folder name
        // index -> file name
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {

        // 1. Validate the request
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]); // mime -> multipurpose internet mail extensions

        // 2. Save the form data to the db
        $this->post->user_id = Auth::user()->id; // Assign the logged in users ID
        // Auth -> current user who is logged in

        $this->post->body = $request->body;
        $this->post->image = $this->saveImage($request);
        $this->post->title =  $request->title;
        $this->post->save();

        // 3. Back to homepage
        return redirect()->route('index');
    }

    private function saveImage($request) {
        // Change the name of the image to CURRENT TIME to avoid overwriting.
        $image_name = time().".".$request->image->extension();
        // originale image name -> image.jpg
        // converted name -> 11019281.jpg

        // Save the image inside the storage/app/public/images
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    public function show($id) {
        // $id is the ID of the post to be retrieved
        $post = $this->post->findOrFail($id);
        return view('posts.show')->with('post', $post);
    }

    public function edit($id) {
        $post = $this->post->findOrFail($id);

        if($post->user->id != Auth::user()->id) {
            return redirect()->back();
        }

        return view('posts.edit')->with('post', $post);
        // posts -> folder name
        // edit -> file name
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        $post = $this->post->findOrFail($id);

        // Update the post properties from the request
        $post->title = $request->title; // assigning for a new value
        $post->body =  $request->body;

        # If there is a new image...
        if($request->image) {
            # Delete the previous image from the local storage
            $this->deleteImage($post->image);

            # Move the new image to the local storage
            $post->image = $this->saveImage($request);
        }

        $post->save();

        return redirect()->route('post.show', $id);
        // If the post was been updated successfully redirect to the show blade
    }

    private function deleteImage($image_name) {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;
        // $image_path = "/public/images/1632278.jpg"

        if(Storage::disk('local')->exists($image_path)) {
            Storage::disk('local')->delete($image_path);
        }
    }

    public function destroy($id) {
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);
        // $this->deleteImage(162534.jpg)

        $this->post->destroy($id);
        // $post->delete();

        return redirect()->back();
    }


}
