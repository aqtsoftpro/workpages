<?php

namespace App\Models;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class SiteSettings extends Model
{
    use HasFactory;
    protected $table = 'site_settings';
    protected $fillable = [
        'meta_key',
        'meta_val',
        'site_name',
        'admin_email',
        'language_id',
        'timezone_id',
        'email_template',
        'sms_template',
        'notification'
    ];

    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function timezine(){
        return $this->belongsTo(Timezine::class);
    }

    static function update_setting($settingsArray = array())
    {
   
        if($settingsArray)
        {
            foreach($settingsArray as $key => $val)
            {
                echo $key.'='.$val;
                echo "<br>";
                $key_exist = DB::table('site_settings')->where('meta_key', $key)->first();
                if($key_exist)
                    {
                        DB::table('site_settings')
                        ->where('meta_key', $key)
                        ->update(['meta_val' => $val]);
                    }
                    else
                    {
                        
                        if($val)
                        {

                            DB::table('site_settings')->insert([
                                'meta_key' => $key,
                                'meta_val' => $val
                            ]);
                        }
                    }
            }
    
        }


    }

    static function updateRow($key, $value)
    {
        $settings = self::where('meta_key', $key)->first();
        DB::beginTransaction();
        try {
            if ($settings) {
                $settings->meta_val = $value;
                $settings->save();
                DB::commit();
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return $th;
        }


    }
}
