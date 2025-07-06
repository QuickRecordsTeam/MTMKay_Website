<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\search;

class BlogCommentsController extends Controller
{
   public function createComment(Request $request)
   {
       $blog_id = $request['id'];
       $validation = Validator::make($request->all(), [
           'name' => 'required|string|max:60|min:5|max:255',
           'email' => 'required|email|string|lowercase|max:255',
           'subject' => 'required|string|max:500|min:10',
           'message' => 'required|string|max:1000|min:50'
       ]);

       if($validation->fails()){
           return redirect()->back()->withErrors($validation)->withInput();
       }

       BlogComments::create([
           'blog_id' => $blog_id,
           'name' => $request['name'],
           'email' => $request['email'],
           'subject' => $request['subject'],
           'message' => $request['message']
       ]);

       return redirect()->back()->with(['success' => "Comments sent successfully! Pending Approval"]);
   }


   public function destroyComment(Request $request)
   {
       $slug = $request['slug'];

       $comment = BlogComments::where('slug', $slug)->firstOrFail();

       $comment->delete();

       return redirect()->back()->with(['status' => 'Comment remove successfully']);
   }

   public function addComment(Request $request)
   {
       $slug = $request['slug'];
       $blog = Blog::where('slug', $slug)->first();
       $this->saveComment($request, $blog->id);

       return redirect()->back()->with(['status' =>'Comment added successfully']);
   }

   private function saveComment(Request $request, $blog_id)
   {
       $validData = $request->validate([
           'name' => 'required|string|max:60|min:5|max:255',
           'email' => 'required|email|string|lowercase|max:255',
           'subject' => 'required|string|max:500|min:10',
           'message' => 'required|string|max:1000|min:50'
       ]);

       BlogComments::create([
           'blog_id' => $blog_id,
           'name' => $validData['name'],
           'email' => $validData['email'],
           'subject' => $validData['subject'],
           'message' => $validData['message']
       ]);
   }

    public function showBlogComments(Request $request)
    {
        $slug = $request['slug'];
        $blog = Blog::where('slug', $slug)->first();
        $filter = $request['filter'];
        $sort = $request['sort'];
        $search = $request['search'];
        $comments = $blog->blogComments();

        if(isset($filter) && $filter !== "ALL"){
            $comments = $comments->where('status', $filter);
        }
        if(isset($sort) && $sort !== "ALL"){
            $comments = $blog->blogComments();
            switch ($sort) {
                case 'DATE_ASC':
                    $comments->orderBy('created_at');
                    break;
                case 'NAME':
                    $comments->orderBy('name');
                    break;
                default:
                    $comments->orderByDesc('created_at');
                    break;
            }
        }
        if(isset($search)){
            $comments->where('name', 'LIKE', '%'.$search.'%')
                     ->orWhere('email', 'LIKE', '%'.$search.'%')
                     ->orWhere('subject', 'LIKE', '%'.$search.'%');
        }

        $comments = $comments->paginate(10);

        $data = [
            'comments' => $comments,
            'blog'     => $blog
        ];

        return view ('pages.management.blog.comments')->with($data);
    }


    public function updateCommentStatus(Request $request)
    {
        $status = $request['status'];
        $slug = $request['slug'];
        $comment = BlogComments::where('slug', $slug)->first();

        $comment->update([
            'status' => $status
        ]);

        return redirect()->back()->with(['status' => 'Blog Status updated successfully']);
    }

}
