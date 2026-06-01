<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Demo regular user
        User::updateOrCreate(
            ['email' => 'demo@user.test'],
            [
                'nama' => 'Demo User',
                'email' => 'demo@user.test',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'location' => 'Kota Demo',
                'bio' => 'Akun demo untuk pengujian fitur user.',
                'avatar' => null,
                'status' => 'active',
            ]
        );

        // Demo mitra account (as a user record for demo purposes)
        User::updateOrCreate(
            ['email' => 'demo@mitra.test'],
            [
                'nama' => 'Demo Mitra',
                'email' => 'demo@mitra.test',
                'password' => Hash::make('password'),
                'phone' => '081298765432',
                'location' => 'Kota Mitra',
                'bio' => 'Akun demo untuk pengujian mitra.',
                'avatar' => null,
                'status' => 'active',
            ]
        );

        // Create sample service and portfolio for demo mitra
        $mitra = User::where('email', 'demo@mitra.test')->first();
        if ($mitra) {
            // sample service
            Service::updateOrCreate(
                ['user_id' => $mitra->id, 'nama_layanan' => 'Jasa Kebersihan Kamar'],
                [
                    'kategori' => 'KEBERSIHAN',
                    'deskripsi' => 'Pembersihan kamar, jemput dan antar, serta perawatan ringan.',
                    'harga_mulai' => 25000,
                    'harga_max' => 50000,
                    'satuan' => 'per kunjungan',
                    'durasi_estimasi' => 120,
                    'area_layanan' => 'Kota Mitra',
                    'foto' => null,
                    'status' => 'active',
                ]
            );

            // sample portfolio
            $portfolio = Portfolio::updateOrCreate(
                ['user_id' => $mitra->id, 'judul' => 'Pembersihan Kamar Kost A'],
                [
                    'deskripsi' => 'Before & after pembersihan kamar kos kecil.',
                    'kategori' => 'KEBERSIHAN',
                    'tanggal_project' => now()->subDays(30)->toDateString(),
                    'client_name' => 'Kost Pelangi',
                    'lokasi' => 'Kota Mitra',
                    'nilai_project' => 150000,
                    'durasi_hari' => 1,
                    'foto_cover' => null,
                    'rating' => 4.5,
                    'status' => 'published',
                ]
            );

            if ($portfolio && !PortfolioImage::where('portfolio_id', $portfolio->id)->exists()) {
                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image_path' => 'img/illustrations/sample-portfolio.jpg',
                    'caption' => 'Hasil pembersihan sebelum dan sesudah',
                    'urutan' => 0,
                ]);
            }
        }
    }
}

