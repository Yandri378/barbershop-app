<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barber;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Barbershop',
            'email' => 'admin@barbershop.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Create Customer Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        // Create Barbers
        $barbers = [
            [
                'name' => 'Rudi Hermawan',
                'phone' => '081234567890',
                'bio' => 'Potong rambut profesional dengan pengalaman lebih dari 10 tahun',
                'experience_years' => 10,
                'status' => 'available',
            ],
            [
                'name' => 'Budi Santoso',
                'phone' => '081234567891',
                'bio' => 'Spesialis potong rambut modern dan trendy',
                'experience_years' => 7,
                'status' => 'available',
            ],
            [
                'name' => 'Ahmad Supriadi',
                'phone' => '081234567892',
                'bio' => 'Pangkas tradisional dan modern tersedia',
                'experience_years' => 5,
                'status' => 'available',
            ],
        ];

        foreach ($barbers as $barber) {
            Barber::create($barber);
        }

        // Create Services
        $services = [
            [
                'name' => 'Potong Rambut Biasa',
                'description' => 'Potong rambut standar dengan gunting tradisional',
                'price' => 30000,
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Potong Rambut Modern',
                'description' => 'Potong rambut gaya modern dan trendy',
                'price' => 50000,
                'duration_minutes' => 45,
            ],
            [
                'name' => 'Cukur Kumis & Jenggot',
                'description' => 'Perawatan kumis dan jenggot profesional',
                'price' => 35000,
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Paket Lengkap',
                'description' => 'Potong rambut + cukur kumis + jenggot',
                'price' => 75000,
                'duration_minutes' => 60,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Sample Bookings & Payments
        $customers = User::where('role', 'customer')->get();
        $barbers = Barber::all();
        $services = Service::all();

        foreach ($customers as $index => $customer) {
            for ($i = 0; $i < 3; $i++) {
                $booking = Booking::create([
                    'customer_id' => $customer->id,
                    'barber_id' => $barbers[$i % count($barbers)]->id,
                    'service_id' => $services[$i % count($services)]->id,
                    'booking_date' => now()->addDays($i + 1)->setHour(10 + $i)->setMinute(0),
                    'status' => ['pending', 'approved', 'completed'][$i % 3],
                ]);

                // Create Payment
                $service = $services[$i % count($services)];
                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $service->price,
                    'status' => ['pending', 'paid', 'paid'][$i % 3],
                    'payment_method' => $i % 2 === 0 ? 'transfer' : 'cash',
                ]);
            }
        }
    }
}

