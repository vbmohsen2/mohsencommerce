<?php

namespace Database\Seeders;

use App\Models\AttributeTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $phoneTemplate = AttributeTemplate::where('name', 'قالب مشخصات گوشی')->first();
        $clothingTemplate = AttributeTemplate::where('name', 'قالب مشخصات لباس')->first();

        // دسته‌بندی‌های اصلی
        $electronics = Category::create([
            'name' => 'الکترونیک',
            'slug' => 'electronics',
            'description' => 'محصولات الکترونیکی',
            'parent_id' => null,
            'order' => 1,
            'is_active' => true,
            'attribute_template_id' => $phoneTemplate->id
        ]);

        $clothing = Category::create([
            'name' => 'پوشاک',
            'slug' => 'clothing',
            'description' => 'انواع پوشاک مردانه و زنانه',
            'parent_id' => null,
            'order' => 2,
            'is_active' => true,
            'attribute_template_id' => $clothingTemplate->id
        ]);

        $home = Category::create([
            'name' => 'خانه و آشپزخانه',
            'slug' => 'home-kitchen',
            'description' => 'وسایل منزل و آشپزخانه',
            'parent_id' => null,
            'order' => 3,
            'is_active' => true,
            'attribute_template_id' => null
        ]);

        $sports = Category::create([
            'name' => 'ورزش و سفر',
            'slug' => 'sports-travel',
            'description' => 'تجهیزات ورزشی و مسافرتی',
            'parent_id' => null,
            'order' => 4,
            'is_active' => true,
            'attribute_template_id' => null
        ]);

        // زیر دسته‌ها (حدود 16 زیرمجموعه برای تکمیل 20 تایی)
        $subcategories = [
            ['name' => 'گوشی موبایل', 'slug' => 'mobile-phones', 'parent_id' => $electronics->id],
            ['name' => 'لپ‌تاپ', 'slug' => 'laptops', 'parent_id' => $electronics->id],
            ['name' => 'دوربین', 'slug' => 'cameras', 'parent_id' => $electronics->id],
            ['name' => 'تلویزیون', 'slug' => 'tv', 'parent_id' => $electronics->id],

            ['name' => 'مردانه', 'slug' => 'men', 'parent_id' => $clothing->id],
            ['name' => 'زنانه', 'slug' => 'women', 'parent_id' => $clothing->id],
            ['name' => 'بچگانه', 'slug' => 'kids', 'parent_id' => $clothing->id],
            ['name' => 'اکسسوری', 'slug' => 'accessories', 'parent_id' => $clothing->id],

            ['name' => 'لوازم آشپزخانه', 'slug' => 'kitchen-tools', 'parent_id' => $home->id],
            ['name' => 'مبلمان', 'slug' => 'furniture', 'parent_id' => $home->id],
            ['name' => 'دکوراسیون', 'slug' => 'decor', 'parent_id' => $home->id],
            ['name' => 'نورپردازی', 'slug' => 'lighting', 'parent_id' => $home->id],

            ['name' => 'تناسب اندام', 'slug' => 'fitness', 'parent_id' => $sports->id],
            ['name' => 'کوهنوردی', 'slug' => 'hiking', 'parent_id' => $sports->id],
            ['name' => 'دوچرخه‌سواری', 'slug' => 'cycling', 'parent_id' => $sports->id],
            ['name' => 'چمدان', 'slug' => 'luggage', 'parent_id' => $sports->id],
        ];

        foreach ($subcategories as $index => $sub) {
            Category::create([
                'name' => $sub['name'],
                'slug' => $sub['slug'],
                'description' => '',
                'parent_id' => $sub['parent_id'],
                'order' => $index + 1,
                'is_active' => true,
                'attribute_template_id' => null,
            ]);
        }
    }
}
