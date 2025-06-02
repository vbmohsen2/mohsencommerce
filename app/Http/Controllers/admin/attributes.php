<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeTemplate;
use Illuminate\Http\Request;

class attributes extends Controller
{
    public function index()
    {
        $attributesTemplate = AttributeTemplate::withCount('attributes')->paginate(20);
        return view('admin.attributes',compact('attributesTemplate'));
    }
    public function store(Request $request)
    {
        // دریافت داده از طریق GET
        $name = $request->query('name');

        // اعتبارسنجی ورودی
        if (!$name) {
            return redirect()->back()->withErrors('نام قالب الزامی است.');
        }

        // ایجاد قالب جدید
        AttributeTemplate::create([
            'name' => $name,
        ]);

        // بازگشت به صفحه قبلی با پیام موفقیت
        return redirect()->back()->with('success', 'قالب با موفقیت اضافه شد.');
    }

    public function showAttribute($id)
    {
        $attribute = Attribute::where("attribute_template_id",$id)->orderby("order")->get(); // یا هر منطق دیگری برای پیدا کردن ویژگی مورد نظر


            return response()->json($attribute);

    }
    public function showAttributeTemplate($id)
    {
        $attributetemplate = AttributeTemplate::find($id); // یا هر منطق دیگری برای پیدا کردن ویژگی مورد نظر

        if ($attributetemplate) {
            return response()->json($attributetemplate);
        } else {
            return response()->json(['message' => 'ویژگی یافت نشد'], 404);
        }
    }


    public function edit(AttributeTemplate $template)
    {

        return view('admin.attributesEdit', compact('template'));
    }
    public function deleteAttribute(Request $request)
    {
        $data = $request->input('data');
//            log::info($data);
//        if (!$data || !is_array($data)) {
//            return response()->json(['message' => $data], 400);
//        }
        try {


            $attribute=Attribute::find($data);

            if (!$attribute) {
                return response()->json(['message' => "مشخصه پیدا نشد"]);
            }


            if(!$attribute->delete($data)){
                return response()->json(['message' => 'مشخصه محصول پیدا نشد']);
            }
            return response()->json(['message' => 'دسته بندی حذف شد']);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'این مشخصه  قابل حذف شدن نیست
            ', 'error' => $e->getMessage()], 303);
        }
    }
    public function deletetemplate(Request $request)
    {
        $template = AttributeTemplate::findOrFail($request->id);

        $template->delete();

        return redirect()->back()->with('success', 'قالب با موفقیت حذف شد.');


    }
    public function attributesreorder(Request $request)
    {
        // دریافت داده‌های ارسالی
        $data = $request->input('data');
//        Log::info('Parsed data:', $data);


        if (!$data || !is_array($data)) {
            return response()->json(['message' => $data], 400);
        }

        try {
            // برای هر دسته‌بندی در داده‌ها، ترتیب جدید را ذخیره می‌کنیم
            foreach ($data as $index => $attribute) {

//                return response()->json(['message' => Category::find($category['id'])]);
                // برای هر دسته‌بندی، ترتیب جدیدش رو ذخیره می‌کنیم
                    $attributemodal = Attribute::where('id',$attribute['id'])->where("attribute_template_id",$attribute['attribute_template_id'])->first();

                // اگر دسته‌بندی پیدا نشد، به خطا می‌خوریم
                if (!$attributemodal) {
                    $attributemodal = new Attribute();
//                    $attributemodal->id=$attribute['id'];
                    $attributemodal->attribute_template_id=$attribute['attribute_template_id'];
//                    return response()->json(['message' => 'دسته‌بندی یافت نشد: ' . $attributemodal], 404);
                }

                // بروزرسانی ترتیب (index)

                $attributemodal->name = $attribute['name'];
                $attributemodal->order = $attribute['order'];
                $attributemodal->slug = $attribute['slug'];
                $attributemodal->input_type = $attribute['input_type'];
                $attributemodal->unit = $attribute['unit'];
                $attributemodal->options = $attribute['options'];
//                return response()->json(['message' => $categoryModel]);


                // ذخیره تغییرات در دیتابیس
                $result= $attributemodal->save();
//                return response()->json(['message' => $result]);


            }

            return response()->json(['message' => 'ترتیب دسته‌بندی‌ها با موفقیت ذخیره شد']);
        } catch (\Exception $e) {
            // اگر خطایی اتفاق افتاد، پیام خطا برمی‌گردانیم
            return response()->json(['message' => 'خطا در ذخیره ترتیب', 'error' => $e->getMessage()], 500);
        }
    }
}
