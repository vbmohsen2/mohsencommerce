<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeTemplate;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $template1 = AttributeTemplate::create(['name' => 'قالب مشخصات گوشی']);
        $template2 = AttributeTemplate::create(['name' => 'قالب مشخصات لباس']);

        // برای گوشی
        Attribute::create([
            'attribute_template_id' => $template1->id,
            'name' => 'حافظه داخلی',
            'slug' => 'storage',
            'input_type' => 'select',
            'unit' => 'گیگابایت',
            'options' => '32,64,128,256',
            'is_filterable' => true
        ]);

        Attribute::create([
            'attribute_template_id' => $template1->id,
            'name' => 'اندازه صفحه',
            'slug' => 'screen-size',
            'input_type' => 'text',
            'unit' => 'اینچ',
            'options' => null,
            'is_filterable' => false
        ]);

        // برای لباس
        Attribute::create([
            'attribute_template_id' => $template2->id,
            'name' => 'سایز',
            'slug' => 'size',
            'input_type' => 'select',
            'unit' => null,
            'options' => 'S,M,L,XL,XXL',
            'is_filterable' => true
        ]);

        Attribute::create([
            'attribute_template_id' => $template2->id,
            'name' => 'جنس',
            'slug' => 'material',
            'input_type' => 'text',
            'unit' => null,
            'options' => null,
            'is_filterable' => false
        ]);

    }
}
