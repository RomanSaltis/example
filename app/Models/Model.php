<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Model extends \Illuminate\Database\Eloquent\Model
{

//    public static function boot() {
//        parent::boot();
//        static::updated(function(\Illuminate\Database\Eloquent\Model $model){
//            $o = [];
//            $o[] = Carbon::now()->format('H:i:s');
//            $o[] = get_class($model);
//            $o[] = $model->id;
//            $o[] = 'updated';
//            $t = [];
//            foreach ($model->getDirty() as $prop => $val){
//                if ($prop == 'updated_at'){
//                    continue;
//                }
//                $t[] = "$prop ".$model->getOriginal()[$prop]." -> {$model->$prop}";
//            }
//            $o[] = implode(', ', $t);
//            file_put_contents(base_path(LOGFILE), implode(' ', $o)."\n" , FILE_APPEND);
//        });
//
//        static::created(function(\Illuminate\Database\Eloquent\Model $model){
//            $o = [];
//            $o[] = Carbon::now()->format('H:i:s');
//            $o[] = get_class($model);
//            $o[] = $model->id;
//            $o[] = 'created';
//            $t = [];
//            foreach ($model->getAttributes() as $prop => $val){
//                $t[] = "$prop -> {$model->$prop}";
//            }
//            $o[] = implode(', ', $t);
//            file_put_contents(base_path(LOGFILE), implode(' ', $o)."\n" , FILE_APPEND);
//        });
//    }
}
