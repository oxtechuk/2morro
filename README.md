# 🛍️ 2morro E-Commerce Platform | متجر تمورو الإلكتروني

<div align="center">

![2morro Logo](public/assets/logo.png)

[![Laravel](https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)](https://vuejs.org/)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)

**منصة تجارة إلكترونية متكاملة حديثة مبنية بأحدث تقنيات الويب**  
*Modern, scalable, multi-vendor e-commerce platform & online marketplace*

</div>

---

## 📖 جدول المحتويات | Table of Contents
- [نظرة عامة | Overview](#-نظرة-عامة--overview)
- [المميزات الرئيسية | Key Features](#-المميزات-الرئيسية--key-features)
- [المتطلبات الأساسية | Requirements](#-المتطلبات-الأساسية--requirements)
- [خطوات التثبيت والتشغيل | Installation](#-خطوات-التثبيت-والتشغيل--installation)
- [الأوامر المتاحة | Available Commands](#-الأوامر-المتاحة--available-commands)
- [هيكل المشروع | Project Structure](#-هيكل-المشروع--project-structure)
- [البيئة والتهيئة | Environment Setup](#-البيئة-والتهيئة--environment-setup)
- [المساهمة والترخيص | License](#-الترخيص--license)

---

## 🌟 نظرة عامة | Overview

**متجر تمورو (2morro)** هو منصة تجارة إلكترونية متطورة وسريعة، تهدف إلى تقديم تجربة تسوق رقمية سلسة، تتميز بواجهة مستخدم تفاعلية مستندة إلى **Vue 3** و **Tailwind CSS** مع خلفية برمجية قوية وآمنة عبر إطار عمل **Laravel**.

---

## ✨ المميزات الرئيسية | Key Features

- 🛍️ **كتالوج المنتجات والأقسام**: تصفح ذكي، فلاتر متعددة، بحث متقدم وسريع.
- ⚡ **أداء فائق وSPA**: واجهة مبنية بتقنية Vue 3 وتكامل كامل مع Vite.
- 💳 **بوابات دفع متعددة وآمنة**: دعم لخيارات الدفع الإلكتروني والنقدي عند الاستلام.
- 📱 **تصميم متجاوب بالكامل (Responsive)**: متوافق مع كافة أحجام الشاشات والهواتف الذكية.
- 🌐 **دعم كامل للغة العربية والإنجليزية**: دعم كامل لاتجاهات النصوص RTL & LTR.
- 📊 **لوحة تحكم وإدارة متكاملة (Admin Dashboard)**: إدارة الطلبات، المنتجات، العملاء، والمخزون.
- 🔒 **حماية وأمان عالي**: حماية متكاملة ضد هجمات الويب وإدارة الصلاحيات والمصادقة.

---

## ⚙️ المتطلبات الأساسية | Requirements

قبل البدء، تأكد من تثبيت الحزم والبرمجيات التالية في بيئة عملك:

- **PHP**: `^8.2` أو `^8.3` (مع ملحقات: `OpenSSL`, `PDO`, `Mbstring`, `Tokenizer`, `XML`, `Ctype`, `JSON`, `BCMath`, `cURL`)
- **Composer**: `^2.x`
- **Node.js**: `^18.x` أو `^20.x`
- **NPM**: `^9.x` أو `^10.x`
- **Database**: MySQL `^8.0` أو MariaDB `^10.4` أو SQLite

---

## 🚀 خطوات التثبيت والتشغيل | Installation

### 1. استنساخ المستودع (Clone Repository)
```bash
git clone https://github.com/oxtechuk/2morro.git
cd 2morro
```

### 2. تثبيت اعتماديات PHP (Install Composer Dependencies)
```bash
composer install
```

### 3. تثبيت اعتماديات الواجهة الأمامية (Install NPM Packages)
```bash
npm install
```

### 4. إعداد ملف البيئة (Configure Environment)
```bash
cp .env.example .env
php artisan key:generate
```
قم بفتح ملف `.env` وضبط معلومات الاتصال بقاعدة البيانات ومفتاح التطبيق.

### 5. تشغيل التهجيرات والبيانات الأولية (Database Migrations & Seeders)
```bash
php artisan migrate --seed
php artisan storage:link
```

### 6. تشغيل خادم التطوير (Run Local Development Server)
للتشغيل المزدوج للباك إند والفرونت إند:
```bash
# تشغيل سيرفر الـ Laravel
php artisan serve

# في نافذة طرفية ثانية: تشغيل مجمع Vite
npm run dev
```

أو استخدام أمر لارافيل المجمع:
```bash
composer run dev
```

---

## 🛠️ بناء النسخة النهائية للإنتاج | Production Build

لبناء ملفات الواجهة الأمامية للإنتاج:
```bash
npm run build
```

وتحسين أداء التطبيق:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📁 هيكل المشروع | Project Structure

```text
2morro/
├── app/               # نماذج ووحدات تحكم وقواعد العمل (Controllers, Models, Middleware)
├── Admin/             # ملفات ولوحة الإدارة
├── bootstrap/         # إعدادات تحميل النظام
├── config/            # ملفات تكوين النظام
├── database/          # التهجيرات والـ Seeders والـ Factories
├── public/            # نقطة الدخول العامة والملفات الثابتة والأصول
│   └── assets/        # الصور والأيقونات وشعار الموقع
├── resources/         # ملفات الواجهة (Vue components, Blade views, CSS, JS)
│   ├── css/           # تنسيقات Tailwind CSS و App styles
│   ├── js/            # مكونات Vue و Pinia store والموجهات
│   └── views/         # قوالب Blade الرئيسية
├── routes/            # مسارات التطبيق (web.php, api.php, console.php)
├── storage/           # ملفات التخزين المؤقت والتقارير المرفوعة
└── tests/             # اختبارات النظام ووحدات التحقق (PHPUnit)
```

---

## 🛡️ الأمان والخصوصية | Security & Git Best Practices

- تم استبعاد مجلدات الاعتماديات `vendor/` و `node_modules/` تلقائياً من المستودع.
- ملفات المفاتيح والبيئة الحساسة `.env` مستبعدة بالكامل لحماية بياناتك السرية.
- تأكد دائماً من عدم رفع مفاتيح API أو كلمات المرور إلى GitHub.

---

## 📄 الترخيص | License

هذا المشروع خاص بـ **2morro Store**. جميع الحقوق محفوظة © 2026.
