<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobStoreRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class JobController extends Controller
{

    public function __construct(protected JobService $jobService)
    {
    }

    /**
     * Get a list of opening jobs to applicants.
     *
     * @param Request $request
     * 
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        return JobResource::collection($this->jobService->allOpenJobs($request));
    }

    /**
     * Show a opening job to applicants.
     *
     * @param Job $job
     * 
     * @return JobResource
     */
    public function show(Job $job): JobResource
    {
        return new JobResource($job);
    }

    /**
     * Get a list of opening jobs to applicants by admin.
     *
     * @param Request $request
     * 
     * @return ResourceCollection
     */
    public function viewByAdmin(Request $request): ResourceCollection
    {
        return JobResource::collection($this->jobService->allJobs($request));
    }

    /**
     * Show a opening job to applicants by admin.
     *
     * @param Job $job
     * 
     * @return JobResource
     */
    public function showByAdmin(Job $job): JobResource
    {
        return new JobResource($job);
    }

    /**
     * Register a job by admin.
     *
     * @param JobStoreRequest $request
     * 
     * @return JobResource
     */
    public function store(JobStoreRequest $request): JobResource
    {
        return new JobResource($this->jobService->createJob($request->safe()));
    }

    /**
     * Update job by admin.
     *
     * @param JobStoreRequest $request
     * @param Job $job
     * 
     * @return JobResource
     */
    public function update(JobStoreRequest $request, Job $job): JobResource
    {
        return new JobResource($this->jobService->updateJob($request->safe(), $job));
    }

    /**
     * Delete job by admin.
     *
     * @param Job $job
     * 
     * @return Response
     */
    public function destroy(Job $job): Response
    {
        $job->delete();
        return response()->noContent();
    }
}
