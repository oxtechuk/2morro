<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Skill;
use App\Models\Need;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@2morro.com'],
            [
                'name' => 'إدارة تمورو',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Seed Categories
        $categories = [
            ['name' => 'الأدوات التعليمية', 'slug' => 'educational-tools', 'description' => 'أدوات وألعاب تعليمية ملموسة تطور مهارات طفلك الحركية والإدراكية.'],
            ['name' => 'الشيتات الرقمية', 'slug' => 'digital-worksheets', 'description' => 'ملفات PDF جاهزة للتحميل الفوري والطباعة المنزلية لتدريب طفلك.'],
            ['name' => 'الباقات المنزلية', 'slug' => 'educational-bundles', 'description' => 'باقات متكاملة تجمع بين الأدوات المادية والملفات الرقمية لتحقيق مهارة معينة.'],
            ['name' => 'الكورسات', 'slug' => 'courses', 'description' => 'دورات ومواد تدريبية مسجلة وتفاعلية لأولياء الأمور والأخصائيين.'],
            ['name' => 'الجلسات والخدمات', 'slug' => 'sessions', 'description' => 'حجز جلسات استشارية وعلاجية مباشرة مع أخصائيي المركز.'],
        ];
        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Seed Age Groups
        $ages = [
            ['name' => 'من 2 إلى 3 سنوات', 'slug' => '2-3', 'min_age' => 2, 'max_age' => 3],
            ['name' => 'من 4 إلى 5 سنوات', 'slug' => '4-5', 'min_age' => 4, 'max_age' => 5],
            ['name' => 'من 6 إلى 8 سنوات', 'slug' => '6-8', 'min_age' => 6, 'max_age' => 8],
            ['name' => 'من 9 إلى 12 سنة', 'slug' => '9-12', 'min_age' => 9, 'max_age' => 12],
        ];
        $ageModels = [];
        foreach ($ages as $age) {
            $ageModels[$age['slug']] = AgeGroup::updateOrCreate(['slug' => $age['slug']], $age);
        }

        // 4. Seed Skills
        $skills = [
            ['name' => 'تنمية اللغة والنطق', 'slug' => 'language-development', 'description' => 'مهارات التحدث، الاستماع، الفهم، وتركيب الجمل.'],
            ['name' => 'التركيز والانتباه', 'slug' => 'attention-focus', 'description' => 'زيادة وقت الانتباه، تحسين الذاكرة البصرية والسمعية.'],
            ['name' => 'صعوبات التعلم والأكاديمي', 'slug' => 'learning-difficulties', 'description' => 'التهيئة للكتابة، القراءة، مبادئ الرياضيات والتأسيس.'],
            ['name' => 'تعديل السلوك والمهارات الاجتماعية', 'slug' => 'social-skills', 'description' => 'التفاعل الاجتماعي، التعبير عن المشاعر، وضبط النفس.'],
        ];
        $skillModels = [];
        foreach ($skills as $skill) {
            $skillModels[$skill['slug']] = Skill::updateOrCreate(['slug' => $skill['slug']], $skill);
        }

        // 5. Seed Needs
        $needs = [
            ['name' => 'تأخر الكلام', 'slug' => 'speech-delay', 'description' => 'أنشطة وأدوات مخصصة للأطفال الذين يعانون من تأخر نطق الكلمات.'],
            ['name' => 'التوحد (Autism)', 'slug' => 'autism', 'description' => 'دعم تفاعلي وحسي للأطفال ذوي طيف التوحد لتطوير التواصل.'],
            ['name' => 'فرط الحركة وتشتت الانتباه', 'slug' => 'adhd', 'description' => 'أدوات تساعد على الهدوء والتركيز وتفريغ الطاقة بشكل إيجابي.'],
            ['name' => 'ضعف المهارات الحركية الدقيقة', 'slug' => 'fine-motor', 'description' => 'تقوية عضلات اليدين للتحضير للكتابة ومسك القلم.'],
        ];
        $needModels = [];
        foreach ($needs as $need) {
            $needModels[$need['slug']] = Need::updateOrCreate(['slug' => $need['slug']], $need);
        }

        // 6. Seed Sample Products
        // Product 1: Physical Tool
        $p1 = Product::updateOrCreate(
            ['slug' => 'speech-cards-box'],
            [
                'name' => 'صندوق كروت التخاطب وتطوير الجمل',
                'description' => 'صندوق متكامل يحتوي على 150 كرتاً تعليمياً عالي الجودة مقسمة لمجموعات لتطوير مهارة التعبير وتركيب جملة من كلمتين أو ثلاث كلمات. الصندوق يأتي مع دليل ارشادي للأم لتسهيل استخدامه في المنزل.',
                'short_description' => 'صندوق كروت تعليمية تفاعلية لتطوير التعبير اللغوي لدى الأطفال من عمر سنتين فما فوق.',
                'price' => 250.00,
                'sale_price' => 199.00,
                'sku' => 'PHY-SCB-01',
                'type' => 'physical',
                'stock' => 50,
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'benefits' => ['زيادة الحصيلة اللغوية', 'التعبير بجمل صحيحة', 'تحسين النطق مخارج الحروف'],
                'how_to_use' => ['اجلسي مع طفلك في مكان هادئ', 'اعرضي الكرت واسأليه: ماذا يفعل الولد؟', 'شجعيه على محاكاة النطق وتكرار الكلمة'],
                'whats_included' => '150 كرت مغلف، دليل استخدام ورقي، علبة تخزين كرتونية متينة.',
                'suitable_for' => 'الأطفال من سن 2-6 سنوات الذين يعانون من تأخر لغوي، الأخصائيين وأمهات الأطفال في مرحلة التدريب المنزلي.',
                'badge' => 'الأكثر مبيعاً',
                'images' => ['products/sample-cards.jpg'],
                'is_active' => true,
            ]
        );
        $p1->categories()->sync([$categoryModels['educational-tools']->id]);
        $p1->ageGroups()->sync([$ageModels['2-3']->id, $ageModels['4-5']->id]);
        $p1->skills()->sync([$skillModels['language-development']->id]);
        $p1->needs()->sync([$needModels['speech-delay']->id, $needModels['autism']->id]);

        // Product 2: Digital Worksheet
        $p2 = Product::updateOrCreate(
            ['slug' => 'arabic-letters-worksheet'],
            [
                'name' => 'كتاب تدريبات الحروف العربية الرقمي (PDF)',
                'description' => 'ملف رقمي يحتوي على 60 صفحة مليئة بالأنشطة والتلوين وكتابة الحروف العربية لتهيئة الطفل لمسك القلم والتعرف على شكل الحرف وصوته. الملف متاح للتحميل والطباعة الفورية بعد تأكيد الدفع.',
                'short_description' => 'شيت أنشطة كتابية وتلوين لتعليم الحروف العربية للأطفال جاهز للطباعة.',
                'price' => 75.00,
                'sale_price' => 45.00,
                'sku' => 'DIG-ALW-02',
                'type' => 'digital',
                'stock' => 9999,
                'digital_file_path' => 'private_downloads/sample_worksheet.pdf',
                'digital_file_name' => 'arabic_letters_worksheet.pdf',
                'digital_download_limit' => 5,
                'digital_expiry_days' => 30,
                'benefits' => ['التعرف على كتابة الحروف العربية', 'تقوية عضلات اليد والتحضير للكتابة', 'التمييز البصري بين أشكال الحروف'],
                'how_to_use' => ['حملي الملف فوراً بعد الدفع', 'اطبعي الصفحات على ورق A4', 'دعي الطفل يستخدم ألوان الخشب والرصاص للحل'],
                'whats_included' => 'ملف PDF يحتوي على 60 صفحة أنشطة بدقة عالية.',
                'suitable_for' => 'الأطفال من سن 4-6 سنوات (مرحلة التأسيس والحضانة).',
                'badge' => 'تحميل فوري',
                'images' => ['products/sample-pdf.jpg'],
                'is_active' => true,
            ]
        );
        $p2->categories()->sync([$categoryModels['digital-worksheets']->id]);
        $p2->ageGroups()->sync([$ageModels['4-5']->id, $ageModels['6-8']->id]);
        $p2->skills()->sync([$skillModels['learning-difficulties']->id]);
        $p2->needs()->sync([$needModels['fine-motor']->id]);

        // Product 3: Bundle (Physical + Digital)
        $p3 = Product::updateOrCreate(
            ['slug' => 'language-starter-bundle'],
            [
                'name' => 'باقة التخاطب والنطق المنزلية الأولى',
                'description' => 'باقة متكاملة مميزة تجمع بين صندوق كروت التخاطب المادي والملف الرقمي لتدريبات الحروف العربية مع فيديو تعليمي حصري يشرح طريقة التطبيق العملي خطوة بخطوة في المنزل. الباقة تضمن توفير 25% من سعر شراء المنتجات منفردة.',
                'short_description' => 'الباقة الشاملة لبدء التخاطب وتطوير التعبير واللغة للطفل بالمنزل بسعر مخفض.',
                'price' => 325.00,
                'sale_price' => 220.00,
                'sku' => 'BND-LSB-03',
                'type' => 'physical', // Marked as physical because it contains a physical box that requires shipping
                'stock' => 30,
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'benefits' => ['حل شامل للتأخر اللغوي', 'يجمع بين اللعب الملموس والكتابة والتدريبات', 'توفير مالي كبير مع توجيه أخصائي'],
                'how_to_use' => ['استخدمي صندوق الكروت يومياً لمدة 15 دقيقة', 'اطبعي الشيت المرفق لتدريب اليد على الكتابة بالتوازي', 'شاهدي الفيديو المرفق للحصول على نصائح التطبيق'],
                'whats_included' => 'صندوق كروت التخاطب المادي + كتاب تدريبات الحروف (نسخة رقمية ترسل للبريد) + فيديو الشرح العملي.',
                'suitable_for' => 'الآباء الباحثين عن برنامج متكامل ومنظم لتدريب الطفل في المنزل.',
                'badge' => 'باقة توفير',
                'images' => ['products/sample-bundle.jpg'],
                'is_active' => true,
            ]
        );
        $p3->categories()->sync([$categoryModels['educational-bundles']->id]);
        $p3->ageGroups()->sync([$ageModels['2-3']->id, $ageModels['4-5']->id]);
        $p3->skills()->sync([$skillModels['language-development']->id, $skillModels['learning-difficulties']->id]);
        $p3->needs()->sync([$needModels['speech-delay']->id, $needModels['fine-motor']->id]);
        // Define Bundle Products relationship (P3 contains P1 and P2)
        $p3->products()->sync([
            $p1->id => ['quantity' => 1],
            $p2->id => ['quantity' => 1],
        ]);

        // 7. Seed Sample Customers and CRM Profiles
        $customersData = [
            [
                'name' => 'أحمد علي حسن',
                'email' => 'ahmed.ali@example.com',
                'password' => Hash::make('password123'),
                'segment' => 'specialist',
                'notes' => 'أخصائي تخاطب، يهتم بشراء كروت التخاطب بالكميات لحسابه الخاص وعيادته.',
                'phone' => '01012345678',
                'governorate' => 'القاهرة',
                'city' => 'مصر الجديدة',
                'address' => '12 شارع الميرغني، مصر الجديدة',
            ],
            [
                'name' => 'منى أحمد المحلاوي',
                'email' => 'mona.ahmed@example.com',
                'password' => Hash::make('password123'),
                'segment' => 'parent',
                'notes' => 'أم لطفل بعمر 4 سنوات يعاني من تأخر لغوي بسيط وتشتت انتباه.',
                'phone' => '01234567890',
                'governorate' => 'الجيزة',
                'city' => 'الدقي',
                'address' => '5 شارع التحرير، الدقي',
            ],
            [
                'name' => 'حضانة أطفال الغد (أ/ ياسمين)',
                'email' => 'tomorrow.nursery@example.com',
                'password' => Hash::make('password123'),
                'segment' => 'nursery',
                'notes' => 'حضانة متكاملة تطلب باقات الشيتات والكتب لتوزيعها على الفصول.',
                'phone' => '01511223344',
                'governorate' => 'الإسكندرية',
                'city' => 'سموحة',
                'address' => 'بناية الرواد، سموحة، الإسكندرية',
            ],
            [
                'name' => 'مدرسة الأمل لذوي الاحتياجات',
                'email' => 'hope.school@example.com',
                'password' => Hash::make('password123'),
                'segment' => 'school',
                'notes' => 'جهة حكومية/مؤسسة خيرية تشتري الأدوات والباقات بتمويل وتطلب فواتير ضريبية.',
                'phone' => '01122334455',
                'governorate' => 'المنصورة',
                'city' => 'المنصورة',
                'address' => 'شارع الجلاء، بجوار بنك مصر، المنصورة',
            ]
        ];

        foreach ($customersData as $cData) {
            $user = User::updateOrCreate(
                ['email' => $cData['email']],
                [
                    'name' => $cData['name'],
                    'password' => $cData['password'],
                ]
            );

            // Create profile
            $profile = \App\Models\CustomerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'segment' => $cData['segment'],
                    'admin_notes' => $cData['notes'],
                    'loyalty_points' => rand(50, 500),
                    'last_contacted_at' => now()->subDays(rand(1, 10)),
                ]
            );

            // Create mock order
            $orderNumber = 'ORD-' . strtoupper(Str::random(8));
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $cData['phone'],
                'shipping_address' => $cData['address'],
                'shipping_governorate' => $cData['governorate'],
                'shipping_city' => $cData['city'],
                'shipping_fee' => 40.00,
                'subtotal' => 199.00,
                'discount_total' => 0.00,
                'total' => 239.00,
                'payment_method' => rand(0, 1) ? 'cod' : 'paymob',
                'payment_status' => 'paid',
                'status' => 'delivered',
                'notes' => 'طلب تجريبي من لوحة التحكم',
            ]);

            // Add item
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p1->id,
                'product_name' => $p1->name,
                'quantity' => 1,
                'price' => 199.00,
                'type' => $p1->type ?? 'physical',
            ]);

            // If specialist or nursery, add digital download worksheet as well
            if (in_array($cData['segment'], ['specialist', 'nursery'])) {
                $digitalOrderNumber = 'ORD-' . strtoupper(Str::random(8));
                $dOrder = \App\Models\Order::create([
                    'user_id' => $user->id,
                    'order_number' => $digitalOrderNumber,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $cData['phone'],
                    'shipping_address' => 'رقمي - تحميل فوري',
                    'shipping_governorate' => $cData['governorate'],
                    'shipping_city' => $cData['city'],
                    'shipping_fee' => 0.00,
                    'subtotal' => 45.00,
                    'discount_total' => 0.00,
                    'total' => 45.00,
                    'payment_method' => 'paymob',
                    'payment_status' => 'paid',
                    'status' => 'delivered',
                    'notes' => 'شراء شيت رقمي',
                ]);

                \App\Models\OrderItem::create([
                    'order_id' => $dOrder->id,
                    'product_id' => $p2->id,
                    'product_name' => $p2->name,
                    'quantity' => 1,
                    'price' => 45.00,
                    'type' => $p2->type ?? 'digital',
                ]);

                // Create download link token
                \App\Models\Download::create([
                    'order_id' => $dOrder->id,
                    'user_id' => $user->id,
                    'product_id' => $p2->id,
                    'token' => Str::random(32),
                    'download_count' => rand(0, 3),
                    'max_downloads' => 5,
                    'expires_at' => now()->addDays(30),
                ]);
            }

            // Create CRM Logs
            \App\Models\CrmLog::create([
                'user_id' => $user->id,
                'admin_id' => $admin->id,
                'type' => 'note',
                'details' => 'تم إنشاء الحساب التلقائي وتفعيل الملف الشخصي الخاص بالـ CRM للعميل.',
            ]);

            if ($cData['segment'] === 'specialist') {
                \App\Models\CrmLog::create([
                    'user_id' => $user->id,
                    'admin_id' => $admin->id,
                    'type' => 'call',
                    'details' => 'تم الاتصال بالعميل لتأكيد بيانات الشحن وعرض خصم الكميات المخصص للأخصائيين (20% للطلبات فوق 5 قطع). العميل أبدى اهتماماً كبيراً.',
                ]);
            } elseif ($cData['segment'] === 'parent') {
                \App\Models\CrmLog::create([
                    'user_id' => $user->id,
                    'admin_id' => $admin->id,
                    'type' => 'whatsapp',
                    'details' => 'أرسلت الأم استفساراً عبر الواتساب تسأل عن السن المناسب لكروت التخاطب وعن مدى فعاليتها مع طفل متأخر في الكلام. تم الرد وإرسال مقال المركز ودليل الاستخدام.',
                ]);
            }
        }
    }
}
