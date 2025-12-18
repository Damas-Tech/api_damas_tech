<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this é um array simples vindo do MatchService
        return [
            'user_id' => $this['user_id'],
            'job_id' => $this['job_id'],
            'score' => $this['score'],
            'skill_score' => $this['skill_score'],
            'culture_score' => $this['culture_score'],
            'skills_matched' => $this['skills_matched'],
            'skills_missing' => $this['skills_missing'],
            'culture_matched' => $this['culture_matched'],
            'culture_missing' => $this['culture_missing'],
        ];
    }
}
