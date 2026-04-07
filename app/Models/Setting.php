<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
    protected $fillable = ['key','value'];
    public static function get(string $key, $default = null) {
        try { $s = static::where('key',$key)->first(); return $s ? $s->value : $default; } catch(\Exception $e) { return $default; }
    }
    public static function set(string $key, $value): void {
        static::updateOrCreate(['key'=>$key],['value'=>$value]);
    }
    public static function allSettings(): array {
        try { return static::all()->pluck('value','key')->toArray(); } catch(\Exception $e) { return []; }
    }
}
