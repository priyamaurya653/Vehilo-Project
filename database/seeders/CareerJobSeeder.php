<?php

namespace Database\Seeders;

use App\Models\CareerJob;
use Illuminate\Database\Seeder;

/**
 * Careers page pe jo jobs pehle hard-coded the, wahi DB me daal deta hai.
 * Chalao:  php artisan db:seed --class=CareerJobSeeder
 */
class CareerJobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            ['Telecaller (Hindi/English)', 'sales',       'Delhi NCR', 'On-site', 'Full-time', 'Day',   '0–2 yrs', '₹18,000–25,000', 'month', 'Hindi, English', 15],
            ['Tele-Sales Executive',       'sales',       'Bengaluru', 'On-site', 'Full-time', 'Day',   '0–2 yrs', '₹20,000–30,000', 'month', null,              12],
            ['Inside Sales Executive',     'sales',       'Mumbai',    'On-site', 'Full-time', 'Day',   '1–3 yrs', '₹22,000–32,000', 'month', null,              10],
            ['Sales Team Lead',            'sales',       'Hyderabad', 'On-site', 'Full-time', 'Day',   '3–5 yrs', '₹35,000–45,000', 'month', null,               4],
            ['Telecaller – Night Shift',   'sales',       'Chennai',   'On-site', 'Full-time', 'Night', '0–2 yrs', '₹19,000–24,000', 'month', 'Tamil, English',   8],
            ['Senior Backend Engineer',    'engineering', 'Bengaluru', 'Hybrid',  'Full-time', null,    '4–6 yrs', '₹28–38 LPA',     'year',  null,              10],
            ['Frontend Engineer (React)',  'engineering', 'Remote',    'Remote',  'Full-time', null,    '2–4 yrs', '₹16–24 LPA',     'year',  null,               8],
            ['City Operations Manager',    'operations',  'Mumbai',    'On-site', 'Full-time', null,    '3–5 yrs', '₹14–18 LPA',     'year',  null,              12],
            ['Customer Support Executive', 'support',     'Pune',      'On-site', 'Full-time', null,    '0–2 yrs', '₹4–6 LPA',       'year',  null,               9],
            ['Product Designer',           'design',      'Remote',    'Remote',  'Full-time', null,    '2–4 yrs', '₹12–18 LPA',     'year',  null,               5],
            ['Performance Marketing Lead', 'marketing',   'Hyderabad', 'Hybrid',  'Full-time', null,    '4–7 yrs', '₹18–24 LPA',     'year',  null,               6],
        ];

        foreach ($jobs as $i => [$title, $dept, $city, $mode, $type, $shift, $exp, $salary, $period, $langs, $openings]) {
            CareerJob::updateOrCreate(
                ['title' => $title, 'city' => $city],
                [
                    'department'    => $dept,
                    'work_mode'     => $mode,
                    'job_type'      => $type,
                    'shift'         => $shift,
                    'experience'    => $exp,
                    'salary'        => $salary,
                    'salary_period' => $period,
                    'languages'     => $langs,
                    'openings'      => $openings,
                    'is_active'     => true,
                    'sort_order'    => $i + 1,
                ]
            );
        }
    }
}