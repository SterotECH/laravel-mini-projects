<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone_number' => $this->contact_phone_number,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'company_city' => $this->company_city,
            'company_town' => $this->company_town,
        ];
    }
}
