<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CareerApplicationController extends Controller
{
    /**
     * List all career applications
     */
    /**
     * Create a new career application (SuperAdmin)
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [

                'name' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'phone' => [
                    'required',
                    'string',
                    'max:20'
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255'
                ],

                'department' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'position' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'city' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'experience' => [
                    'required',
                    'string',
                    'max:100'
                ],

                'languages' => [
                    'nullable',
                    'string',
                    'max:255'
                ],

                'expected_salary' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'notice_period' => [
                    'required',
                    'string',
                    'max:100'
                ],

                'message' => [
                    'nullable',
                    'string'
                ],

                'consent' => [
                    'sometimes',
                    'boolean'
                ],

                'status' => [
                    'sometimes',
                    'required',
                    'in:pending,reviewed,shortlisted,rejected,hired'
                ],

                'admin_remarks' => [
                    'nullable',
                    'string'
                ],

                'resume' => [
                    'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:3072'
                ],

            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Prepare Data
        |--------------------------------------------------------------------------
        */

        $data = $validator->validated();

        $data['status'] = $data['status'] ?? 'pending';
        $data['consent'] = $data['consent'] ?? false;


        /*
        |--------------------------------------------------------------------------
        | Resume Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('resume')) {

            $data['resume'] = $request
                ->file('resume')
                ->store('career-resumes', 'public');

        }


        $application = CareerApplication::create($data);


        return response()->json([
            'status' => true,
            'message' => 'Career application created successfully.',
            'data' => $application,
        ], 201);
    }
    public function index(Request $request)
    {
        $query = CareerApplication::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status') && $request->status !== 'all') {

            $query->where('status', $request->status);

        }


        /*
        |--------------------------------------------------------------------------
        | Department Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('department') && $request->department !== 'all') {

            $query->where(
                'department',
                $request->department
            );

        }


        /*
        |--------------------------------------------------------------------------
        | City Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('city') && $request->city !== 'all') {

            $query->where(
                'city',
                $request->city
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Experience Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('experience') && $request->experience !== 'all') {

            $query->where(
                'experience',
                $request->experience
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [
            'total' => CareerApplication::count(),

            'pending' => CareerApplication::where(
                'status',
                'pending'
            )->count(),

            'reviewed' => CareerApplication::where(
                'status',
                'reviewed'
            )->count(),

            'shortlisted' => CareerApplication::where(
                'status',
                'shortlisted'
            )->count(),

            'rejected' => CareerApplication::where(
                'status',
                'rejected'
            )->count(),

            'hired' => CareerApplication::where(
                'status',
                'hired'
            )->count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage = (int) $request->get(
            'per_page',
            15
        );

        if ($perPage < 1) {
            $perPage = 15;
        }

        if ($perPage > 100) {
            $perPage = 100;
        }


        $applications = $query
            ->latest('id')
            ->paginate($perPage)
            ->appends($request->query());


        return response()->json([
            'status' => true,

            'message' => 'Career applications fetched successfully.',

            'stats' => $stats,

            'data' => $applications,

        ]);
    }


    /**
     * Show single application
     */
    public function show($id)
    {
        $application = CareerApplication::find($id);

        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Career application not found.',
            ], 404);

        }


        return response()->json([
            'status' => true,
            'message' => 'Career application fetched successfully.',
            'data' => $application,
        ]);
    }


    /**
     * Update application
     */
    public function update(Request $request, $id)
    {
        $application = CareerApplication::find($id);

        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Career application not found.',
            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [

                'name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255'
                ],

                'phone' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:20'
                ],

                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    'max:255'
                ],

                'department' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255'
                ],

                'position' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255'
                ],

                'city' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255'
                ],

                'experience' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100'
                ],

                'languages' => [
                    'nullable',
                    'string',
                    'max:255'
                ],

                'expected_salary' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255'
                ],

                'notice_period' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100'
                ],

                'message' => [
                    'nullable',
                    'string'
                ],

                'consent' => [
                    'sometimes',
                    'boolean'
                ],

                'status' => [
                    'sometimes',
                    'required',
                    'in:pending,reviewed,shortlisted,rejected,hired'
                ],

                'admin_remarks' => [
                    'nullable',
                    'string'
                ],

                'resume' => [
                    'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:3072'
                ],

            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Update Data
        |--------------------------------------------------------------------------
        */

        $data = $validator->validated();


        /*
        |--------------------------------------------------------------------------
        | Resume Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('resume')) {

            // Delete old resume
            if (
                !empty($application->resume) &&
                Storage::disk('public')->exists(
                    $application->resume
                )
            ) {

                Storage::disk('public')->delete(
                    $application->resume
                );

            }


            $data['resume'] = $request
                ->file('resume')
                ->store('career-resumes', 'public');
        }


        $application->update($data);


        return response()->json([
            'status' => true,
            'message' => 'Career application updated successfully.',
            'data' => $application->fresh(),
        ]);
    }


    /**
     * Delete application
     */
    public function destroy($id)
    {
        $application = CareerApplication::find($id);

        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Career application not found.',
            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Delete Resume
        |--------------------------------------------------------------------------
        */

        if (
            !empty($application->resume) &&
            Storage::disk('public')->exists(
                $application->resume
            )
        ) {

            Storage::disk('public')->delete(
                $application->resume
            );

        }


        $application->delete();


        return response()->json([
            'status' => true,
            'message' => 'Career application deleted successfully.',
        ]);
    }


    /**
     * View / Download Resume
     */
    public function resume($id)
    {
        $application = CareerApplication::find($id);

        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Career application not found.',
            ], 404);

        }


        if (empty($application->resume)) {

            return response()->json([
                'status' => false,
                'message' => 'Resume not available.',
            ], 404);

        }


        $path = $application->resume;


        /*
        |--------------------------------------------------------------------------
        | If database contains full public URL
        |--------------------------------------------------------------------------
        */

        if (
            filter_var(
                $path,
                FILTER_VALIDATE_URL
            )
        ) {

            return redirect()->away($path);

        }


        /*
        |--------------------------------------------------------------------------
        | Check Storage
        |--------------------------------------------------------------------------
        */

        if (!Storage::disk('public')->exists($path)) {

            return response()->json([
                'status' => false,
                'message' => 'Resume file not found.',
            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Return File
        |--------------------------------------------------------------------------
        */

        return Storage::disk('public')->response(
            $path,
            basename($path)
        );
    }
}