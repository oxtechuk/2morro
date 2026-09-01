<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة طلب #{{ $order->order_number }}</title>
    <!-- Google Fonts Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 30px;
            color: #1e293b;
            background-color: #ffffff;
            font-size: 14px;
            line-height: 1.6;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #e2e8f0;
            padding: 30px;
            border-radius: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #cbd5e1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .store-logo {
            font-size: 28px;
            font-weight: 800;
            color: #1360e2;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .store-logo span {
            color: #F97376;
        }

        .store-info {
            text-align: left;
            font-size: 12px;
            color: #64748b;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: #1360e2;
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-block h3 {
            font-size: 14px;
            font-weight: 700;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            margin: 0 0 10px 0;
            color: #1360e2;
        }

        .info-block p {
            margin: 5px 0;
            font-size: 13px;
        }

        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table-items th {
            background-color: #f8fafc;
            border-bottom: 2px solid #cbd5e1;
            padding: 12px 10px;
            text-align: right;
            font-weight: 700;
            color: #1360e2;
        }

        .table-items td {
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 10px;
        }

        .totals-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .totals-table {
            width: 300px;
        }

        .totals-table td {
            padding: 6px 10px;
        }

        .totals-table tr.grand-total {
            font-weight: 800;
            font-size: 16px;
            color: #1360e2;
            border-top: 2px solid #cbd5e1;
        }

        .footer-note {
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 50px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        /* Print Media Styles */
        @media print {
            body {
                padding: 0;
            }
            .invoice-box {
                border: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        
        .print-btn-bar {
            max-width: 800px;
            margin: 0 auto 20px auto;
            text-align: left;
        }
        
        .print-btn {
            background-color: #1360e2;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .print-btn:hover {
            background-color: #1e3a8a;
        }
    </style>
</head>
<body>

    <div class="print-btn-bar no-print">
        <button onclick="window.print()" class="print-btn">طباعة الفاتورة الآن</button>
    </div>

    <div class="invoice-box">
        <!-- Store Header -->
        <div class="header">
            <div class="store-logo">
                تمورو<span>.</span>
            </div>
            <div class="store-info">
                <p>متجر تمورو للأدوات التعليمية وشيتات تنمية المهارات</p>
                <p>البريد: info@2morro.com | الموقع: www.2morro.com</p>
            </div>
        </div>

        <!-- Title & Date -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
            <div>
                <h2 class="invoice-title">فاتورة شراء</h2>
                <p style="margin: 0; font-size: 12px; color: #64748b;">رقم الفاتورة: #{{ $order->order_number }}</p>
            </div>
            <div style="text-align: left; font-size: 12px; color: #64748b;">
                <p style="margin: 0;">التاريخ: {{ $order->created_at->format('Y/m/d h:i A') }}</p>
                <p style="margin: 5px 0 0 0;">طريقة الدفع: 
                    @php
                        $paymentMethodText = match($order->payment_method) {
                            'cod' => 'الدفع عند الاستلام',
                            'instapay' => 'تحويل انستاباي (InstaPay)',
                            'wallet' => 'محافظ إلكترونية (فودافون كاش)',
                            'bank' => 'تحويل بنكي مباشر (IBAN)',
                            default => 'غير محدد',
                        };
                    @endphp
                    <b>{{ $paymentMethodText }}</b>
                </p>
            </div>
        </div>

        <!-- Customer & Order details grid -->
        <div class="grid-info">
            <div class="info-block">
                <h3>معلومات المشتري (شحن وتوصيل)</h3>
                <p><b>الاسم المستلم:</b> {{ $order->customer_name }}</p>
                <p><b>رقم الهاتف:</b> {{ $order->customer_phone }}</p>
                <p><b>المحافظة:</b> {{ $order->shipping_governorate }}</p>
                <p><b>العنوان بالكامل:</b> {{ $order->shipping_address }}</p>
            </div>
            <div class="info-block">
                <h3>ملاحظات الطلب والإدارة</h3>
                <p>{{ $order->notes ?: 'لا توجد ملاحظات إضافية على هذا الطلب.' }}</p>
            </div>
        </div>

        <!-- Purchased items table -->
        <table class="table-items">
            <thead>
                <tr>
                    <th style="width: 50%;">اسم المنتج</th>
                    <th style="width: 15%;">النوع</th>
                    <th style="width: 15%; text-align: center;">السعر</th>
                    <th style="width: 10%; text-align: center;">الكمية</th>
                    <th style="width: 10%; text-align: left; padding-left: 10px;">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <b>{{ $item->product_name }}</b>
                            @if($item->product && $item->product->sku)
                                <small style="display: block; color: #64748b; font-size: 11px; margin-top: 2px;">رمز SKU: {{ $item->product->sku }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $itemTypeLabel = match($item->type) {
                                    'digital' => 'ملف PDF',
                                    'course' => 'كورس تعليمي',
                                    'session' => 'جلسة تواصل',
                                    default => 'أداة مادية',
                                };
                            @endphp
                            {{ $itemTypeLabel }}
                        </td>
                        <td style="text-align: center;">{{ number_format($item->price, 2) }} ج.م</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: left; padding-left: 10px; font-weight: 600;">{{ number_format($item->price * $item->quantity, 2) }} ج.م</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Totals -->
        <div class="totals-box">
            <table class="totals-table">
                <tr>
                    <td style="color: #64748b;">الإجمالي الفرعي:</td>
                    <td style="text-align: left; font-weight: 600;">{{ number_format($order->subtotal, 2) }} ج.م</td>
                </tr>
                <tr>
                    <td style="color: #64748b;">تكلفة التوصيل:</td>
                    <td style="text-align: left; font-weight: 600;">{{ number_format($order->shipping_fee, 2) }} ج.م</td>
                </tr>
                <tr>
                    <td style="color: #64748b;">الخصومات المطبقة:</td>
                    <td style="text-align: left; font-weight: 600; color: #ef4444;">-{{ number_format($order->discount_total, 2) }} ج.م</td>
                </tr>
                <tr class="grand-total">
                    <td>المبلغ الإجمالي النهائي:</td>
                    <td style="text-align: left;">{{ number_format($order->total, 2) }} ج.م</td>
                </tr>
            </table>
        </div>

        <!-- Footer note -->
        <div class="footer-note">
            <p>شكراً لتسوقكم مع مركز ومتجر 2morro لتنمية مهارات الطفل | قيادة وإشراف: أ. هبة الله أكرم</p>
            <p>فروعنا بالإسكندرية (الإبراهيمية - البيطاش - سيدي بشر) | للتواصل عبر WhatsApp: 01550504512</p>
        </div>
    </div>

    <!-- Auto Print Trigger -->
    <script>
        window.onload = function() {
            // Uncomment the line below to auto trigger print dialog on load in production
            window.print();
        }
    </script>
</body>
</html>
