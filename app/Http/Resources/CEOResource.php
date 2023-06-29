<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CEOResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'year' => $this->year,
            'company_headquarters' => $this->company_headquarters,
            'what_company_does' => $this->what_company_does,
        ];
    }
}
