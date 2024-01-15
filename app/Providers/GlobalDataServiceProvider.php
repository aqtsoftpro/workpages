<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\SiteSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class GlobalDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {


        View::composer('layouts.header', function ($view) {

            $notifi_arry = array();
            $_notification_job_activity = SiteSettings::select('meta_val')->where('meta_key', '_notification_job_activity')->first()->toArray();
            // print_r($_notification_job_activity);
            if($_notification_job_activity['meta_val'] == 1)
            {
                $notifi_arry[] = '_notification_job_activity';
            }
    
            $_notification_package_subscription = SiteSettings::select('meta_val')->where('meta_key', '_notification_package_subscription')->first()->toArray();
            if($_notification_package_subscription['meta_val'] == 1)
            {
                $notifi_arry[] = '_notification_package_subscription';
            }
            
    
            $notifications = Notification::whereIn('type', $notifi_arry)->get()->toArray();

            $notification_count = Notification::whereIn('type', $notifi_arry)->count();

      
            $notification_result  = '';
            foreach($notifications as $noti)
                {
              
                    if($noti['type'] == '_notification_job_activity')
                        {
                            $icon = 'bi-check-circle text-success';
                        }
                    elseif($noti['type'] == '_notification_package_subscription ')
                        {
                            $icon = 'bi-check-circle text-success';
                        }
                    $notification_result .= '<li class="notification-item">
                        <i class="bi '.$icon.'"></i>
                        <div>
                            <h4>'.$noti['name'].'</h4>
                            <p>'.$noti['desc'].'</p>
                            <p>2 hrs. ago</p>
                        </div>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                  </li>
                    ';

                    }
            

            $headerData = [
                'notification_list' => $notification_result,
                'notification_count' => $notification_count,
                // Add more key-value pairs as needed
            ];

       

            $view->with('headerData', $headerData);
        });
    }
}


