<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DoctorVideo;
use App\Models\Product;
use App\Models\Need;
use App\Models\AgeGroup;

class DoctorVideoSeeder extends Seeder
{
    public function run(): void
    {
        if (DoctorVideo::count() > 0) {
            return;
        }

        $speechNeed = Need::where('name', 'like', '%تأخر%')->first();
        $adhdNeed   = Need::where('name', 'like', '%فرط%')->first();
        $autismNeed = Need::where('name', 'like', '%توحد%')->first();
        $motorNeed  = Need::where('name', 'like', '%حركية%')->first();

        $age23 = AgeGroup::where('name', 'like', '%2%')->first();
        $age45 = AgeGroup::where('name', 'like', '%4%')->first();
        $age68 = AgeGroup::where('name', 'like', '%6%')->first();

        $products = Product::where('is_active', true)->take(4)->get();

        // 1. Reel: تأخر الكلام
        $reel1 = DoctorVideo::create([
            'title'           => 'علامات تأخر الكلام عند سن سنتين: متى نقلق وكيف نبدأ؟',
            'description'     => "في هذا المقطع السريع، نوضح أهم 3 مؤشرات إذا لاحظتها على طفلك في عمر السنتين تعني ضرورة بدء تمارين النطق فوراً، مع تمرين بسيط يومي لمدة 10 دقائق في المنزل باستخدام كروت التخاطب.",
            'video_type'      => 'reel',
            'video_source'    => 'youtube',
            'video_path'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail'       => null,
            'duration'        => '0:58',
            'need_id'         => $speechNeed?->id,
            'age_group_id'    => $age23?->id,
            'is_paid'         => false,
            'price'           => 0,
            'views_count'     => 1420,
            'is_published'    => true,
        ]);
        if ($products->isNotEmpty()) {
            $reel1->products()->sync([$products[0]->id, $products[2]->id ?? $products[0]->id]);
        }

        // 2. Reel: فرط الحركة
        $reel2 = DoctorVideo::create([
            'title'           => 'تمرين سريع لتفريغ طاقة طفل فرط الحركة وتشتت الانتباه قبل النوم',
            'description'     => "حركة بسيطة بالأطراف والضغط العضلي المهدئ تساعد الطفل على تفريغ الشحنات الحركية الزائدة والدخول في نوم هادئ بدون نوبات غضب أو مقاومة للنوم.",
            'video_type'      => 'reel',
            'video_source'    => 'youtube',
            'video_path'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail'       => null,
            'duration'        => '0:45',
            'need_id'         => $adhdNeed?->id,
            'age_group_id'    => $age45?->id,
            'is_paid'         => false,
            'price'           => 0,
            'views_count'     => 2180,
            'is_published'    => true,
        ]);

        // 3. Standard Paid Masterclass: خطة النطق والتخاطب
        $paidVideo1 = DoctorVideo::create([
            'title'           => 'خطة تدريب النطق والتخاطب المنزلي الشاملة لعمر 2 إلى 3 سنوات (جلسة تطبيقية)',
            'description'     => "جلسة استرشادية تطبيقية متكاملة مدتها 35 دقيقة تشرح لأولياء الأمور استراتيجيات التخاطب الاحترافية المعتمدة في مركز تمورو:\n1. تقييم حصيلة الكلمات والفهم السمعي.\n2. تقنيات التكرار التعزيزي وإطالة الكلمة لتكوين جملة من كلمتين.\n3. ألعاب التخاطب وكيفية استخدام كروت التدريب اليومية.\n4. جدول متابعة أسبوعي للتطور اللغوي في المنزل.",
            'video_type'      => 'standard',
            'video_source'    => 'youtube',
            'video_path'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail'       => null,
            'duration'        => '35:20',
            'need_id'         => $speechNeed?->id,
            'age_group_id'    => $age23?->id,
            'is_paid'         => true,
            'price'           => 65.00,
            'preview_seconds' => 45,
            'views_count'     => 850,
            'is_published'    => true,
        ]);
        if ($products->count() >= 2) {
            $paidVideo1->products()->sync([$products[0]->id, $products[1]->id, $products[2]->id ?? $products[0]->id]);
        }

        // 4. Standard Free: التوحد والألعاب الحسية
        $freeVideo2 = DoctorVideo::create([
            'title'           => 'كيفية تحفيز التواصل البصري والتركيز لطفل التوحد من خلال الألعاب الحسية',
            'description'     => "شرح تفصيلي لطرق جذب انتباه الطفل ذو طيف التوحد، والتقليل من التشتت الحسي، مع استعراض أمثلة عملية للألعاب الحسية والأنشطة اليومية الهادفة.",
            'video_type'      => 'standard',
            'video_source'    => 'youtube',
            'video_path'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail'       => null,
            'duration'        => '18:45',
            'need_id'         => $autismNeed?->id,
            'age_group_id'    => $age45?->id,
            'is_paid'         => false,
            'price'           => 0,
            'views_count'     => 3420,
            'is_published'    => true,
        ]);
        if ($products->isNotEmpty()) {
            $freeVideo2->products()->sync([$products[0]->id]);
        }

        // 5. Standard Paid: تعديل السلوك والعناد
        $paidVideo2 = DoctorVideo::create([
            'title'           => 'برنامج تعديل السلوك المنزلي: علاج العناد المفرط ونوبات الغضب عند سن المدرسة',
            'description'     => "دليل الأهل الشامل للتعامل مع العناد الشديد وفرط الحركة بدون صراخ أو عقاب سلبي. يتضمن نظام التعزيز الإيجابي وجداول المكافآت السلوكية المعتمدة.",
            'video_type'      => 'standard',
            'video_source'    => 'youtube',
            'video_path'      => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'thumbnail'       => null,
            'duration'        => '28:10',
            'need_id'         => $adhdNeed?->id,
            'age_group_id'    => $age68?->id,
            'is_paid'         => true,
            'price'           => 85.00,
            'preview_seconds' => 60,
            'views_count'     => 1290,
            'is_published'    => true,
        ]);
    }
}

