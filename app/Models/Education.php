<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Education extends Model {
    protected $table = 'educations';
    protected $fillable = ['degree','institution','location','period_start','period_end','emoji','badges','is_active','sort_order'];
    protected $casts = ['badges'=>'array','is_active'=>'boolean'];
    public function scopeActive($q) { return $q->where('is_active',true)->latest(); }
}
