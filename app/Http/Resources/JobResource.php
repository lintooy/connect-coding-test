<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'company'     => new CompanyResource($this->company),
            'job_title'   => new JobTitleResource($this->jobTitle),
            'description' => $this->description,
            'status'      => $this->status->key,
            'created_at'  => $this->created_at->timestamp,
            'updated_at'  => $this->updated_at->timestamp,
        ];
    }
}
