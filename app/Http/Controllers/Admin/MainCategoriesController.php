<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

         $categories = Category::parent()->orderBy('id','DESC') ->simplePaginate(PAGINATION_Count);
        return view('admin.categories.index', compact('categories'));
         // هاي طريقة ال scope
        //يعني بروح بعرف ميثود من نوع scope بتعملي ال query اللي بدي ياها في model الخاص فيها
        // او ممكن نستخدم هاي الطريق بدلا من طريقة scope
        //Category::whereNull('parent_id') -> paginate(PAGINATION_Count);
        //whereNull equal to where(attriubte, null)
        // ال PAGINAtION_Count متغير ثابت انا عرفته في ملف helpr->general.php عشان اقدر استخدمه في اي مكان بدي ياه
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =   Category::select('id','parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MainCategoryRequest $request)
    {
        //Validation
        //Addition
        try {
            DB::beginTransaction();

            // اول شي عشان احنا مش حاطين ال قصة active في request اللي عملناه, بدنا نعمل هاي الميثود
            if (!$request->has('is_active')) // if request doesn't has is_active (is_active == 0)
                $request->request->add(['is_active' => 0]); // make and add is_active == 0 to request
            else // if request has is_active (is_active == 1)
                $request->request->add(['is_active' => 1]);// make and add is_active == 1 to request
            $category = Category::create($request -> except('_token'));// هاي لو عملت return request راح تظهر معي وانا م بدي اضيفها للداتابيز

            $category -> name = $request -> name ; // هاي عشانها في جدول الترجمة بنعملها لحالها لاني كنت بتعامل مع الجدول الاصلي
            $category->save();
            DB::commit();
            return redirect()->route('main-categories.index')->with(['success' => 'تم ألاضافة بنجاح']);

        }catch (\Exception $exception){
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
         $category = Category::find($id); //
        if (!$category)
            return redirect() -> route('main-categories.index') ->with(['error' => 'العرض غير موجود']);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MainCategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $category = Category::find($id);
            if (!$category) { // الافضل دايما اني افحص ولو ما كان موجود يطعلي error عشان أمن الموقع
                return redirect()->route('main-categories.index')->with(['error' => 'هذا القسم غير موجود']);
            }
            // اول شي عشان احنا مش حاطين ال قصة active في request اللي عملناه, بدنا نعمل هاي الميثود
            if (!$request->has('is_active')) // if request doesn't has is_active (is_active == 0)
                $request->request->add(['is_active' => 0]); // make and add is_active == 0 to request
            else // if request has is_active (is_active == 1)
                $request->request->add(['is_active' => 1]);// make and add is_active == 1 to request
            $category -> update($request->all());


            $category -> name = $request -> name ; // هاي عشانها في جدول الترجمة بنعملها لحالها لاني كنت بتعامل مع الجدول الاصلي
            $category->save();
            DB::commit();
            return redirect()->route('main-categories.index')->with(['success' => __('admin/alerts.updated successfully')]);

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
    public function destroy($id)
    {
        //check if category is present

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('main-categories.index')->with(['error' => __('admin/alerts.Not Found')]);

            //if exists

            $category->delete();

            return redirect()->route('main-categories.index')->with(['success' => __('admin/alerts.deleted successfully')]);

        } catch (\Exception $ex) {
            return redirect()->route('main-categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
