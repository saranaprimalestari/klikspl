<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Province;
use App\Models\AdminType;
use App\Models\OrderItem;
use App\Models\ProductMerk;
// use App\Models\UserAdmin;
use App\Models\UserAddress;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use App\Models\ProductImage;
use App\Models\PaymentMethod;
use App\Models\ProductOrigin;
use App\Models\SenderAddress;
use App\Models\ProductComment;
use App\Models\ProductVariant;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\UserNotification;
use App\Models\OrderProductImage;
use App\Models\PromoBanner;
use App\Models\PromoPaymentMethod;
use App\Models\PromoType;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory(4)->create();
        User::create([
            'username' => 'rdnndr',
            'email' => 'riduanindra11@gmail.com',
            'password' => bcrypt('taibau11')
        ]);

        // Product::factory(100)->create();
        // ProductVariant::factory(200)->create();
        ProductCategory::factory(10)->create();
        // ProductComment::factory(300)->create();
        // ProductImage::factory(200)->create();
        // ProductOrigin::factory(200)->create();
        // PaymentMethod::factory(6)->create();
        // ProductMerk::factory(13)->create();

        ProductMerk::create([
            'name' => 'Cheetah',
            'slug' => 'cheetah',
            'image' => 'img/merk/cheetah.png',
        ]);

        ProductMerk::create([
            'name' => 'DM Tech',
            'slug' => 'dm-tech',
            'image' => 'img/merk/dm.png',
        ]);

        ProductMerk::create([
            'name' => 'Fuhrer',
            'slug' => 'fuhrer',
            'image' => 'img/merk/fuhrer.png',
        ]);

        ProductMerk::create([
            'name' => 'IBK Premium',
            'slug' => 'ibk-premium',
            'image' => 'img/merk/ibk.png',
        ]);

        ProductMerk::create([
            'name' => 'Inter Sprayer',
            'slug' => 'inter',
            'image' => 'img/merk/inter.png',
        ]);

        ProductMerk::create([
            'name' => 'Jackson',
            'slug' => 'jackson',
            'image' => 'img/merk/jackson.png',
        ]);

        ProductMerk::create([
            'name' => 'Kimberly Clark',
            'slug' => 'kimberly-clark',
            'image' => 'img/merk/kc.png',
        ]);

        ProductMerk::create([
            'name' => 'Kingoya',
            'slug' => 'kingoya',
            'image' => 'img/merk/kingoya.png',
        ]);

        ProductMerk::create([
            'name' => 'RCA Battery',
            'slug' => 'rca-battery',
            'image' => 'img/merk/rca.png',
        ]);

        ProductMerk::create([
            'name' => 'Renold',
            'slug' => 'renold',
            'image' => 'img/merk/renold.png',
        ]);

        ProductMerk::create([
            'name' => 'Servvo',
            'slug' => 'servvo',
            'image' => 'img/merk/servvo.png',
        ]);

        ProductMerk::create([
            'name' => 'Tristar',
            'slug' => 'tristar',
            'image' => 'img/merk/tristar.png',
        ]);

        ProductMerk::create([
            'name' => 'Unilon',
            'slug' => 'unilon',
            'image' => 'img/merk/unilon.png',
        ]);

        // CartItem::factory(100)->create();
        // Order::factory(10)->create();
        // OrderItem::factory(100)->create();

        // Promo::factory(3)->create();


        AdminType::create([
            'admin_type' => 'Superadmin',
            'slug' => 'superadmin'
        ]);

        AdminType::create([
            'admin_type' => 'Administrators',
            'slug' => 'administrator'
        ]);

        AdminType::create([
            'admin_type' => 'Finance Administrator',
            'slug' => 'finance-administrator'
        ]);

        AdminType::create([
            'admin_type' => 'Warehouse Administrator',
            'slug' => 'warehouse-administrator'
        ]);

        // UserAdmin::factory(3)->create();
        // Admin::factory(3)->create();
        // UserAddress::factory(10)->create();
        // UserNotification::factory(50)->create();

        Admin::create([
            'username' => 'superadmin',
            'admin_type' => '1',
            'email' => 'superadmin@klikspl.com',
            'password' => bcrypt('12345')
        ]);
        Admin::create([
            'username' => 'adminklikspl',
            'admin_type' => '2',
            'email' => 'admin@klikspl.com',
            'password' => bcrypt('12345')
        ]);
        Admin::create([
            'username' => 'financeklikspl',
            'admin_type' => '3',
            'email' => 'finance@klikspl.com',
            'password' => bcrypt('12345')
        ]);
        Admin::create([
            'username' => 'warehouseklikspl',
            'admin_type' => '4',
            'email' => 'warehouse@klikspl.com',
            'password' => bcrypt('12345')
        ]);

        $csvFile = fopen(base_path("database/data/provinces.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                Province::create([
                    "province_id" => $data['0'],
                    "name" => $data['1']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

        $csvFile = fopen(base_path("database/data/cities.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                City::create([
                    "city_id" => $data['0'],
                    "province_id" => $data['1'],
                    "type" => $data['2'],
                    "name" => $data['3'],
                    "postal_code" => $data['4'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

        // $daftarProvinsi = RajaOngkir::provinsi()->all();
        // foreach ($daftarProvinsi as $provinceRow) {
        //     Province::create([
        //         'province_id' => $provinceRow['province_id'],
        //         'name'        => $provinceRow['province'],
        //     ]);
        //     $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
        //     foreach ($daftarKota as $cityRow) {
        //         City::create([
        //             'city_id'       => $cityRow['city_id'],
        //             'province_id'   => $provinceRow['province_id'],
        //             'type'          => $cityRow['type'],
        //             'name'          => $cityRow['city_name'],
        //             'postal_code'   => $cityRow['postal_code'],
        //         ]);
        //     }
        // }

        UserAddress::create([
            'user_id' => '5',
            'name' => 'Muhammad Riduan Indra Hariwijaya',
            'address' => 'Jl. Kasturi 1 RT32 RW07, Kel. Syamsudin Noor, Kec. Landasan Ulin, Kota Banjarbaru',
            'district' => '',
            'city_ids' => '35',
            'province_ids' => '13',
            'postal_code' => '70712',
            'telp_no' => '085248466297',
            'is_active' => '1'
        ]);

        OrderAddress::factory(10)->create();

        OrderAddress::create([
            'user_id' => '5',
            'name' => 'Muhammad Riduan Indra Hariwijaya',
            'address' => 'Jl. Kasturi 1 RT32 RW07, Kel. Syamsudin Noor, Kec. Landasan Ulin, Kota Banjarbaru',
            'district' => '',
            'city_ids' => '35',
            'province_ids' => '13',
            'postal_code' => '70712',
            'telp_no' => '085248466297',
        ]);

        PaymentMethod::create([
            'account_name' => 'CV. Sarana Prima Lestari',
            'name' => 'CIMB NIAGA',
            'type' => 'Transfer Bank',
            'account_number' => '12311239128318',
            'code' => 'CIMBNIAGA12311239128318',
            'Description' => '<ul>
            <li>Transaksi ini akan otomatis menggantikan tagihan CIMB NIAGA Virtual Account yang belum dibayar.</li>
            <li>Dapatkan Kode Pembayaran setelah klik "Bayar"</li>
            <li>Tidak disarankan bayar melalui bank lain agar transaksi dapat diproses tanpa kendala</li></ul>',
            'logo' => '/img/payment-method/cimb-logo.svg',
            'is_active' => '1'
        ]);

        PaymentMethod::create([
            'account_name' => 'CV. Sarana Prima Lestari',
            'name' => 'BNI',
            'type' => 'Transfer Bank',
            'account_number' => '450412312312',
            'code' => 'BNI450412312312',
            'Description' => '<ul>
            <li>Transaksi ini akan otomatis menggantikan tagihan BNI Virtual Account yang belum dibayar.</li>
            <li>Dapatkan Kode Pembayaran setelah klik "Bayar"</li>
            <li>Tidak disarankan bayar melalui bank lain agar transaksi dapat diproses tanpa kendala</li></ul>',
            'logo' => '/img/payment-method/bni-logo.svg',
            'is_active' => '1'
        ]);

        PaymentMethod::create([
            'account_name' => 'CV. Sarana Prima Lestari',
            'name' => 'BRI',
            'type' => 'Transfer Bank',
            'account_number' => '1231231312313131',
            'code' => 'BRI1231231312313131',
            'Description' => '<ul>
            <li>Transaksi ini akan otomatis menggantikan tagihan BRI Virtual Account yang belum dibayar.</li>
            <li>Dapatkan Kode Pembayaran setelah klik "Bayar"</li>
            <li>Tidak disarankan bayar melalui bank lain agar transaksi dapat diproses tanpa kendala</li></ul>',
            'logo' => '/img/payment-method/bri-logo.svg',
            'is_active' => '1'
        ]);

        PaymentMethod::create([
            'account_name' => 'CV. Sarana Prima Lestari',
            'name' => 'MANDIRI',
            'type' => 'Transfer Bank',
            'account_number' => '912391923193219',
            'code' => 'MANDIRI912391923193219',
            'Description' => '<ul>
            <li>Transaksi ini akan otomatis menggantikan tagihan MANDIRI Virtual Account yang belum dibayar.</li>
            <li>Dapatkan Kode Pembayaran setelah klik "Bayar"</li>
            <li>Tidak disarankan bayar melalui bank lain agar transaksi dapat diproses tanpa kendala</li></ul>',
            'logo' => '/img/payment-method/mandiri-logo.svg',
            'is_active' => '1'
        ]);

        PaymentMethod::create([
            'account_name' => 'CV. Sarana Prima Lestari',
            'name' => 'BCA',
            'type' => 'Transfer Bank',
            'account_number' => '82772127721812',
            'code' => 'BCA82772127721812',
            'Description' => '<ul>
            <li>Transaksi ini akan otomatis menggantikan tagihan BCA Virtual Account yang belum dibayar.</li>
            <li>Dapatkan Kode Pembayaran setelah klik "Bayar"</li>
            <li>Tidak disarankan bayar melalui bank lain agar transaksi dapat diproses tanpa kendala</li></ul>',
            'logo' => '/img/payment-method/bca-logo.svg',
            'is_active' => '1'
        ]);

        PaymentMethod::create([
            'account_name' => 'CV. Sarana Prima Lestari',
            'name' => 'COD',
            'type' => 'Cash On Delivery',
            'account_number' => '',
            'code' => 'COD',
            'Description' => '<ul>
            <li>Transaksi ini akan otomatis menggantikan tagihan COD Virtual Account yang belum dibayar.</li>
            <li>Dapatkan Kode Pembayaran setelah klik "Bayar"</li>
            <li>Tidak disarankan bayar melalui bank lain agar transaksi dapat diproses tanpa kendala</li></ul>',
            'logo' => NULL,
            'is_active' => '1'
        ]);

        SenderAddress::create([
            'name' => 'CV. Sarana Prima Lestari',
            'address' => 'Jl. Pramuka No.63 RT.11 Pemurus Luar, Banjarmasin-70236 Kalimantan Selatan, Indonesia',
            'district' => '',
            'city_ids' => '36',
            'province_ids' => '13',
            'postal_code' => '70236',
            'telp_no' => '05113269593',
            'is_active' => '1'
        ]);

        SenderAddress::create([
            'name' => 'CV. Sarana Prima Lestari - Sampit',
            'address' => 'Jl. Pramuka No.72 RT.47 RW.08 Mentawa Baru Hulu, Sampit-74322 Kalimantan Tengah, Indonesia',
            'district' => '',
            'city_ids' => '206',
            'province_ids' => '14',
            'postal_code' => '74322',
            'telp_no' => '05312060080',
            'is_active' => '1'
        ]);

        SenderAddress::create([
            'name' => 'CV. Sinar Mahakam Lestari',
            'address' => 'Jl. Ampera Blok D No.18 RT.022 Simpang Pasir Selatan, Samarinda Kalimantan Timur, Indonesia',
            'district' => '',
            'city_ids' => '387',
            'province_ids' => '15',
            'postal_code' => '0',
            'telp_no' => '05414104142',
            'is_active' => '1'
        ]);
        // OrderProductImage::factory(200)->create();
        // OrderProduct::factory(100)->create();

        Promo::create([
            'name' => 'Potongan 4% minimal belanja Rp150.000',
            'code' => 'KLIKSPL4%',
            'promo_type_id' => '1',
            'start_period' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-01 09:00:00'),
            'end_period' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-23 09:00:00'),
            'description' => 'ini deskripsi promo',
            'min_transaction' => 150000,
            'discount' => 4,
            'quota' => 5,
            'is_active' => 1,
            'admin_id' => 1,
            'company_id' => 1,
            'image' => 'assets/voucher.png'
        ]);

        Promo::create([
            'name' => 'Potongan Rp10.000 minimal belanja Rp150.000',
            'code' => 'KLIKSPL10K',
            'promo_type_id' => '2',
            'start_period' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-01 09:00:00'),
            'end_period' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-23 09:00:00'),
            'description' => 'ini deskripsi promo',
            'min_transaction' => 150000,
            'discount' => 10000,
            'quota' => 5,
            'is_active' => 1,
            'admin_id' => 1,
            'company_id' => 1,
            'image' => 'assets/voucher.png'
        ]);

        PromoType::create([
            'name' => 'discount_percent'
        ]);

        PromoType::create([
            'name' => 'discount_price'
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 1,
            'payment_method_id' => 1
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 1,
            'payment_method_id' => 2
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 1,
            'payment_method_id' => 3
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 1,
            'payment_method_id' => 4
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 1,
            'payment_method_id' => 5
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 2,
            'payment_method_id' => 1
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 2,
            'payment_method_id' => 2
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 2,
            'payment_method_id' => 3
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 2,
            'payment_method_id' => 4
        ]);

        PromoPaymentMethod::create([
            'promo_id' => 2,
            'payment_method_id' => 5
        ]);

        PromoBanner::create([
            'name' => 'promo shopee',
            'image' => 'img/banner/banner-1.jpg',
            'start_period' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-01 09:00:00'),
            'end_period' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-23 09:00:00'),
            'is_active' => 1,
            'admin_id' => 1,
            'company_id' => 1,
        ]);
    }
}
