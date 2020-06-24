<?php
use App\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['province_id' => 1, 'name' => 'آذرشهر'],
            ['province_id' => 1, 'name' => 'اسکو'],
            ['province_id' => 1, 'name' => 'اهر'],
            ['province_id' => 1, 'name' => 'بستان آباد'],
            ['province_id' => 1, 'name' => 'بناب'],
            ['province_id' => 1, 'name' => 'بندر شرفخانه'],
            ['province_id' => 1, 'name' => 'تبریز'],
            ['province_id' => 1, 'name' => 'تسوج'],
            ['province_id' => 1, 'name' => 'جلفا'],
            ['province_id' => 1, 'name' => 'خامنه'],
            ['province_id' => 1, 'name' => 'سراب'],
            ['province_id' => 1, 'name' => 'شبستر'],
            ['province_id' => 1, 'name' => 'صوفیان'],
            ['province_id' => 1, 'name' => 'عجب‌شیر'],
            ['province_id' => 1, 'name' => 'قره آغاج'],
            ['province_id' => 1, 'name' => 'مراغه'],
            ['province_id' => 1, 'name' => 'مرند'],
            ['province_id' => 1, 'name' => 'ملکان'],
            ['province_id' => 1, 'name' => 'ممقان'],
            ['province_id' => 1, 'name' => 'میانه'],
            ['province_id' => 1, 'name' => 'هادیشهر'],
            ['province_id' => 1, 'name' => 'هریس'],
            ['province_id' => 1, 'name' => 'هشترود'],
            ['province_id' => 1, 'name' => 'ورزقان'],
            ['province_id' => 1, 'name' => 'کلیبر'],
            ['province_id' => 1, 'name' => 'کندوان'],
            ['province_id' => 2, 'name' => 'ارومیه'],
            ['province_id' => 2, 'name' => 'اشنویه'],
            ['province_id' => 2, 'name' => 'بازرگان'],
            ['province_id' => 2, 'name' => 'بوکان'],
            ['province_id' => 2, 'name' => 'تکاب'],
            ['province_id' => 2, 'name' => 'خوی'],
            ['province_id' => 2, 'name' => 'سردشت'],
            ['province_id' => 2, 'name' => 'سلماس'],
            ['province_id' => 2, 'name' => 'سیه چشمه'],
            ['province_id' => 2, 'name' => 'شاهین دژ'],
            ['province_id' => 2, 'name' => 'شوط'],
            ['province_id' => 2, 'name' => 'ماکو'],
            ['province_id' => 2, 'name' => 'مهاباد'],
            ['province_id' => 2, 'name' => 'میاندوآب'],
            ['province_id' => 2, 'name' => 'نقده'],
            ['province_id' => 2, 'name' => 'پلدشت'],
            ['province_id' => 2, 'name' => 'پیرانشهر'],
            ['province_id' => 2, 'name' => 'چالدران'],
            ['province_id' => 2, 'name' => 'چایپاره'],
            ['province_id' => 3, 'name' => 'اردبیل'],
            ['province_id' => 3, 'name' => 'اصلاندوز'],
            ['province_id' => 3, 'name' => 'بیله سوار'],
            ['province_id' => 3, 'name' => 'جعفرآباد'],
            ['province_id' => 3, 'name' => 'خلخال'],
            ['province_id' => 3, 'name' => 'سرعین'],
            ['province_id' => 3, 'name' => 'لاهرود'],
            ['province_id' => 3, 'name' => 'مشگین‌شهر'],
            ['province_id' => 3, 'name' => 'نمین'],
            ['province_id' => 3, 'name' => 'نیر'],
            ['province_id' => 3, 'name' => 'پارس آباد'],
            ['province_id' => 3, 'name' => 'کوثر - گیوی'],
            ['province_id' => 3, 'name' => 'گرمی'],
            ['province_id' => 4, 'name' => 'آران و بیدگل'],
            ['province_id' => 4, 'name' => 'اردستان'],
            ['province_id' => 4, 'name' => 'اصفهان'],
            ['province_id' => 4, 'name' => 'باغ بهادران'],
            ['province_id' => 4, 'name' => 'تیران'],
            ['province_id' => 4, 'name' => 'خمینی شهر'],
            ['province_id' => 4, 'name' => 'خوانسار'],
            ['province_id' => 4, 'name' => 'خور'],
            ['province_id' => 4, 'name' => 'دهاقان'],
            ['province_id' => 4, 'name' => 'دولت آباد'],
            ['province_id' => 4, 'name' => 'زاینده رود'],
            ['province_id' => 4, 'name' => 'زیباشهر'],
            ['province_id' => 4, 'name' => 'سمیرم'],
            ['province_id' => 4, 'name' => 'سپاهان‌شهر'],
            ['province_id' => 4, 'name' => 'شاهین‌شهر'],
            ['province_id' => 4, 'name' => 'شهرضا'],
            ['province_id' => 4, 'name' => 'فریدن - داران'],
            ['province_id' => 4, 'name' => 'فریدون‌شهر'],
            ['province_id' => 4, 'name' => 'فلاورجان'],
            ['province_id' => 4, 'name' => 'فولادشهر'],
            ['province_id' => 4, 'name' => 'قهدریجان'],
            ['province_id' => 4, 'name' => 'لنجان - زرین‌شهر'],
            ['province_id' => 4, 'name' => 'مبارکه'],
            ['province_id' => 4, 'name' => 'میمه'],
            ['province_id' => 4, 'name' => 'نائین'],
            ['province_id' => 4, 'name' => 'نجف آباد'],
            ['province_id' => 4, 'name' => 'نطنز'],
            ['province_id' => 4, 'name' => 'هرند'],
            ['province_id' => 4, 'name' => 'ویلاشهر'],
            ['province_id' => 4, 'name' => 'چادگان'],
            ['province_id' => 4, 'name' => 'کاشان'],
            ['province_id' => 4, 'name' => 'گلدشت'],
            ['province_id' => 4, 'name' => 'گلپایگان'],
            ['province_id' => 5, 'name' => 'آسارا'],
            ['province_id' => 5, 'name' => 'اشتهارد'],
            ['province_id' => 5, 'name' => 'تنکمان'],
            ['province_id' => 5, 'name' => 'ساوجبلاغ - هشتگرد'],
            ['province_id' => 5, 'name' => 'ساوجبلاغ - کوهسار'],
            ['province_id' => 5, 'name' => 'سیف آباد'],
            ['province_id' => 5, 'name' => 'شهر جدید هشتگرد'],
            ['province_id' => 5, 'name' => 'طالقان'],
            ['province_id' => 5, 'name' => 'ماهدشت'],
            ['province_id' => 5, 'name' => 'محمدشهر'],
            ['province_id' => 5, 'name' => 'مشکین دشت'],
            ['province_id' => 5, 'name' => 'مهرشهر'],
            ['province_id' => 5, 'name' => 'نظرآباد'],
            ['province_id' => 5, 'name' => 'چهارباغ'],
            ['province_id' => 5, 'name' => 'کرج'],
            ['province_id' => 5, 'name' => 'کمال‌شهر'],
            ['province_id' => 5, 'name' => 'گرمدره'],
            ['province_id' => 6, 'name' => 'آبدانان'],
            ['province_id' => 6, 'name' => 'ایلام'],
            ['province_id' => 6, 'name' => 'ایوان'],
            ['province_id' => 6, 'name' => 'دره شهر'],
            ['province_id' => 6, 'name' => 'دهلران'],
            ['province_id' => 6, 'name' => 'سرابله'],
            ['province_id' => 6, 'name' => 'مهران'],
            ['province_id' => 7, 'name' => 'بندر دیر'],
            ['province_id' => 7, 'name' => 'بندر دیلم'],
            ['province_id' => 7, 'name' => 'بندر کنگان'],
            ['province_id' => 7, 'name' => 'بندر گناوه'],
            ['province_id' => 7, 'name' => 'بوشهر'],
            ['province_id' => 7, 'name' => 'تنگستان - اهرم'],
            ['province_id' => 7, 'name' => 'جزیره خارک'],
            ['province_id' => 7, 'name' => 'جم'],
            ['province_id' => 7, 'name' => 'دشتستان - آب‌پخش'],
            ['province_id' => 7, 'name' => 'دشتستان - برازجان'],
            ['province_id' => 7, 'name' => 'دشتی - خورموج'],
            ['province_id' => 7, 'name' => 'دلوار'],
            ['province_id' => 7, 'name' => 'عسلویه'],
            ['province_id' => 7, 'name' => 'کاکی'],
            ['province_id' => 8, 'name' => 'آبسرد'],
            ['province_id' => 8, 'name' => 'آبعلی'],
            ['province_id' => 8, 'name' => 'اسلامشهر'],
            ['province_id' => 8, 'name' => 'اندیشه'],
            ['province_id' => 8, 'name' => 'باغستان'],
            ['province_id' => 8, 'name' => 'باقرشهر'],
            ['province_id' => 8, 'name' => 'بومهن'],
            ['province_id' => 8, 'name' => 'تهران'],
            ['province_id' => 8, 'name' => 'دماوند'],
            ['province_id' => 8, 'name' => 'رباط کریم'],
            ['province_id' => 8, 'name' => 'رودهن'],
            ['province_id' => 8, 'name' => 'ری'],
            ['province_id' => 8, 'name' => 'شاهدشهر'],
            ['province_id' => 8, 'name' => 'شریف آباد'],
            ['province_id' => 8, 'name' => 'شهریار'],
            ['province_id' => 8, 'name' => 'صفادشت'],
            ['province_id' => 8, 'name' => 'فشم'],
            ['province_id' => 8, 'name' => 'فیروزکوه'],
            ['province_id' => 8, 'name' => 'قدس'],
            ['province_id' => 8, 'name' => 'قرچک'],
            ['province_id' => 8, 'name' => 'لواسان'],
            ['province_id' => 8, 'name' => 'ملارد'],
            ['province_id' => 8, 'name' => 'نسیم‌شهر'],
            ['province_id' => 8, 'name' => 'نصیرآباد'],
            ['province_id' => 8, 'name' => 'وحیدیه'],
            ['province_id' => 8, 'name' => 'ورامین'],
            ['province_id' => 8, 'name' => 'پاکدشت'],
            ['province_id' => 8, 'name' => 'پردیس'],
            ['province_id' => 8, 'name' => 'پرند'],
            ['province_id' => 8, 'name' => 'پیشوا'],
            ['province_id' => 8, 'name' => 'چهاردانگه'],
            ['province_id' => 8, 'name' => 'کهریزک'],
            ['province_id' => 8, 'name' => 'کیلان'],
            ['province_id' => 8, 'name' => 'گلستان'],
            ['province_id' => 9, 'name' => 'اردل'],
            ['province_id' => 9, 'name' => 'بروجن'],
            ['province_id' => 9, 'name' => 'بن'],
            ['province_id' => 9, 'name' => 'دزک'],
            ['province_id' => 9, 'name' => 'سامان'],
            ['province_id' => 9, 'name' => 'سورشجان'],
            ['province_id' => 9, 'name' => 'شلمزار - کیار'],
            ['province_id' => 9, 'name' => 'شهرکرد'],
            ['province_id' => 9, 'name' => 'فارسان'],
            ['province_id' => 9, 'name' => 'فرخ‌شهر'],
            ['province_id' => 9, 'name' => 'لردگان'],
            ['province_id' => 9, 'name' => 'هارونی'],
            ['province_id' => 9, 'name' => 'هفشجان'],
            ['province_id' => 9, 'name' => 'کوهرنگ - چلگرد'],
            ['province_id' => 10, 'name' => 'بشرویه'],
            ['province_id' => 10, 'name' => 'بیرجند'],
            ['province_id' => 10, 'name' => 'خضری دشت‌بیاض'],
            ['province_id' => 10, 'name' => 'خوسف'],
            ['province_id' => 10, 'name' => 'درمیان - اسدیه'],
            ['province_id' => 10, 'name' => 'زیرکوه - حاجی آباد'],
            ['province_id' => 10, 'name' => 'سرایان'],
            ['province_id' => 10, 'name' => 'سربیشه'],
            ['province_id' => 10, 'name' => 'طبس'],
            ['province_id' => 10, 'name' => 'فردوس'],
            ['province_id' => 10, 'name' => 'قائنات - قائن'],
            ['province_id' => 10, 'name' => 'نهبندان'],
            ['province_id' => 11, 'name' => 'باجگیران'],
            ['province_id' => 11, 'name' => 'باخرز'],
            ['province_id' => 11, 'name' => 'بجستان'],
            ['province_id' => 11, 'name' => 'بردسکن'],
            ['province_id' => 11, 'name' => 'بیدخت'],
            ['province_id' => 11, 'name' => 'تایباد'],
            ['province_id' => 11, 'name' => 'تربت جام'],
            ['province_id' => 11, 'name' => 'تربت حیدریه'],
            ['province_id' => 11, 'name' => 'جغتای'],
            ['province_id' => 11, 'name' => 'جوین - نقاب'],
            ['province_id' => 11, 'name' => 'خلیل آباد'],
            ['province_id' => 11, 'name' => 'خواف'],
            ['province_id' => 11, 'name' => 'داورزن'],
            ['province_id' => 11, 'name' => 'درگز'],
            ['province_id' => 11, 'name' => 'رشتخوار'],
            ['province_id' => 11, 'name' => 'رضویه'],
            ['province_id' => 11, 'name' => 'زاوه - دولت آباد'],
            ['province_id' => 11, 'name' => 'سبزوار'],
            ['province_id' => 11, 'name' => 'سرخس'],
            ['province_id' => 11, 'name' => 'شاندیز'],
            ['province_id' => 11, 'name' => 'صالح آباد'],
            ['province_id' => 11, 'name' => 'طرقبه'],
            ['province_id' => 11, 'name' => 'طوس سفلی'],
            ['province_id' => 11, 'name' => 'فریمان'],
            ['province_id' => 11, 'name' => 'فیروزه - تخت جلگه'],
            ['province_id' => 11, 'name' => 'قوچان'],
            ['province_id' => 11, 'name' => 'مشهد'],
            ['province_id' => 11, 'name' => 'مه‌ولات - فیض‌آباد'],
            ['province_id' => 11, 'name' => 'نیشابور'],
            ['province_id' => 11, 'name' => 'چمن آباد'],
            ['province_id' => 11, 'name' => 'چناران'],
            ['province_id' => 11, 'name' => 'کاخک'],
            ['province_id' => 11, 'name' => 'کاشمر'],
            ['province_id' => 11, 'name' => 'کلات'],
            ['province_id' => 11, 'name' => 'گلبهار'],
            ['province_id' => 11, 'name' => 'گناباد'],
            ['province_id' => 12, 'name' => 'اسفراین'],
            ['province_id' => 12, 'name' => 'بجنورد'],
            ['province_id' => 12, 'name' => 'جاجرم'],
            ['province_id' => 12, 'name' => 'درق'],
            ['province_id' => 12, 'name' => 'شیروان'],
            ['province_id' => 12, 'name' => 'فاروج'],
            ['province_id' => 12, 'name' => 'مانه و سملقان - آشخانه'],
            ['province_id' => 12, 'name' => 'گرمه'],
            ['province_id' => 13, 'name' => 'آبادان'],
            ['province_id' => 13, 'name' => 'آغاجاری'],
            ['province_id' => 13, 'name' => 'اروندکنار'],
            ['province_id' => 13, 'name' => 'امیدیه'],
            ['province_id' => 13, 'name' => 'اندیمشک'],
            ['province_id' => 13, 'name' => 'اهواز'],
            ['province_id' => 13, 'name' => 'ایذه'],
            ['province_id' => 13, 'name' => 'باغ ملک'],
            ['province_id' => 13, 'name' => 'بندر امام خمینی'],
            ['province_id' => 13, 'name' => 'بندر ماهشهر'],
            ['province_id' => 13, 'name' => 'بهبهان'],
            ['province_id' => 13, 'name' => 'جنت مکان'],
            ['province_id' => 13, 'name' => 'حمیدیه'],
            ['province_id' => 13, 'name' => 'خرمشهر'],
            ['province_id' => 13, 'name' => 'دزفول'],
            ['province_id' => 13, 'name' => 'دشت آزادگان - بستان'],
            ['province_id' => 13, 'name' => 'دشت آزادگان - سوسنگرد'],
            ['province_id' => 13, 'name' => 'رامشیر'],
            ['province_id' => 13, 'name' => 'رامهرمز'],
            ['province_id' => 13, 'name' => 'سردشت'],
            ['province_id' => 13, 'name' => 'شادگان'],
            ['province_id' => 13, 'name' => 'شوش'],
            ['province_id' => 13, 'name' => 'شوشتر'],
            ['province_id' => 13, 'name' => 'لالی'],
            ['province_id' => 13, 'name' => 'مسجدسلیمان'],
            ['province_id' => 13, 'name' => 'ملاثانی'],
            ['province_id' => 13, 'name' => 'هفتکل'],
            ['province_id' => 13, 'name' => 'هندیجان'],
            ['province_id' => 13, 'name' => 'هویزه'],
            ['province_id' => 13, 'name' => 'گتوند'],
            ['province_id' => 14, 'name' => 'ابهر'],
            ['province_id' => 14, 'name' => 'ایجرود - زرین‌آباد'],
            ['province_id' => 14, 'name' => 'خرمدره'],
            ['province_id' => 14, 'name' => 'زنجان'],
            ['province_id' => 14, 'name' => 'سلطانیه'],
            ['province_id' => 14, 'name' => 'طارم - آب‌بر'],
            ['province_id' => 14, 'name' => 'قیدار'],
            ['province_id' => 14, 'name' => 'ماهنشان'],
            ['province_id' => 15, 'name' => 'آرادان'],
            ['province_id' => 15, 'name' => 'ایوانکی'],
            ['province_id' => 15, 'name' => 'بسطام'],
            ['province_id' => 15, 'name' => 'دامغان'],
            ['province_id' => 15, 'name' => 'سرخه'],
            ['province_id' => 15, 'name' => 'سمنان'],
            ['province_id' => 15, 'name' => 'شاهرود'],
            ['province_id' => 15, 'name' => 'شهمیرزاد'],
            ['province_id' => 15, 'name' => 'مهدی‌شهر'],
            ['province_id' => 15, 'name' => 'میامی'],
            ['province_id' => 15, 'name' => 'گرمسار'],
            ['province_id' => 16, 'name' => 'ایرانشهر'],
            ['province_id' => 16, 'name' => 'خاش'],
            ['province_id' => 16, 'name' => 'دلگان - گلمورتی'],
            ['province_id' => 16, 'name' => 'راسک'],
            ['province_id' => 16, 'name' => 'زابل'],
            ['province_id' => 16, 'name' => 'زابلی'],
            ['province_id' => 16, 'name' => 'زاهدان'],
            ['province_id' => 16, 'name' => 'زهک'],
            ['province_id' => 16, 'name' => 'سراوان'],
            ['province_id' => 16, 'name' => 'سرباز'],
            ['province_id' => 16, 'name' => 'سیب و سوران - سوران'],
            ['province_id' => 16, 'name' => 'فنوج'],
            ['province_id' => 16, 'name' => 'میرجاوه'],
            ['province_id' => 16, 'name' => 'نیک‌شهر'],
            ['province_id' => 16, 'name' => 'هیرمند - دوست محمد'],
            ['province_id' => 16, 'name' => 'چابهار'],
            ['province_id' => 16, 'name' => 'کنارک'],
            ['province_id' => 17, 'name' => 'آباده'],
            ['province_id' => 17, 'name' => 'ارسنجان'],
            ['province_id' => 17, 'name' => 'استهبان'],
            ['province_id' => 17, 'name' => 'اقلید'],
            ['province_id' => 17, 'name' => 'اوز'],
            ['province_id' => 17, 'name' => 'ایزدخواست'],
            ['province_id' => 17, 'name' => 'بوانات'],
            ['province_id' => 17, 'name' => 'جهرم'],
            ['province_id' => 17, 'name' => 'حاجی آباد'],
            ['province_id' => 17, 'name' => 'حسن آباد'],
            ['province_id' => 17, 'name' => 'خرامه'],
            ['province_id' => 17, 'name' => 'خرم‌بید'],
            ['province_id' => 17, 'name' => 'خشت'],
            ['province_id' => 17, 'name' => 'خنج'],
            ['province_id' => 17, 'name' => 'داراب'],
            ['province_id' => 17, 'name' => 'رستم - مصیری'],
            ['province_id' => 17, 'name' => 'رونیز'],
            ['province_id' => 17, 'name' => 'زرقان'],
            ['province_id' => 17, 'name' => 'سروستان'],
            ['province_id' => 17, 'name' => 'سوریان'],
            ['province_id' => 17, 'name' => 'سپیدان - اردکان'],
            ['province_id' => 17, 'name' => 'شیراز'],
            ['province_id' => 17, 'name' => 'فراشبند'],
            ['province_id' => 17, 'name' => 'فسا'],
            ['province_id' => 17, 'name' => 'فیروزآباد'],
            ['province_id' => 17, 'name' => 'قائمیه'],
            ['province_id' => 17, 'name' => 'قیر و کارزین'],
            ['province_id' => 17, 'name' => 'لارستان - لار'],
            ['province_id' => 17, 'name' => 'لامرد'],
            ['province_id' => 17, 'name' => 'مرودشت'],
            ['province_id' => 17, 'name' => 'ممسنی - نور آباد'],
            ['province_id' => 17, 'name' => 'مهر'],
            ['province_id' => 17, 'name' => 'میمند'],
            ['province_id' => 17, 'name' => 'نی ریز'],
            ['province_id' => 17, 'name' => 'پاسارگاد - سعادت شهر'],
            ['province_id' => 17, 'name' => 'کازرون'],
            ['province_id' => 17, 'name' => 'کوار'],
            ['province_id' => 17, 'name' => 'گراش'],
            ['province_id' => 18, 'name' => 'آبگرم'],
            ['province_id' => 18, 'name' => 'آبیک'],
            ['province_id' => 18, 'name' => 'آوج'],
            ['province_id' => 18, 'name' => 'اقبالیه'],
            ['province_id' => 18, 'name' => 'البرز - الوند'],
            ['province_id' => 18, 'name' => 'بوئین زهرا'],
            ['province_id' => 18, 'name' => 'بیدستان'],
            ['province_id' => 18, 'name' => 'تاکستان'],
            ['province_id' => 18, 'name' => 'شال'],
            ['province_id' => 18, 'name' => 'ضیاءآباد'],
            ['province_id' => 18, 'name' => 'قزوین'],
            ['province_id' => 18, 'name' => 'محمدیه'],
            ['province_id' => 18, 'name' => 'محمودآباد نمونه'],
            ['province_id' => 19, 'name' => 'جعفریه'],
            ['province_id' => 19, 'name' => 'دستجرد'],
            ['province_id' => 19, 'name' => 'سلفچگان'],
            ['province_id' => 19, 'name' => 'قم'],
            ['province_id' => 19, 'name' => 'قمرود'],
            ['province_id' => 19, 'name' => 'کهک'],
            ['province_id' => 20, 'name' => 'بانه'],
            ['province_id' => 20, 'name' => 'بیجار'],
            ['province_id' => 20, 'name' => 'دهگلان'],
            ['province_id' => 20, 'name' => 'دیواندره'],
            ['province_id' => 20, 'name' => 'سروآباد'],
            ['province_id' => 20, 'name' => 'سقز'],
            ['province_id' => 20, 'name' => 'سنندج'],
            ['province_id' => 20, 'name' => 'قروه'],
            ['province_id' => 20, 'name' => 'مریوان'],
            ['province_id' => 20, 'name' => 'کامیاران'],
            ['province_id' => 21, 'name' => 'انار'],
            ['province_id' => 21, 'name' => 'بافت'],
            ['province_id' => 21, 'name' => 'بردسیر'],
            ['province_id' => 21, 'name' => 'بم'],
            ['province_id' => 21, 'name' => 'بهرمان'],
            ['province_id' => 21, 'name' => 'جیرفت'],
            ['province_id' => 21, 'name' => 'راور'],
            ['province_id' => 21, 'name' => 'رفسنجان'],
            ['province_id' => 21, 'name' => 'رودبار'],
            ['province_id' => 21, 'name' => 'ریگان'],
            ['province_id' => 21, 'name' => 'زرند'],
            ['province_id' => 21, 'name' => 'سرچشمه'],
            ['province_id' => 21, 'name' => 'سیرجان'],
            ['province_id' => 21, 'name' => 'شهربابک'],
            ['province_id' => 21, 'name' => 'عنبرآباد'],
            ['province_id' => 21, 'name' => 'فهرج'],
            ['province_id' => 21, 'name' => 'قلعه گنج'],
            ['province_id' => 21, 'name' => 'ماهان'],
            ['province_id' => 21, 'name' => 'منوجان'],
            ['province_id' => 21, 'name' => 'کرمان'],
            ['province_id' => 21, 'name' => 'کهنوج'],
            ['province_id' => 21, 'name' => 'کوهبنان'],
            ['province_id' => 22, 'name' => 'اسلام‌آباد غرب'],
            ['province_id' => 22, 'name' => 'ثلاث باباجانی'],
            ['province_id' => 22, 'name' => 'جوانرود'],
            ['province_id' => 22, 'name' => 'خسروی'],
            ['province_id' => 22, 'name' => 'روانسر'],
            ['province_id' => 22, 'name' => 'سرپل ذهاب'],
            ['province_id' => 22, 'name' => 'سنقر'],
            ['province_id' => 22, 'name' => 'صحنه'],
            ['province_id' => 22, 'name' => 'قصر شیرین'],
            ['province_id' => 22, 'name' => 'هرسین'],
            ['province_id' => 22, 'name' => 'پاوه'],
            ['province_id' => 22, 'name' => 'کرمانشاه'],
            ['province_id' => 22, 'name' => 'کنگاور'],
            ['province_id' => 22, 'name' => 'گیلانغرب'],
            ['province_id' => 23, 'name' => 'باشت'],
            ['province_id' => 23, 'name' => 'بهمئی - لیکک'],
            ['province_id' => 23, 'name' => 'دنا - سی‌سخت'],
            ['province_id' => 23, 'name' => 'سوق'],
            ['province_id' => 23, 'name' => 'کهگیلویه - دهدشت'],
            ['province_id' => 23, 'name' => 'گچساران - دوگنبدان'],
            ['province_id' => 23, 'name' => 'یاسوج'],
            ['province_id' => 24, 'name' => 'آزادشهر'],
            ['province_id' => 24, 'name' => 'آق قلا'],
            ['province_id' => 24, 'name' => 'بندر ترکمن'],
            ['province_id' => 24, 'name' => 'بندر گز'],
            ['province_id' => 24, 'name' => 'جلین'],
            ['province_id' => 24, 'name' => 'رامیان'],
            ['province_id' => 24, 'name' => 'علی آباد'],
            ['province_id' => 24, 'name' => 'مراوه تپه'],
            ['province_id' => 24, 'name' => 'مینودشت'],
            ['province_id' => 24, 'name' => 'کردکوی'],
            ['province_id' => 24, 'name' => 'کلاله'],
            ['province_id' => 24, 'name' => 'کمیش دپه'],
            ['province_id' => 24, 'name' => 'گالیکش'],
            ['province_id' => 24, 'name' => 'گرگان'],
            ['province_id' => 24, 'name' => 'گنبد کاووس'],
            ['province_id' => 25, 'name' => 'آستارا'],
            ['province_id' => 25, 'name' => 'آستانه اشرفیه'],
            ['province_id' => 25, 'name' => 'اسالم'],
            ['province_id' => 25, 'name' => 'املش'],
            ['province_id' => 25, 'name' => 'بندر انزلی'],
            ['province_id' => 25, 'name' => 'خمام'],
            ['province_id' => 25, 'name' => 'رستم آباد'],
            ['province_id' => 25, 'name' => 'رشت'],
            ['province_id' => 25, 'name' => 'رضوان‌شهر'],
            ['province_id' => 25, 'name' => 'رودبار'],
            ['province_id' => 25, 'name' => 'رودسر'],
            ['province_id' => 25, 'name' => 'سیاهکل'],
            ['province_id' => 25, 'name' => 'شفت'],
            ['province_id' => 25, 'name' => 'صومعه سرا'],
            ['province_id' => 25, 'name' => 'طوالش - هشتپر'],
            ['province_id' => 25, 'name' => 'فومن'],
            ['province_id' => 25, 'name' => 'لاهیجان'],
            ['province_id' => 25, 'name' => 'لنگرود'],
            ['province_id' => 25, 'name' => 'لوشان'],
            ['province_id' => 25, 'name' => 'لیسار'],
            ['province_id' => 25, 'name' => 'ماسال'],
            ['province_id' => 25, 'name' => 'ماسوله'],
            ['province_id' => 25, 'name' => 'منجیل'],
            ['province_id' => 25, 'name' => 'کلاچای'],
            ['province_id' => 26, 'name' => 'ازنا'],
            ['province_id' => 26, 'name' => 'الیگودرز'],
            ['province_id' => 26, 'name' => 'بروجرد'],
            ['province_id' => 26, 'name' => 'خرم‌آباد'],
            ['province_id' => 26, 'name' => 'دلفان - نورآباد'],
            ['province_id' => 26, 'name' => 'دورود'],
            ['province_id' => 26, 'name' => 'سراب‌دوره'],
            ['province_id' => 26, 'name' => 'سلسله - الشتر'],
            ['province_id' => 26, 'name' => 'سپیددشت'],
            ['province_id' => 26, 'name' => 'شول آباد'],
            ['province_id' => 26, 'name' => 'معمولان'],
            ['province_id' => 26, 'name' => 'پل‌دختر'],
            ['province_id' => 26, 'name' => 'چقابل'],
            ['province_id' => 26, 'name' => 'کوهدشت'],
            ['province_id' => 27, 'name' => 'آمل'],
            ['province_id' => 27, 'name' => 'ایزدشهر'],
            ['province_id' => 27, 'name' => 'بابل'],
            ['province_id' => 27, 'name' => 'بابلسر'],
            ['province_id' => 27, 'name' => 'بلده'],
            ['province_id' => 27, 'name' => 'بهشهر'],
            ['province_id' => 27, 'name' => 'تنکابن'],
            ['province_id' => 27, 'name' => 'جویبار'],
            ['province_id' => 27, 'name' => 'رامسر'],
            ['province_id' => 27, 'name' => 'ساری'],
            ['province_id' => 27, 'name' => 'سلمان‌شهر'],
            ['province_id' => 27, 'name' => 'سوادکوه - پل سفید'],
            ['province_id' => 27, 'name' => 'فریدون‌کنار'],
            ['province_id' => 27, 'name' => 'قائم‌شهر'],
            ['province_id' => 27, 'name' => 'محمودآباد'],
            ['province_id' => 27, 'name' => 'مرزن‌آباد'],
            ['province_id' => 27, 'name' => 'نور'],
            ['province_id' => 27, 'name' => 'نوشهر'],
            ['province_id' => 27, 'name' => 'نکا'],
            ['province_id' => 27, 'name' => 'چالوس'],
            ['province_id' => 27, 'name' => 'کلاردشت'],
            ['province_id' => 27, 'name' => 'گلوگاه'],
            ['province_id' => 28, 'name' => 'آشتیان'],
            ['province_id' => 28, 'name' => 'اراک'],
            ['province_id' => 28, 'name' => 'تفرش'],
            ['province_id' => 28, 'name' => 'خمین'],
            ['province_id' => 28, 'name' => 'خنداب'],
            ['province_id' => 28, 'name' => 'دلیجان'],
            ['province_id' => 28, 'name' => 'زرندیه - مامونیه'],
            ['province_id' => 28, 'name' => 'ساوه'],
            ['province_id' => 28, 'name' => 'شازند'],
            ['province_id' => 28, 'name' => 'محلات'],
            ['province_id' => 28, 'name' => 'مهاجران'],
            ['province_id' => 28, 'name' => 'میلاجرد'],
            ['province_id' => 28, 'name' => 'هندودر'],
            ['province_id' => 28, 'name' => 'کمیجان'],
            ['province_id' => 29, 'name' => 'ابوموسی'],
            ['province_id' => 29, 'name' => 'بستک'],
            ['province_id' => 29, 'name' => 'بندر جاسک'],
            ['province_id' => 29, 'name' => 'بندر خمیر'],
            ['province_id' => 29, 'name' => 'بندر لنگه'],
            ['province_id' => 29, 'name' => 'بندرعباس'],
            ['province_id' => 29, 'name' => 'تنب بزرگ'],
            ['province_id' => 29, 'name' => 'حاجی آباد'],
            ['province_id' => 29, 'name' => 'درگهان'],
            ['province_id' => 29, 'name' => 'رودان'],
            ['province_id' => 29, 'name' => 'سیریک'],
            ['province_id' => 29, 'name' => 'قشم'],
            ['province_id' => 29, 'name' => 'میناب'],
            ['province_id' => 29, 'name' => 'پارسیان'],
            ['province_id' => 29, 'name' => 'کیش'],
            ['province_id' => 30, 'name' => 'اسدآباد'],
            ['province_id' => 30, 'name' => 'بهار'],
            ['province_id' => 30, 'name' => 'تویسرکان'],
            ['province_id' => 30, 'name' => 'رزن'],
            ['province_id' => 30, 'name' => 'فامنین'],
            ['province_id' => 30, 'name' => 'لالجین'],
            ['province_id' => 30, 'name' => 'ملایر'],
            ['province_id' => 30, 'name' => 'نهاوند'],
            ['province_id' => 30, 'name' => 'همدان'],
            ['province_id' => 30, 'name' => 'کبودرآهنگ'],
            ['province_id' => 31, 'name' => 'ابرکوه'],
            ['province_id' => 31, 'name' => 'احمدآباد'],
            ['province_id' => 31, 'name' => 'اردکان'],
            ['province_id' => 31, 'name' => 'بافق'],
            ['province_id' => 31, 'name' => 'بهاباد'],
            ['province_id' => 31, 'name' => 'تفت'],
            ['province_id' => 31, 'name' => 'خاتم - هرات'],
            ['province_id' => 31, 'name' => 'صدوق - اشکذر'],
            ['province_id' => 31, 'name' => 'طبس'],
            ['province_id' => 31, 'name' => 'مروست'],
            ['province_id' => 31, 'name' => 'مهریز'],
            ['province_id' => 31, 'name' => 'میبد'],
            ['province_id' => 31, 'name' => 'یزد']
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
