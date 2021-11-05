<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:show-comments')->only(['index','unapproved']);
        $this->middleware('can:edit-comment')->only(['edit','updateComment']);
        $this->middleware('can:approve-comment')->only(['update']);
        $this->middleware('can:delete-comment')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::whereApprove(1)->latest()->paginate(20);
        return view('admin.comments.approved',compact('comments'));
    }

    public function unapproved()
    {
        $comments = Comment::whereApprove(0)->paginate(20);
        return view('admin.comments.unapproved',compact('comments'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('admin.comments.edit',compact('comment'));
    }

    public function updateComment(Request $request,Comment $comment)
    {
        $data = $request->validate([
            'comment' => 'required'
        ]);

        $comment->update($data);
        alert()->success('نظر با موفقیت ویرایش شد');
        return redirect(route('admin.comments.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update([
            'approve' => 1
        ]);
        alert()->success('نظر با موفقیت تایید شد');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('نظر با موفقیت حذف شد');
        return back();
    }
}
