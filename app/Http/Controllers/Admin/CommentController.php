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
        $comments = Comment::query();

        if($keyword = \request('search')){
            $comments->where('comment','LIKE',"%{$keyword}%")->orWhereHas('user',function ($query) use($keyword){
                $query->where('name','LIKE',"%{$keyword}%");
            });
        }

        $comments = $comments->where('approve',1)->latest()->paginate(20);
        return view('admin.comments.approved',compact('comments'));
    }

    public function unapproved()
    {
        $comments = Comment::query();

        if($keyword = \request('search')){
            $comments->where('comment','LIKE',"%{$keyword}%")->orWhereHas('user',function ($query) use($keyword){
                $query->where('name','LIKE',"%{$keyword}%");
            });
        }

        $comments = $comments->where('approve',0)->paginate(20);
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
        alert()->success('?????? ???? ???????????? ???????????? ????');
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
        alert()->success('?????? ???? ???????????? ?????????? ????');
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
        alert()->success('?????? ???? ???????????? ?????? ????');
        return back();
    }
}
