<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model {
    protected $fillable = ['title','company_name','company_logo','description','tags','project_url','github_url','is_active','sort_order','featured'];
    protected $casts = ['tags'=>'array','is_active'=>'boolean','featured'=>'boolean'];
    public function scopeActive($q) { return $q->where('is_active',true)->orderBy('sort_order'); }
}
