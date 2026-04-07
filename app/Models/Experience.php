<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Experience extends Model {
    protected $fillable = ['role','company','location','period_start','period_end','description','bullets','tags','is_active','sort_order'];
    protected $casts = ['bullets'=>'array','tags'=>'array','is_active'=>'boolean'];
    public function scopeActive($q) { return $q->where('is_active',true)->latest(); }
}
