<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_name',
        'contact_email',
        'contact_phone_number',
        'company_name',
        'company_address',
        'company_city',
        'company_zip',
        'company_vat'
    ];

    public function setCompanyNameAttribute($value): void
    {
        $this->attributes['company_name'] = ucfirst($value);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
