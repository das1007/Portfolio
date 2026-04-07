<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Skill extends Model {
    protected $fillable = ['group_name','group_label','items','is_active','sort_order'];
    protected $casts = ['items'=>'array','is_active'=>'boolean'];
    public function scopeActive($q) { return $q->where('is_active',true)->latest(); }
}
