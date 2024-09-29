<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
class BlogController extends Controller
{
    // List all blog posts
    public function index()
    {
        try{
            $query = Blog::query();

            //Search Functionality (Search by title or content)
            if ($request->has('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                      ->orWhere('content', 'like', "%$search%");
                });
            }
             //Tag-Based Filtering (Filter by specific tags)
             if ($request->has('tags')) {
                $tags = $request->get('tags');
                $query->whereJsonContains('tags', $tags);
            }
    
            //Sorting Functionality (Sort by title, created_at, etc.)
            if ($request->has('sort_by')) {
                $sortBy = $request->get('sort_by');
                $sortOrder = $request->get('sort_order', 'asc');
                if (in_array($sortBy, ['title', 'created_at'])) {
                    $query->orderBy($sortBy, $sortOrder);
                }
            }
            $blogs = $query->paginate(10);
            return response()->json($blogs);

        }catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
    }

    // Store a new blog post (only for Author and Admin)
    public function store(Request $request)
    {
         //Validate request data
         $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'tags'    => 'required|array'
        ]);

        // If validation fails, throw a ValidationException
        if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->errors()],422);
        }
        try{
            $blog = Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'tags' => json_encode($request->tags),
                'author_id' => Auth::id(),
            ]);
    
            return response()->json($blog, 201);

        }catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }

    }

    // Update a blog post (only for Author and Admin)
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        // Allow update only if the user is the author or an admin
        if (Auth::id() != $blog->author_id && !Auth::user()->hasRole('Admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        try{
            
            $blog->update($request->all());

            return response()->json('Blog updated successfully');

        }catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
    }

    // Delete a blog post (only for Admin)
    public function destroy($id)
    {
        try{
            $blog = Blog::findOrFail($id);
            $blog->delete();
    
            return response()->json('Blog deleted successfully');

        }catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
    }
}
