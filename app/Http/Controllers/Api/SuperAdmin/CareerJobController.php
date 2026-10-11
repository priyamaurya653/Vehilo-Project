<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\CareerJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Super Admin – Job openings API (token based)
 *
 * GET    /api/v1/superadmin/career-jobs               list + search + filter + pagination + stats
 * POST   /api/v1/superadmin/career-jobs               add job (form)
 * GET    /api/v1/superadmin/career-jobs/{id}          show
 * PATCH  /api/v1/superadmin/career-jobs/{id}          edit
 * PATCH  /api/v1/superadmin/career-jobs/{id}/toggle   active / inactive
 * DELETE /api/v1/superadmin/career-jobs/{id}          delete
 */
class CareerJobController extends Controller
{
    private const SORTABLE = ['sort_order', 'created_at', 'title', 'department', 'city', 'openings'];

    private function ensureSuperadmin(Request $request): void
    {
        $role = strtolower(trim((string) optional($request->user())->role));

        abort_unless(
            in_array($role, ['superadmin', 'super_admin', 'super-admin'], true),
            403,
            'Only super admin can manage job openings.'
        );
    }

    private function rules(bool $partial = false): array
    {
        $req = $partial ? ['sometimes', 'required'] : ['required'];

        return [
            'title'         => [...$req, 'string', 'max:150'],
            'department'    => [...$req, Rule::in(array_keys(CareerJob::DEPARTMENTS))],
            'city'          => [...$req, 'string', 'max:100'],
            'work_mode'     => [...$req, Rule::in(CareerJob::WORK_MODES)],
            'job_type'      => [...$req, Rule::in(CareerJob::JOB_TYPES)],
            'shift'         => ['sometimes', 'nullable', Rule::in(CareerJob::SHIFTS)],
            'experience'    => [...$req, 'string', 'max:30'],
            'salary'        => [...$req, 'string', 'max:50'],
            'salary_period' => [...$req, Rule::in(CareerJob::SALARY_PERIODS)],
            'languages'     => ['sometimes', 'nullable', 'string', 'max:150'],
            'openings'      => [...$req, 'integer', 'min:1', 'max:999'],
            'description'   => ['sometimes', 'nullable', 'string', 'max:5000'],
            'requirements'  => ['sometimes', 'nullable', 'string', 'max:5000'],
            'is_active'     => ['sometimes', 'boolean'],
            'sort_order'    => ['sometimes', 'nullable', 'integer', 'min:0', 'max:100000'],
        ];
    }

    private function messages(): array
    {
        return [
            'department.in'    => 'Please select a valid department.',
            'work_mode.in'     => 'Please select a valid work mode.',
            'job_type.in'      => 'Please select a valid job type.',
            'openings.min'     => 'At least 1 opening is required.',
        ];
    }

    private function transform(CareerJob $job): array
    {
        return [
            'id'                 => $job->id,
            'title'              => $job->title,
            'department'         => $job->department,
            'department_name'    => $job->department_name,
            'city'               => $job->city,
            'work_mode'          => $job->work_mode,
            'job_type'           => $job->job_type,
            'shift'              => $job->shift,
            'experience'         => $job->experience,
            'salary'             => $job->salary,
            'salary_period'      => $job->salary_period,
            'salary_label'       => $job->salary . ' / ' . $job->salary_period,
            'languages'          => $job->languages,
            'openings'           => $job->openings,
            'description'        => $job->description,
            'requirements'       => $job->requirements,
            'requirements_list'  => $job->requirements_list,
            'is_active'          => (bool) $job->is_active,
            'sort_order'         => $job->sort_order,
            'applications_count' => (int) ($job->applications_count ?? 0),
            'created_date'       => optional($job->created_at)->format('d M Y'),
            'updated_human'      => optional($job->updated_at)->diffForHumans(),
        ];
    }

    /** Is job title pe kitni applications aayi (careers form ka "position") */
    private function withApplicationsCount($query)
    {
        return $query->select('career_jobs.*')->addSelect([
            'applications_count' => CareerApplication::selectRaw('COUNT(*)')
                ->whereColumn('career_applications.position', 'career_jobs.title'),
        ]);
    }

    /* ---------------- LIST ---------------- */
    public function index(Request $request): JsonResponse
    {
        $this->ensureSuperadmin($request);

        $request->validate([
            'search'     => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', Rule::in(array_keys(CareerJob::DEPARTMENTS))],
            'status'     => ['nullable', Rule::in(['active', 'inactive'])],
            'work_mode'  => ['nullable', Rule::in(CareerJob::WORK_MODES)],
            'sort'       => ['nullable', Rule::in(self::SORTABLE)],
            'dir'        => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page'   => ['nullable', 'integer', 'min:5', 'max:100'],
        ]);

        $query = $this->withApplicationsCount(CareerJob::query());

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")->orWhere('city', 'like', "%{$search}%");
            });
        }
        if ($request->filled('department')) $query->where('department', $request->department);
        if ($request->filled('work_mode'))  $query->where('work_mode', $request->work_mode);
        if ($request->filled('status'))     $query->where('is_active', $request->status === 'active');

        $sort = $request->input('sort', 'sort_order');
        $dir  = $request->input('dir', $sort === 'sort_order' ? 'asc' : 'desc');
        $query->orderBy($sort, $dir)->orderBy('id', 'desc');

        $paginator = $query->paginate((int) $request->input('per_page', 10));

        return response()->json([
            'success' => true,
            'data'    => collect($paginator->items())->map(fn ($j) => $this->transform($j))->values(),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
            'stats'   => [
                'total'    => CareerJob::count(),
                'active'   => CareerJob::active()->count(),
                'inactive' => CareerJob::where('is_active', false)->count(),
                'openings' => (int) CareerJob::active()->sum('openings'),
            ],
            'options' => [
                'departments'    => collect(CareerJob::DEPARTMENTS)->map(fn ($d, $k) => ['key' => $k, 'name' => $d['name']])->values(),
                'work_modes'     => CareerJob::WORK_MODES,
                'job_types'      => CareerJob::JOB_TYPES,
                'shifts'         => CareerJob::SHIFTS,
                'salary_periods' => CareerJob::SALARY_PERIODS,
            ],
        ]);
    }

    /* ---------------- CREATE (form) ---------------- */
    public function store(Request $request): JsonResponse
    {
        $this->ensureSuperadmin($request);

        $data = $request->validate($this->rules(), $this->messages());
        $data['is_active']  = $data['is_active'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? ((int) CareerJob::max('sort_order') + 1);

        $job = CareerJob::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Job opening added successfully.',
            'data'    => $this->transform($job),
        ], 201);
    }

    /* ---------------- SHOW ---------------- */
    public function show(Request $request, int $id): JsonResponse
    {
        $this->ensureSuperadmin($request);

        $job = $this->withApplicationsCount(CareerJob::query())->findOrFail($id);

        return response()->json(['success' => true, 'data' => $this->transform($job)]);
    }

    /* ---------------- EDIT ---------------- */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->ensureSuperadmin($request);

        $job  = CareerJob::findOrFail($id);
        $data = $request->validate($this->rules(true), $this->messages());

        if (array_key_exists('sort_order', $data) && $data['sort_order'] === null) {
            unset($data['sort_order']);
        }

        $job->update($data);

        $job = $this->withApplicationsCount(CareerJob::query())->find($job->id);

        return response()->json([
            'success' => true,
            'message' => 'Job opening updated successfully.',
            'data'    => $this->transform($job),
        ]);
    }

    /* ---------------- ACTIVE / INACTIVE ---------------- */
    public function toggle(Request $request, int $id): JsonResponse
    {
        $this->ensureSuperadmin($request);

        $job = CareerJob::findOrFail($id);
        $job->update(['is_active' => ! $job->is_active]);

        return response()->json([
            'success'   => true,
            'message'   => $job->is_active ? 'Job is now live on the careers page.' : 'Job hidden from the careers page.',
            'is_active' => $job->is_active,
        ]);
    }

    /* ---------------- DELETE ---------------- */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->ensureSuperadmin($request);

        CareerJob::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Job opening deleted successfully.']);
    }
}