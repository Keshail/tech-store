<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@techstore.local'],
            [
                'name'     => 'Администратор',
                'password' => bcrypt('admin12345'),
            ]
        );

        $categories = [
            'Ноутбуки'      => 'Портативные компьютеры для работы, учёбы и игр.',
            'Смартфоны'     => 'Мобильные телефоны с современными экранами и камерами.',
            'Планшеты'      => 'Планшеты для чтения, рисования и работы с документами.',
            'Комплектующие' => 'Процессоры, память, накопители и блоки питания.',
            'Периферия'     => 'Клавиатуры, мыши, мониторы и гарнитуры.',
        ];

        foreach ($categories as $name => $description) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description]
            );
        }

        $products = [
            // Ноутбуки
            ['Ноутбуки', 'UltraBook Pro 14', 'TechLine', 94990, 12, true,
                '14-дюймовый ноутбук, 16 ГБ ОЗУ, SSD 512 ГБ, экран 2.8K, вес 1.2 кг.', 'img/products/laptop-1.svg'],
            ['Ноутбуки', 'GameForce 17 RTX', 'GameForce', 149990, 5, true,
                'Игровой ноутбук: 17" 165 Гц, RTX-графика, 32 ГБ ОЗУ, охлаждение с двумя вентиляторами.', 'img/products/laptop-2.svg'],
            ['Ноутбуки', 'AirNote 13', 'TechLine', 59990, 20, false,
                'Лёгкий ноутбук для учёбы: 13", 8 ГБ ОЗУ, автономность до 14 часов.', 'img/products/laptop-3.svg'],

            // Смартфоны
            ['Смартфоны', 'Nova X5 256 ГБ', 'Nova', 69990, 25, true,
                '6.5" AMOLED 120 Гц, тройная камера 50 Мп, быстрая зарядка 65 Вт.', 'img/products/phone-1.svg'],
            ['Смартфоны', 'Nova Lite 128 ГБ', 'Nova', 27990, 40, false,
                'Доступный смартфон: 6.4" IPS, 128 ГБ, батарея 5000 мА·ч.', 'img/products/phone-2.svg'],
            ['Смартфоны', 'PixelWave 9', 'PixelWave', 89990, 8, false,
                'Флагман с камерой 108 Мп и оптической стабилизацией.', 'img/products/phone-3.svg'],

            // Планшеты
            ['Планшеты', 'TabPro 11', 'TechLine', 45990, 15, true,
                '11" экран, стилус в комплекте, 128 ГБ, поддержка клавиатуры.', 'img/products/tablet-1.svg'],
            ['Планшеты', 'TabMini 8', 'TechLine', 24990, 18, false,
                'Компактный планшет 8" для чтения и заметок.', 'img/products/tablet-2.svg'],

            // Комплектующие
            ['Комплектующие', 'Процессор Ryzen 7 7800X', 'AMD', 32990, 10, false,
                '8 ядер / 16 потоков, 5.0 ГГц, сокет AM5.', 'img/products/cpu-1.svg'],
            ['Комплектующие', 'Видеокарта RTX 4070 12 ГБ', 'GeForce', 64990, 6, true,
                'Производительная видеокарта для игр в 1440p и работы с 3D.', 'img/products/gpu-1.svg'],
            ['Комплектующие', 'ОЗУ DDR5 32 ГБ (2×16)', 'CrucialPro', 11490, 30, false,
                'Двухканальный комплект DDR5-6000, радиаторы.', 'img/products/ram-1.svg'],
            ['Комплектующие', 'SSD NVMe 1 ТБ', 'FastDisk', 8990, 35, false,
                'PCIe 4.0, скорость чтения до 7000 МБ/с.', 'img/products/ssd-1.svg'],
            ['Комплектующие', 'Блок питания 750 Вт Gold', 'PowerLine', 9990, 14, false,
                '80+ Gold, модульные кабели, тихий вентилятор.', 'img/products/psu-1.svg'],

            // Периферия
            ['Периферия', 'Механическая клавиатура K80', 'KeyMaster', 7990, 22, false,
                'Переключатели Red, подсветка RGB, съёмный кабель USB-C.', 'img/products/kb-1.svg'],
            ['Периферия', 'Мышь Ergo Pro', 'KeyMaster', 3490, 45, false,
                'Эргономичная мышь 26000 DPI, беспроводная, 70 дней автономности.', 'img/products/mouse-1.svg'],
            ['Периферия', 'Монитор 27" 144 Гц', 'ViewMax', 27990, 9, true,
                'IPS 2K, 144 Гц, покрытие sRGB 99%, регулировка по высоте.', 'img/products/monitor-1.svg'],
            ['Периферия', 'Гарнитура SoundMax 7.1', 'SoundMax', 5990, 16, false,
                'Объёмный звук, съёмный микрофон, мягкие амбушюры.', 'img/products/headset-1.svg'],
            ['Периферия', 'USB-C хаб 8 в 1', 'TechLine', 2990, 50, false,
                'HDMI 4K, 3×USB, кардридер, Ethernet, зарядка 100 Вт.', 'img/products/hub-1.svg'],
        ];

        $bySlug = Category::all()->keyBy('slug');

        foreach ($products as [$categoryName, $name, $brand, $price, $stock, $featured, $description, $image]) {
            $category = $bySlug[Str::slug($categoryName)];

            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $category->id,
                    'name'        => $name,
                    'brand'       => $brand,
                    'description' => $description,
                    'price'       => $price,
                    'stock'       => $stock,
                    'is_featured' => $featured,
                    'image'       => $image,
                ]
            );
        }
    }
}
