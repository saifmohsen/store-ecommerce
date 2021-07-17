<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
       $tags = Tag::orderBy('id','desc')->paginate(PAGINATION_Count);
       return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagsRequest $request)
    {

                DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $tags =Tag::create($request -> except('_token'));
            $tags -> name = $request-> name;
            $tags->save();
            DB::commit();
            return redirect()->route('tags.index')->with(['success' => 'تم ألاضافة بنجاح']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($tag)
    {
        $tags = Tag::find($tag);
        if (!$tags)
            return redirect()-> route('tags.index') ->with(['error' => 'العلامة غير موجودة']);
        return view('admin.tags.edit', compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $tag)
    {
        try {
            DB::beginTransaction();
            $tags = Tag::find($tag);
            if (!$tags)
                return redirect()-> route('tags.index') ->with(['error' => 'العلامة غير موجودة']);
            $tags->update($request->except('_token', 'id'));
            $tags->name = $request->name;
            $tags->save();
            DB::commit();
            return redirect()->route('tags.index')->with(['success' => __('admin/alerts.updated successfully')]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['errors' => 'there is a problem, please try again later']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($tag)
    {
        $tags = Tag::find($tag);
        if (!$tags)
            return redirect()-> route('tags.index') ->with(['error' => 'العلامة غير موجودة']);
        $tags->delete();
        return redirect()->route('tags.index')->with(['success' => __('admin/alerts.deleted successfully')]);
    }
}
