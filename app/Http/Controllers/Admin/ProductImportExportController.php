<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Skill;
use App\Models\Need;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProductImportExportController extends Controller
{
    /**
     * Display the Import & Export Control Center
     */
    public function index()
    {
        $categories = Category::all();
        $totalProducts = Product::count();
        $physicalCount = Product::where('type', 'physical')->count();
        $digitalCount  = Product::where('type', 'digital')->count();
        $courseCount   = Product::where('type', 'course')->count();
        $sessionCount  = Product::where('type', 'session')->count();

        $stats = [
            'total'    => $totalProducts,
            'physical' => $physicalCount,
            'digital'  => $digitalCount,
            'course'   => $courseCount,
            'session'  => $sessionCount,
        ];

        return view('admin.products.import-export', compact('categories', 'stats'));
    }

    /**
     * Download Excel Sample Template
     */
    public function downloadTemplate(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        // -------------------------------------------------------------
        // Sheet 1: Products Data (Sample Rows)
        // -------------------------------------------------------------
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('المنتجات (Products)');
        $sheet->setRightToLeft(true);

        $headers = [
            'A1' => ['title' => 'معرف المنتج (ID)', 'key' => 'id', 'hint' => 'اتركه فارغاً للمنتج الجديد أو اكتب الـ ID للتعديل'],
            'B1' => ['title' => 'كود المنتج (SKU)', 'key' => 'sku', 'hint' => 'كود فريد مميز مثل PRD-001'],
            'C1' => ['title' => 'اسم المنتج*', 'key' => 'name', 'hint' => 'اسم المنتج بالعربية (إجباري)'],
            'D1' => ['title' => 'نوع المنتج*', 'key' => 'type', 'hint' => 'physical أو digital أو course أو session'],
            'E1' => ['title' => 'السعر الأساسي*', 'key' => 'price', 'hint' => 'رقم موجب مثل 150.00'],
            'F1' => ['title' => 'سعر التخفيض', 'key' => 'sale_price', 'hint' => 'سعر العرض (أقل من الأساسي) أو فارغ'],
            'G1' => ['title' => 'المخزون*', 'key' => 'stock', 'hint' => 'الكمية المتوفرة (أرقام صحيحة)'],
            'H1' => ['title' => 'الشارة (Badge)', 'key' => 'badge', 'hint' => 'new, bestseller, discount, download أو فارغ'],
            'I1' => ['title' => 'البراند / الماركة', 'key' => 'brand', 'hint' => 'اسم البراند، مثل: EduPlay'],
            'J1' => ['title' => 'التصنيفات', 'key' => 'categories', 'hint' => 'افصل بين أكثر من تصنيف بفاصلة (,)'],
            'K1' => ['title' => 'الفئات العمرية', 'key' => 'age_groups', 'hint' => 'افصل بين أكثر من فئة بفاصلة (,) مثل: 3-5 سنوات, 6-8 سنوات'],
            'L1' => ['title' => 'المهارات المستهدفة', 'key' => 'skills', 'hint' => 'افصل بفواصل مثل: التركيز, المهارات الحركية'],
            'M1' => ['title' => 'الاحتياجات الخاصة', 'key' => 'needs', 'hint' => 'افصل بفواصل مثل: فرط الحركة, صعوبات التعلم'],
            'N1' => ['title' => 'وصف مختصر', 'key' => 'short_description', 'hint' => 'سطر ملخص للمنتج'],
            'O1' => ['title' => 'الوصف الكامل', 'key' => 'description', 'hint' => 'تفاصيل المنتج ومميزاته'],
            'P1' => ['title' => 'رابط الصورة (Image URL)', 'key' => 'image_url', 'hint' => 'رابط مباشر لصورة المنتج https://...'],
            'Q1' => ['title' => 'رابط الفيديو (Video URL)', 'key' => 'video_url', 'hint' => 'رابط يوتيوب أو فيديو توضيحي'],
            'R1' => ['title' => 'ماذا يتضمن', 'key' => 'whats_included', 'hint' => 'محتويات الصندوق أو الباقة'],
            'S1' => ['title' => 'مناسب لـ', 'key' => 'suitable_for', 'hint' => 'الفئة المستهدفة'],
            'T1' => ['title' => 'الحالة (نشط؟)*', 'key' => 'is_active', 'hint' => '1 للمنتج النشط الظاهر، 0 للمعطل'],
        ];

        // Format Headers
        $colIndex = 1;
        foreach ($headers as $cell => $meta) {
            $sheet->setCellValue($cell, $meta['title']);
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
            $colIndex++;
        }

        // Header Styling
        $headerRange = 'A1:T1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0D9488'); // Teal Brand color
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Add 3 Sample Rows
        $samples = [
            [
                '', 'PHY-BLOCKS-01', 'مكعبات تنمية الذكاء الخشبية', 'physical', 180.00, 149.00, 35, 'bestseller',
                'EduPlay', 'ألعاب خشبية, أدوات حسية', '3-5 سنوات, 6-8 سنوات', 'التركيز والانتباه, المهارات الحركية الدقيقة', 'فرط الحركة وتشتت الانتباه',
                'مجموعة مكعبات خشبية هندسية عالية الجودة لتطوير الذكاء المكاني',
                'تحتوي هذه المجموعة على 50 قطعة ملونة ومصنوعة من خشب طبيعي آمن تماماً للأطفال، تساعد على تعزيز الإبداع والتناسق البصري الحركي.',
                'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=600',
                'https://www.youtube.com/watch?v=sample1',
                '50 قطعة خشبية + كتيّب نماذج + حقيبة قماشية للتخزين', 'الأطفال من عمر 3 سنوات فما فوق والمراكز التعليمية', 1
            ],
            [
                '', 'DIG-WORKSHEET-02', 'كراسة أنشطة تنمية التركيز والذاكرة (PDF)', 'digital', 45.00, null, 999, 'download',
                '2morro Academy', 'ملفات رقمية وأوراق عمل', '4-6 سنوات', 'الذاكرة العاملة, معالجة المعلومات', 'صعوبات التعلم, تشتت الانتباه',
                'ملف رقمي جاهز للطباعة يحتوي على 30 نشاطاً تدريبياً للأطفال',
                'دليل متكامل للأنشطة البصرية والذهنية لزيادة زمن الانتباه وتقوية الذاكرة، مخصص للاستخدام المنزلي وغرف المصادر.',
                'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600',
                '',
                'ملف PDF عالي الجودة يحتوي على 30 صفحة ملونة مع مفتاح الحلول', 'أولياء الأمور والمعلمين وأخصائيي تعديل السلوك', 1
            ],
            [
                '', 'SES-CONSULT-01', 'جلسة استشارية فردية لتقييم المهارات', 'session', 250.00, 200.00, 10, 'new',
                'عيادة تمورو التخصصية', 'استشارات وجلسات', 'جميع الأعمار', 'التواصل والتفاعل الاجتماعي', 'التأخر النمائي',
                'جلسة أونلاين لمدة 45 دقيقة مع أخصائي نمو وتطور الطفل',
                'تشمل الجلسة تقييماً مبدئياً للمهارات الحركية واللغوية والسلوكية للطفل، مع وضع خطة منزلية مقترحة للأهل.',
                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600',
                '',
                'جلسة مرئية 45 دقيقة + تقرير توصيات مكتوب', 'أولياء الأمور الباحثين عن تقييم تخصصي لأطفالهم', 1
            ]
        ];

        $rowNum = 2;
        foreach ($samples as $sample) {
            $sheet->fromArray($sample, null, 'A' . $rowNum);
            $sheet->getRowDimension($rowNum)->setRowHeight(22);
            $rowNum++;
        }

        // Apply grid styling to samples
        $dataRange = 'A2:T' . ($rowNum - 1);
        $sheet->getStyle($dataRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:T' . ($rowNum - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFE2E8F0'));

        // -------------------------------------------------------------
        // Sheet 2: Field Instructions & Allowed Values
        // -------------------------------------------------------------
        $guideSheet = $spreadsheet->createSheet();
        $guideSheet->setTitle('دليل الحقول والقيم المقبولة');
        $guideSheet->setRightToLeft(true);

        $guideHeaders = ['اسم العمود', 'رمز العمود بالإنجليزية', 'هل إجباري؟', 'القيم المقبولة والتفاصيل'];
        $guideSheet->fromArray($guideHeaders, null, 'A1');
        $guideSheet->getStyle('A1:D1')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $guideSheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $guideRows = [
            ['معرف المنتج', 'id', 'اختياري', 'اتركه فارغاً لإنشاء منتج جديد. إذا وضعت رقماً موجوداً سيتم تحديث المنتج.'],
            ['كود المنتج', 'sku', 'اختياري ولكن يُنصح به', 'رمز فريد للمنتج للتتبع، مثل PRD-101. يمكن استخدامه أيضاً لمطابقة وتحديث المنتجات.'],
            ['اسم المنتج', 'name', 'إجباري', 'اسم المنتج التجاري الكامل.'],
            ['نوع المنتج', 'type', 'إجباري', 'يجب أن يكون أحد القيم التالية تماماً: physical (مادي/شحن)، digital (رقمي للتحميل)، course (كورس تعليمي)، session (جلسة استشارية).'],
            ['السعر الأساسي', 'price', 'إجباري', 'السعر العادي للمنتج كرقم (مثلاً 100 أو 99.50).'],
            ['سعر التخفيض', 'sale_price', 'اختياري', 'سعر العرض الترويجي المؤقت، يجب أن يكون أقل من السعر الأساسي. اتركه فارغاً في حال عدم وجود خصم.'],
            ['المخزون', 'stock', 'إجباري', 'عدد القطع المتوفرة. للملفات الرقمية ضع رقماً كبيراً مثل 999.'],
            ['الشارة', 'badge', 'اختياري', 'شارة تسويقية مميزة تظهر على المنتج: new (جديد)، bestseller (الأكثر مبيعاً)، discount (خصم مميز)، download (تحميل مباشر).'],
            ['البراند / الماركة', 'brand', 'اختياري', 'اسم الماركة أو البراند. إذا لم تكن موجودة سيتم إنشاؤها وربطها تلقائياً.'],
            ['التصنيفات', 'categories', 'اختياري', 'أسماء التصنيفات مفصولة بفواصل (مثال: ألعاب تعليمية, أدوات حسية). سيتم ربطها أو إنشاؤها تلقائياً.'],
            ['الفئات العمرية', 'age_groups', 'اختياري', 'الفئات العمرية المناسبة مفصولة بفواصل (مثال: 0-3 سنوات, 4-6 سنوات).'],
            ['المهارات', 'skills', 'اختياري', 'المهارات المستهدفة مفصولة بفواصل (مثال: التركيز, التفكير الإبداعي).'],
            ['الاحتياجات الخاصة', 'needs', 'اختياري', 'الاحتياجات التطويرية مفصولة بفواصل (مثال: فرط الحركة, صعوبات التعلم).'],
            ['وصف مختصر', 'short_description', 'اختياري', 'وصف سريع يظهر في الكروت وصفحات المتجر.'],
            ['الوصف الكامل', 'description', 'اختياري', 'الشرح المفصل ومميزات المنتج.'],
            ['رابط الصورة', 'image_url', 'اختياري', 'رابط مباشر لصورة الغلاف على الإنترنت (JPG, PNG, WebP).'],
            ['الحالة', 'is_active', 'إجباري', '1 لظهور المنتج بالمتجر فوراً، أو 0 لحفظه كمسودة معطلة.']
        ];

        $gRow = 2;
        foreach ($guideRows as $r) {
            $guideSheet->fromArray($r, null, 'A' . $gRow);
            $gRow++;
        }

        foreach (range('A', 'D') as $col) {
            $guideSheet->getColumnDimension($col)->setAutoSize(true);
        }
        $guideSheet->getStyle('A1:D' . ($gRow - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFE2E8F0'));

        $spreadsheet->setActiveSheetIndex(0);

        $filename = '2morro_products_template_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export Products to Excel (XLSX) or CSV
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'xlsx'); // xlsx or csv

        $query = Product::query()->with(['categories', 'ageGroups', 'skills', 'needs', 'brand']);

        // Filter: Search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter: Category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Filter: Product Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('المنتجات المصدرة');
        $sheet->setRightToLeft(true);

        $headerTitles = [
            'معرف المنتج (id)',
            'كود المنتج (sku)',
            'اسم المنتج (name)',
            'نوع المنتج (type)',
            'السعر الأساسي (price)',
            'سعر التخفيض (sale_price)',
            'المخزون (stock)',
            'الشارة (badge)',
            'البراند (brand)',
            'التصنيفات (categories)',
            'الفئات العمرية (age_groups)',
            'المهارات (skills)',
            'الاحتياجات (needs)',
            'وصف مختصر (short_description)',
            'الوصف الكامل (description)',
            'رابط الصورة (image_url)',
            'رابط الفيديو (video_url)',
            'ماذا يتضمن (whats_included)',
            'مناسب لـ (suitable_for)',
            'الحالة (is_active)'
        ];

        $sheet->fromArray($headerTitles, null, 'A1');

        $rowNum = 2;
        foreach ($products as $product) {
            // Get Image representation
            $imgUrl = '';
            if (!empty($product->images) && is_array($product->images)) {
                $imgUrl = implode(', ', $product->images);
            }

            $row = [
                $product->id,
                $product->sku,
                $product->name,
                $product->type,
                $product->price,
                $product->sale_price,
                $product->stock,
                $product->badge,
                $product->brand ? $product->brand->name : '',
                $product->categories->pluck('name')->implode(', '),
                $product->ageGroups->pluck('name')->implode(', '),
                $product->skills->pluck('name')->implode(', '),
                $product->needs->pluck('name')->implode(', '),
                $product->short_description,
                $product->description,
                $imgUrl,
                $product->video_url,
                $product->whats_included,
                $product->suitable_for,
                $product->is_active ? 1 : 0
            ];

            $sheet->fromArray($row, null, 'A' . $rowNum);
            $rowNum++;
        }

        // Header Styling
        $headerRange = 'A1:T1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0F766E');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(26);

        // Auto column size
        for ($col = 1; $col <= 20; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $filename = 'products_export_' . date('Y_m_d_His');

        if ($format === 'csv') {
            $filename .= '.csv';
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            // Write UTF-8 BOM for Excel Arabic CSV compatibility
            echo "\xEF\xBB\xBF";
            $writer = new Csv($spreadsheet);
            $writer->setUseBOM(true);
            $writer->save('php://output');
            exit;
        } else {
            $filename .= '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }
    }

    /**
     * Import Products from Excel / CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv,txt|max:20480',
        ], [
            'excel_file.required' => 'يرجى اختيار ملف Excel أو CSV لرفعه.',
            'excel_file.mimes'    => 'يجب أن يكون الملف بصيغة Excel (.xlsx, .xls) أو .csv.',
            'excel_file.max'      => 'أقصى حجم مسموح للملف هو 20 ميجابايت.',
        ]);

        $file = $request->file('excel_file');
        
        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء قراءة الملف: ' . $e->getMessage());
        }

        if (count($rows) < 2) {
            return redirect()->back()->with('error', 'الملف المرفوع فارغ أو لا يحتوي على صفوف بيانات.');
        }

        // Map Header Columns
        $headerRow = array_shift($rows);
        $headerMap = $this->mapHeaders($headerRow);

        if (empty($headerMap['name'])) {
            return redirect()->back()->with('error', 'لم يتم العثور على عمود "اسم المنتج" (name) في الملف. يرجى استخدام القالب المعتمد.');
        }

        $successCount = 0;
        $updatedCount = 0;
        $errors = [];
        $currentRowIndex = 1; // 1 was header

        foreach ($rows as $row) {
            $currentRowIndex++;

            // Skip entirely blank rows
            $hasData = false;
            foreach ($row as $val) {
                if (trim((string)$val) !== '') {
                    $hasData = true;
                    break;
                }
            }
            if (!$hasData) {
                continue;
            }

            // Extract Row Values by Mapped Columns
            $name             = trim((string)($row[$headerMap['name'] ?? ''] ?? ''));
            $id               = trim((string)($row[$headerMap['id'] ?? ''] ?? ''));
            $sku              = trim((string)($row[$headerMap['sku'] ?? ''] ?? ''));
            $type             = strtolower(trim((string)($row[$headerMap['type'] ?? ''] ?? 'physical')));
            $price            = trim((string)($row[$headerMap['price'] ?? ''] ?? ''));
            $salePrice        = trim((string)($row[$headerMap['sale_price'] ?? ''] ?? ''));
            $stock            = trim((string)($row[$headerMap['stock'] ?? ''] ?? '0'));
            $badge            = trim((string)($row[$headerMap['badge'] ?? ''] ?? ''));
            $brandName        = trim((string)($row[$headerMap['brand'] ?? ''] ?? ''));
            $categoriesStr    = trim((string)($row[$headerMap['categories'] ?? ''] ?? ''));
            $ageGroupsStr     = trim((string)($row[$headerMap['age_groups'] ?? ''] ?? ''));
            $skillsStr        = trim((string)($row[$headerMap['skills'] ?? ''] ?? ''));
            $needsStr         = trim((string)($row[$headerMap['needs'] ?? ''] ?? ''));
            $shortDescription = trim((string)($row[$headerMap['short_description'] ?? ''] ?? ''));
            $description      = trim((string)($row[$headerMap['description'] ?? ''] ?? ''));
            $imageUrl         = trim((string)($row[$headerMap['image_url'] ?? ''] ?? ''));
            $videoUrl         = trim((string)($row[$headerMap['video_url'] ?? ''] ?? ''));
            $whatsIncluded    = trim((string)($row[$headerMap['whats_included'] ?? ''] ?? ''));
            $suitableFor      = trim((string)($row[$headerMap['suitable_for'] ?? ''] ?? ''));
            $isActiveVal      = trim((string)($row[$headerMap['is_active'] ?? ''] ?? '1'));

            // Validation
            if (empty($name)) {
                $errors[] = "السطر {$currentRowIndex}: اسم المنتج مطلوب ولا يمكن أن يكون فارغاً.";
                continue;
            }

            if (!is_numeric($price) || (float)$price < 0) {
                $errors[] = "السطر {$currentRowIndex} ({$name}): السعر الأساسي غير صالح (يجب أن يكون رقماً موجباً).";
                continue;
            }

            $validTypes = ['physical', 'digital', 'course', 'session'];
            if (!in_array($type, $validTypes)) {
                $type = 'physical'; // Default fallback
            }

            $numericSalePrice = (is_numeric($salePrice) && (float)$salePrice > 0) ? (float)$salePrice : null;
            $numericStock = is_numeric($stock) ? (int)$stock : 0;
            $isActive = in_array(strtolower($isActiveVal), ['1', 'true', 'نعم', 'active', 'yes']);

            try {
                DB::beginTransaction();

                // Find Existing Product (By ID or SKU)
                $product = null;
                if (!empty($id) && is_numeric($id)) {
                    $product = Product::find((int)$id);
                }
                if (!$product && !empty($sku)) {
                    $product = Product::where('sku', $sku)->first();
                }

                $isNew = false;
                if (!$product) {
                    $product = new Product();
                    $isNew = true;
                    // Auto generate unique slug
                    $baseSlug = Str::slug($name);
                    $slug = $baseSlug ?: 'product-' . time() . '-' . rand(10, 99);
                    $count = 1;
                    while (Product::where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $count++;
                    }
                    $product->slug = $slug;
                }

                // Brand association
                $brandId = null;
                if (!empty($brandName)) {
                    $brand = Brand::firstOrCreate(
                        ['name' => $brandName],
                        [
                            'slug' => Str::slug($brandName) . '-' . rand(100, 999),
                            'logo' => 'images/logo.png',
                            'row'  => 'top',
                            'is_active' => true,
                        ]
                    );
                    $brandId = $brand->id;
                }

                // Images
                $imagesArray = $product->images ?: [];
                if (!empty($imageUrl)) {
                    $splitImages = array_filter(array_map('trim', explode(',', $imageUrl)));
                    $imagesArray = array_values(array_unique(array_merge($imagesArray, $splitImages)));
                }

                // Set Product Attributes
                $product->name              = $name;
                $product->sku               = !empty($sku) ? $sku : ($product->sku ?: 'SKU-' . strtoupper(Str::random(8)));
                $product->type              = $type;
                $product->price             = (float)$price;
                $product->sale_price        = $numericSalePrice;
                $product->stock             = $numericStock;
                $product->badge             = !empty($badge) ? $badge : null;
                $product->brand_id          = $brandId ?: $product->brand_id;
                $product->short_description = !empty($shortDescription) ? $shortDescription : $product->short_description;
                $product->description       = !empty($description) ? $description : $product->description;
                $product->video_url         = !empty($videoUrl) ? $videoUrl : $product->video_url;
                $product->whats_included    = !empty($whatsIncluded) ? $whatsIncluded : $product->whats_included;
                $product->suitable_for      = !empty($suitableFor) ? $suitableFor : $product->suitable_for;
                $product->images            = $imagesArray;
                $product->is_active         = $isActive;
                $product->save();

                // Sync Taxonomies (Categories, AgeGroups, Skills, Needs)
                if (!empty($categoriesStr)) {
                    $catNames = array_filter(array_map('trim', explode(',', $categoriesStr)));
                    $catIds = [];
                    foreach ($catNames as $cName) {
                        $cat = Category::firstOrCreate(
                            ['name' => $cName],
                            ['slug' => Str::slug($cName) ?: 'cat-' . Str::random(6), 'is_active' => true]
                        );
                        $catIds[] = $cat->id;
                    }
                    $product->categories()->sync($catIds);
                }

                if (!empty($ageGroupsStr)) {
                    $ageNames = array_filter(array_map('trim', explode(',', $ageGroupsStr)));
                    $ageIds = [];
                    foreach ($ageNames as $aName) {
                        $ag = AgeGroup::firstOrCreate(
                            ['name' => $aName],
                            ['slug' => Str::slug($aName) ?: 'age-' . Str::random(6)]
                        );
                        $ageIds[] = $ag->id;
                    }
                    $product->ageGroups()->sync($ageIds);
                }

                if (!empty($skillsStr)) {
                    $skillNames = array_filter(array_map('trim', explode(',', $skillsStr)));
                    $skillIds = [];
                    foreach ($skillNames as $sName) {
                        $sk = Skill::firstOrCreate(
                            ['name' => $sName],
                            ['slug' => Str::slug($sName) ?: 'skill-' . Str::random(6)]
                        );
                        $skillIds[] = $sk->id;
                    }
                    $product->skills()->sync($skillIds);
                }

                if (!empty($needsStr)) {
                    $needNames = array_filter(array_map('trim', explode(',', $needsStr)));
                    $needIds = [];
                    foreach ($needNames as $nName) {
                        $nd = Need::firstOrCreate(
                            ['name' => $nName],
                            ['slug' => Str::slug($nName) ?: 'need-' . Str::random(6)]
                        );
                        $needIds[] = $nd->id;
                    }
                    $product->needs()->sync($needIds);
                }

                DB::commit();

                if ($isNew) {
                    $successCount++;
                } else {
                    $updatedCount++;
                }
            } catch (\Throwable $e) {
                DB::rollBack();
                $errors[] = "السطر {$currentRowIndex} ({$name}): حدث استثناء أثناء الحفظ ({$e->getMessage()})";
            }
        }

        $importSummary = [
            'total'   => $successCount + $updatedCount,
            'created' => $successCount,
            'updated' => $updatedCount,
            'errors'  => $errors,
        ];

        session()->flash('import_summary', $importSummary);

        if (count($errors) === 0) {
            return redirect()->route('admin.products.importExport')->with('success', "تم الاستيراد بنجاح! تم إنشاء {$successCount} منتج جديد، وتحديث {$updatedCount} منتج.");
        } else {
            return redirect()->route('admin.products.importExport')->with('warning', "تم اكتمال الاستيراد مع وجود بعض التنبيهات: تم إنشاء {$successCount} جديد، تحديث {$updatedCount}، وحدثت أخطاء في " . count($errors) . " صفوف.");
        }
    }

    /**
     * Map Spreadsheet Column Headers flexibly
     */
    private function mapHeaders(array $headers): array
    {
        $map = [];
        foreach ($headers as $colLetter => $rawHeader) {
            $header = strtolower(trim((string)$rawHeader));
            
            if (Str::contains($header, ['معرف', 'id']) && !isset($map['id'])) {
                $map['id'] = $colLetter;
            } elseif (Str::contains($header, ['sku', 'كود', 'رمز']) && !isset($map['sku'])) {
                $map['sku'] = $colLetter;
            } elseif (Str::contains($header, ['اسم', 'name', 'عنوان']) && !isset($map['name'])) {
                $map['name'] = $colLetter;
            } elseif (Str::contains($header, ['نوع', 'type']) && !isset($map['type'])) {
                $map['type'] = $colLetter;
            } elseif (Str::contains($header, ['سعر التخفيض', 'sale_price', 'تخفيض', 'خصم']) && !isset($map['sale_price'])) {
                $map['sale_price'] = $colLetter;
            } elseif (Str::contains($header, ['سعر', 'price']) && !isset($map['price'])) {
                $map['price'] = $colLetter;
            } elseif (Str::contains($header, ['مخزون', 'stock', 'كمية']) && !isset($map['stock'])) {
                $map['stock'] = $colLetter;
            } elseif (Str::contains($header, ['شارة', 'badge']) && !isset($map['badge'])) {
                $map['badge'] = $colLetter;
            } elseif (Str::contains($header, ['براند', 'ماركة', 'brand']) && !isset($map['brand'])) {
                $map['brand'] = $colLetter;
            } elseif (Str::contains($header, ['تصنيف', 'categories', 'فئة']) && !isset($map['categories'])) {
                $map['categories'] = $colLetter;
            } elseif (Str::contains($header, ['عمر', 'age']) && !isset($map['age_groups'])) {
                $map['age_groups'] = $colLetter;
            } elseif (Str::contains($header, ['مهار', 'skill']) && !isset($map['skills'])) {
                $map['skills'] = $colLetter;
            } elseif (Str::contains($header, ['احتياج', 'need']) && !isset($map['needs'])) {
                $map['needs'] = $colLetter;
            } elseif (Str::contains($header, ['مختصر', 'short_description']) && !isset($map['short_description'])) {
                $map['short_description'] = $colLetter;
            } elseif (Str::contains($header, ['وصف', 'description']) && !isset($map['description'])) {
                $map['description'] = $colLetter;
            } elseif (Str::contains($header, ['صورة', 'image']) && !isset($map['image_url'])) {
                $map['image_url'] = $colLetter;
            } elseif (Str::contains($header, ['فيديو', 'video']) && !isset($map['video_url'])) {
                $map['video_url'] = $colLetter;
            } elseif (Str::contains($header, ['يتضمن', 'whats_included']) && !isset($map['whats_included'])) {
                $map['whats_included'] = $colLetter;
            } elseif (Str::contains($header, ['مناسب', 'suitable_for']) && !isset($map['suitable_for'])) {
                $map['suitable_for'] = $colLetter;
            } elseif (Str::contains($header, ['حالة', 'نشط', 'is_active']) && !isset($map['is_active'])) {
                $map['is_active'] = $colLetter;
            }
        }

        return $map;
    }
}
