<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_Count);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        DB::beginTransaction();
        //validation

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        $fileName = "";
        if ($request->has('photo')) {

            $fileName = uploadImage('brands', $request->photo); // ال brands هو اسم المجلد اللي راح يتم تخزين الصور فيه حسب م عملت في ملف filesystems الموجود فيه مجلد config
            // يعني روح ع ملف filesystems وبتفهم كل شي
        }
        $brand = Brand::create($request->except('_token', 'photo'));
        //save translations
        $brand->name = $request->name;
        $brand->photo = $fileName;

        $brand->save();
        DB::commit();
        return redirect()->route('brands.index')->with(['success' => 'تم ألاضافة بنجاح']);


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
    public function edit($brand) //هان حطيت brand بدل id لانه لما اعمل php artisan route list راح الاحظ انه في هاد الراوت
        //راح الاحظ انه في هاد الروت مستخدم كلمة brand بدلا من id عشان عملت ترقيىة للاصدار التامن انا ف هيك هو طريقته فلازم استخدمها هان زي مهي موجودة في الراوت
    {
        $brands = Brand::find($brand);
        if (!$brands)
            return redirect() -> route('brands.index') ->with(['error' => 'الماركة غير موجود']);

        return view('admin.brands.edit', compact('brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BrandRequest $request, $brand)
    {
        try {
            DB::beginTransaction();
            $brands = Brand::find($brand);
            if (!$brands)
                return redirect() -> route('brands.index') -> with(['error' => 'الماركة غير موجود']);

            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
                Brand::where('id', $brand)
                    ->update([
                        'photo' => $fileName,
                    ]);
            }
            // اول شي عشان احنا مش حاطين ال قصة active في request اللي عملناه, بدنا نعمل هاي الميثود
            if (!$request->has('is_active')) // if request doesn't has is_active (is_active == 0)
                $request->request->add(['is_active' => 0]); // make and add is_active == 0 to request
            else // if request has is_active (is_active == 1)
                $request->request->add(['is_active' => 1]);// make and add is_active == 1 to request

            $brands->update($request->except('_token', 'id', 'photo'));
            // هان استثنيت ال 'id', 'photo' لانه id مش راح يتغير و photo عملتها فوق
            $brands -> name = $request -> name ; // هاي عشانها في جدول الترجمة بنعملها لحالها لاني كنت بتعامل مع الجدول الاصلي
            $brands->save();
            DB::commit();
            return redirect()->route('brands.index')->with(['success' => __('admin/alerts.updated successfully')]);

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
    public function destroy($brand)
    {
        try {
            $brands = Brand::find($brand);
            if (!$brands)
                return redirect()->route('brands.index')->with(['error' => 'الماركة غير موجود']);
            $brands -> delete();
            return redirect()->route('brands.index')->with(['success' => __('admin/alerts.deleted successfully')]);
        }catch (\Exception $exception){
            return redirect()->route('brands.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }
}
