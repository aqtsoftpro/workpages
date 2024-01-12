<?php 
use App\Models\SiteSettings;

if (! function_exists('get_site_setting')) {
    function get_site_setting($key = '')
    {
        $setting = SiteSettings::select('meta_val')->where('meta_key', $key)->first()->toArray();
        $return_setting = $setting['meta_val'];
        return $return_setting;
    }
}


// if (! function_exists('get_site_logo')) {
//     function get_site_logo($key = '')
//     {
//         $setting = SiteSettings::select('meta_val')->where('meta_key', $key)->first()->toArray();



//         $return_setting = $setting['meta_val'];
//         if($return_setting)
//             {
//                 $return_img = url($return_setting);
//             }
//             else
//             {
//                 $return_img = url($return_setting);
//             }

//         return $return_img;
//     }
// }




?>