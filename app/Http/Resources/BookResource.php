<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=> $this->id,
            'kitab_adi'=>$this->title,
            'istifadeci_adi'=>$this->user?$this->user->name : "Bilinmir",
            'kategoriya_adi'=>$this->category ? $this->category->name : "Kateqoriyasiz",
            'tagler'=>$this->tags->pluck('name'),
            'qiymet'=>$this->price . 'AZN',
            'yaranma_tarixi'=>$this->created_at->format('d-m-Y H:i'),
        ];
    }
}
