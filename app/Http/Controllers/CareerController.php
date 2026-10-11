<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\CareerJob;
use Illuminate\Http\Request;

/**
 * Public website – Careers page
 *  index() : DB se active jobs laa ke careers page dikhata hai
 *  apply() : application form save karta hai (career_applications table)
 */
class CareerController extends Controller
{
    public function index()
    {
        $jobRows = CareerJob::active()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        // ---------- Job cards ke liye data (blade isi format me chahta hai) ----------
        $jobs = $jobRows->map(function (CareerJob $job) {
            $specs = [];

            // 1) Work mode
            $specs[] = $job->work_mode === 'On-site'
                ? ['pin', 'On-site']
                : ['laptop', $job->work_mode];

            // 2) Shift / job type
            if ($job->shift === 'Night') {
                $specs[] = ['moon', 'Night shift'];
            } elseif ($job->shift) {
                $specs[] = ['clock', $job->shift . ' shift'];
            } else {
                $specs[] = ['clock', $job->job_type];
            }

            // 3) Languages ya experience
            $specs[] = $job->languages
                ? ['lang', $job->languages]
                : ['cap', $job->experience];

            return [
                'id'     => $job->id,
                'title'  => $job->title,
                'dept'   => $job->department,
                'icon'   => CareerJob::DEPARTMENTS[$job->department]['icon'] ?? 'briefcase',
                'city'   => $job->city,
                'specs'  => $specs,
                'salary' => $job->salary,
                'per'    => $job->salary_period === 'year' ? 'per year' : 'per month',
            ];
        })->values()->all();

        // ---------- Department wise total openings ----------
        $deptCounts = $jobRows
            ->groupBy('department')
            ->map(fn ($group) => (int) $group->sum('openings'))
            ->all();

        // ---------- Department wise role names (hero tabs ke chips) ----------
        $deptRoles = $jobRows
            ->groupBy('department')
            ->map(fn ($group) => $group->pluck('title')->unique()->take(4)->values()->all())
            ->all();

        // ---------- Form ke "Preferred City" me job wali cities bhi ----------
        $jobCities = $jobRows->pluck('city')->unique()->values()->all();

        return view('pages.careers', compact('jobs', 'deptCounts', 'deptRoles', 'jobCities'));
    }

    public function apply(Request $request)
    {
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:100'],
            'phone'           => ['required', 'string', 'max:20'],
            'email'           => ['required', 'email', 'max:150'],
            'department'      => ['required', 'string', 'max:100'],
            'position'        => ['required', 'string', 'max:150'],
            'city'            => ['required', 'string', 'max:100'],
            'experience'      => ['required', 'string', 'max:20'],
            'languages'       => ['nullable', 'string', 'max:150'],
            'expected_salary' => ['required', 'string', 'max:50'],
            'notice_period'   => ['required', 'string', 'max:30'],
            'resume'          => ['required', 'file', 'mimes:pdf,doc,docx', 'max:3072'],
            'message'         => ['nullable', 'string', 'max:2000'],
            'consent'         => ['accepted'],
        ], [
            'resume.mimes'     => 'Resume must be a PDF, DOC or DOCX file.',
            'resume.max'       => 'Resume must be smaller than 3MB.',
            'consent.accepted' => 'Please confirm the details and give consent.',
        ]);

        // Resume private storage me (sirf superadmin API se download hoga)
        $data['resume']  = $request->file('resume')->store('resumes/careers', 'local');
        $data['consent'] = true;
        $data['status']  = 'pending';

        CareerApplication::create($data);

        return back()->with('success', 'Application submitted! Our team will contact you within 3 days.');
    }
}