<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shoe;

class ShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shoes = [
            [
                'shoe_name' => 'Nike GT Cut Academy',
                'brand' => 'Nike',
                'color' => ['Black'],
                'price' => 4000,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1772552080/GTCutWhite_n5herm.png'],
                'category' => 'Sports',
                'gender' => '',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => 'Way of Wade 808 5 Ultra V2 “Jay Flow”',
                'brand' => 'LiNing',
                'color' => ['Blue'],
                'price' => 10000,
                'image_url' => [
                    'https://res.cloudinary.com/dehajzfck/image/upload/v1772724087/shoe-locker/nfxyt7r7mptgcmae5rfe.png',
                    'https://res.cloudinary.com/dehajzfck/image/upload/v1773293778/shoe-locker/unq0shbjuaenlorgms50.png'
                ],
                'category' => 'Sports',
                'gender' => '',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => 'Precision 7',
                'brand' => 'Nike',
                'color' => ['Red'],
                'price' => 5500,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1772724045/shoe-locker/elnwxaypyq9kgx8ctjoz.png'],
                'category' => 'Sports',
                'gender' => '',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => 'Nike GT Cut 4 EP Basketball Shoes',
                'brand' => 'Nike',
                'color' => ['Black'],
                'price' => 10895,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1772723225/shoe-locker/zzcu1pqfmiv6t8szevbq.png'],
                'category' => 'Sports',
                'gender' => 'Mens',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => "Nike Air Force 1 '07 Men's Shoe Size 12.5 (White)",
                'brand' => 'Nike',
                'color' => ['White'],
                'price' => 5895,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1772724198/shoe-locker/rfvrv3gm7est0tlxdtkz.png'],
                'category' => 'Lifestyle',
                'gender' => 'Mens',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => 'Converse Chuck Taylor All Star — Black',
                'brand' => 'Converse',
                'color' => ['Black'],
                'price' => 3520,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1772723476/shoe-locker/pp1zkoqls57ed58fljcx.png'],
                'category' => 'Lifestyle',
                'gender' => '',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => "New Balance 574 'Grey Navy'",
                'brand' => 'New Balance',
                'color' => ['Navy'],
                'price' => 8800,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1772723552/shoe-locker/s0mihfoadjoprmp75e4u.png'],
                'category' => 'Lifestyle',
                'gender' => '',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => "Air Force 1 Low LE 'Triple White'",
                'brand' => 'Nike',
                'color' => ['White'],
                'price' => 4800,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1773072291/shoe-locker/bqkvy12h7wwii8jl0gky.png'],
                'category' => 'Lifestyle',
                'gender' => 'Womens',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => "Speedcat OG 'Black Pink'",
                'brand' => 'Puma',
                'color' => ['Black', 'Pink'],
                'price' => 7100,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1773072482/shoe-locker/lirw7fjaodcc80urcvb0.png'],
                'category' => 'Lifestyle',
                'gender' => 'Mens',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
            [
                'shoe_name' => "Stan Smith 'Sandy Pink'",
                'brand' => 'Adidas',
                'color' => ['White', 'Pink'],
                'price' => 5500,
                'image_url' => ['https://res.cloudinary.com/dehajzfck/image/upload/v1773072606/shoe-locker/xa8fcxfp7zw0jcvsg9ks.png'],
                'category' => 'Lifestyle',
                'gender' => 'Womens',
                'is_deleted' => false,
                'deleted_at' => null,
            ],
        ];

        foreach ($shoes as $shoeData) {
            Shoe::create($shoeData);
        }
    }
}
