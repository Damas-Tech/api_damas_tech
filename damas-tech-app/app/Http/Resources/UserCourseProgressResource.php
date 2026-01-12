<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCourseProgressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'users_id' => $this->users_id,
            'course_id' => $this->course_id,
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
