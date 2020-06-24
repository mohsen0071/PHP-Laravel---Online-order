<?php
use App\Province;
use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            ['name' => 'آذربایجان شرقی'],
            ['name' => 'آذربایجان غربی'],
            ['name' => 'اردبیل'],
            ['name' => 'اصفهان'],
            ['name' => 'البرز'],
            ['name' => 'ایلام'],
            ['name' => 'بوشهر'],
            ['name' => 'تهران'],
            ['name' => 'چهارمحال و بختیاری'],
            ['name' => 'خراسان جنوبی'],
            ['name' => 'خراسان رضوی'],
            ['name' => 'خراسان شمالی'],
            ['name' => 'خوزستان'],
            ['name' => 'زنجان'],
            ['name' => 'سمنان'],
            ['name' => 'سیستان و بلوچستان'],
            ['name' => 'فارس'],
            ['name' => 'قزوین'],
            ['name' => 'قم'],
            ['name' => 'کردستان'],
            ['name' => 'کرمان'],
            ['name' => 'کرمانشاه'],
            ['name' => 'کهگیلویه و بویراحمد'],
            ['name' => 'گلستان'],
            ['name' => 'گیلان'],
            ['name' => 'لرستان'],
            ['name' => 'مازندران'],
            ['name' => 'مرکزی'],
            ['name' => 'هرمزگان'],
            ['name' => 'همدان'],
            ['name' => 'یزد']
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}
