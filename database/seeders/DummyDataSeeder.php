<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Staff;
use App\Models\Employee;
use App\Models\Visitor;
use App\Models\Visit;
use App\Models\Attendance;
use App\Models\Vehicle;
use App\Models\Item;
use App\Models\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Helper to generate Malaysian vehicle plates (e.g. BQW 5659)
     */
    private function generateMalaysianPlate($faker)
    {
        $prefixes = ['W', 'B', 'P', 'J', 'K', 'V', 'A', 'M', 'N', 'D', 'C', 'Q', 'S'];
        $prefix = $faker->randomElement($prefixes);
        $middle = strtoupper($faker->lexify($faker->boolean(70) ? '??' : '?'));
        $number = $faker->numberBetween(10, 9999);
        return "{$prefix}{$middle} {$number}";
    }

    public function run(): void
    {
        $faker = Faker::create();
        $departments = ['HR', 'IT', 'Operations', 'Maintenance', 'Security', 'Management', 'Technical Services', 'Fleet Logistics', 'Facilities Management', 'Executive Support'];

        // 1. Create Extra Users (Guards/Supervisors)
        $users = [];
        for ($i = 0; $i < 3; $i++) {
            $users[] = User::firstOrCreate(
                ['username' => 'guard' . ($i + 1)],
                [
                    'name' => $faker->name,
                    'password' => bcrypt('password'),
                    'role' => 'Guard',
                ]
            );
        }

        // 2. Create Staff & Attendances
        $staffMembers = [];
        for ($i = 0; $i < 50; $i++) {
            $staff = Staff::create([
                'name' => $faker->name,
                'department' => $faker->randomElement($departments),
            ]);
            $staffMembers[] = $staff;

            // Give some staff attendance records today
            if ($faker->boolean(80)) { // 80% present today
                $checkIn = Carbon::now()->subHours(rand(1, 8))->subMinutes(rand(0, 59));
                $checkOut = $faker->boolean(30) ? $checkIn->copy()->addHours(rand(4, 9)) : null; // 30% have checked out
                
                // 60% probability of bringing a vehicle
                $plate = $faker->boolean(60) ? $this->generateMalaysianPlate($faker) : null;

                Attendance::create([
                    'staff_id' => $staff->staff_id,
                    'vehicle_plate' => $plate,
                    'check_in_time' => $checkIn,
                    'check_out_time' => $checkOut,
                    'user_id' => $users[0]->user_id, // guard1 checked them in
                ]);
            }
        }

        // 3. Create Employees (Hosts)
        $employees = [];
        for ($i = 0; $i < 20; $i++) {
            $employees[] = Employee::create([
                'name' => $faker->name,
                'department' => $faker->randomElement($departments),
            ]);
        }

        // 4. Create Visitors & Visits
        $statuses = ['Pending', 'Active', 'Checked Out', 'Rejected'];
        for ($i = 0; $i < 40; $i++) {
            $employee = $faker->randomElement($employees);
            $status = $faker->randomElement($statuses);
            
            $visitDate = $faker->dateTimeBetween('-1 month', 'now');
            $passNumber = 'VP-' . strtoupper(Str::random(6));

            $visit = Visit::create([
                'employee_id' => $employee->employee_id,
                'user_id' => $users[0]->user_id,
                'pass_number' => $passNumber,
                'visit_date' => $visitDate->format('Y-m-d'),
                'check_in_time' => in_array($status, ['Active', 'Checked Out']) ? Carbon::instance($visitDate)->addHours(rand(8, 14))->format('H:i:s') : null,
                'check_out_time' => $status === 'Checked Out' ? Carbon::instance($visitDate)->addHours(rand(15, 18))->format('H:i:s') : null,
                'purpose' => $faker->sentence(3),
                'status' => $status,
            ]);

            // Add 1-3 Visitors per visit
            $numVisitors = rand(1, 3);
            for ($v = 0; $v < $numVisitors; $v++) {
                $visitor = Visitor::create([
                    'name' => $faker->name,
                    'ic_number' => $faker->numerify('######-##-####'),
                    'phone' => $faker->phoneNumber,
                    'company' => $faker->company,
                ]);
                $visit->visitors()->attach($visitor->visitor_id);
            }

            // Optional Vehicle with Malaysian Plate Format
            if ($faker->boolean(40)) {
                Vehicle::create([
                    'plate_number' => $this->generateMalaysianPlate($faker),
                    'vehicle_type' => $faker->randomElement(['Car', 'Motorcycle', 'Truck']),
                    'owner_type' => 'visitor',
                    'visit_id' => $visit->visit_id,
                ]);
            }

            // Optional Items
            if ($faker->boolean(50)) {
                Item::create([
                    'visit_id' => $visit->visit_id,
                    'item_name' => $faker->randomElement(['Laptop', 'Toolbox', 'Camera', 'Sample Box']),
                    'quantity' => rand(1, 3),
                    'remarks' => $faker->word,
                ]);
            }

            // Generate a notification for some visits
            if ($faker->boolean(30)) {
                Notification::create([
                    'user_id' => null, // Broadcast
                    'visit_id' => $visit->visit_id,
                    'message' => 'Visit update for pass ' . $visit->pass_number . ': Status is now ' . $visit->status,
                    'status' => $faker->randomElement(['Unread', 'Read']),
                ]);
            }
        }

        // Extra standalone notifications
        for ($i = 0; $i < 5; $i++) {
            Notification::create([
                'user_id' => null,
                'visit_id' => null,
                'message' => 'System Maintenance Scheduled for ' . Carbon::now()->addDays(rand(1,5))->format('M d, Y'),
                'status' => 'Unread',
            ]);
        }
    }
}
