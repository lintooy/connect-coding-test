<?php

namespace App\Services;

use App\Enums\JobStatus;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ValidatedInput;

class JobService
{
    /**
     * Get a list of all jobs.
     *
     * @param Request $request
     * 
     * @return LengthAwarePaginator
     */
    public function allJobs(Request $request): LengthAwarePaginator
    {
        return Job::paginate($request->per_page);
    }

    /**
     * Get a list of all open jobs.
     *
     * @param Request $request
     * 
     * @return LengthAwarePaginator
     */
    public function allOpenJobs(Request $request): LengthAwarePaginator
    {
        return Job::where('status', JobStatus::Open)->paginate($request->per_page);
    }

    /**
     * Create a new job.
     *
     * @param ValidatedInput $request
     * 
     * @return Job
     */
    public function createJob(ValidatedInput $request): Job
    {
        $request->status = JobStatus::fromKey($request->status);
        return Job::create($request->toArray());
    }

    /**
     * Update job information.
     *
     * @param ValidatedInput $request
     * @param Job $job
     * 
     * @return Job
     */
    public function updateJob(ValidatedInput $request, Job $job): Job
    {
        $request->status = JobStatus::fromKey($request->status);
        $job->update($request->toArray());
        $job->refresh();

        return $job;
    }
}
