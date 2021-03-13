<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC') ->simplePaginate(PAGINATION_Count);
        return view('admin.categories.subCategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::parent()->get();
        return view('admin.categories.subCategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request)
    {
        try {
                DB::beginTransaction();
                if (!$request->has('is_active'))
                    $request->request->add(['is_active' => 0]);
                else
                    $request->request->add(['is_active' => 1]);

               $category = Category::create($request -> except('_token'));
               $category -> name = $request -> name;
               $category -> save();
               DB::commit();
               return redirect()->route('sub-categories.index')->with(['success' => 'تم ألاضافة بنجاح']);
        }catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['errors' => 'there is a problem, please try again later']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function show($id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //check if category is exist or not
        $category = Category::find($id); //هاد بس عشان يتأكد أنه موجود وطبعا بخزنه في هاد المتغير
        if (!$category)
            return redirect()->route('sub-categories.index')->with(['error'=>'القسم غير موجود']);

       $categories = Category::parent()->get(); // هان رجعت كل ال main-category
        return view('admin.categories.subCategories.edit',compact('categories','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            $category -> update($request -> all());
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('sub-categories.index')->with(['success' => 'Updated Successfully']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['errors' => 'there is a problem, please try again later']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //check if category is present

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('sub-categories.index')->with(['error' => __('admin/alerts.Not Found')]);

            //if exists

            $category->delete();

            return redirect()->route('sub-categories.index')->with(['success' => __('admin/alerts.deleted successfully')]);

        } catch (\Exception $ex) {
            return redirect()->route('sub-categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
