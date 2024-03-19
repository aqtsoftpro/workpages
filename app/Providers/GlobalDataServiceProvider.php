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
            
    
            $notifications = Notification::whereIn('type', $notifi_arry)->where('is_seen', false)->latest()->get()->groupBy('type')->toArray();

            // dd($notifications);

            $notification_count = Notification::whereIn('type', $notifi_arry)->where('is_seen', false)->count();

            $notification_result = '';

            foreach ($notifications as $type => $items) {
                // Add heading for the type
                $note_type = '';
                if ($type == '_notification_newsletter') {
                    $note_type = 'News & Letters';
                } else if ($type == '_notification_job_activity') {
                    $note_type = 'New Activities On Job';
                } else if ($type == '_notification_package_subscription') {
                    $note_type = 'New Package Subscriptions';
                }

                
            
                $notification_result .= '<li class="notification-item">
                                            <h4>'.$note_type.'</h4>
                                          </li>
                                          <li>
                                            <hr class="dropdown-divider">
                                          </li>';
            
                // Iterate over items of this type
                foreach ($items as $item) {
                    // Add item details
                    $icon = '';
                    if ($item['type'] == '_notification_job_activity' || $item['type'] == '_notification_package_subscription') {
                        $icon = 'bi-check-circle text-success';
                    }
            
                    $notification_result .= '<a href="javascript:void(0)" class="show-notify" onclick="showNote('.$item['id'].')" id="link-'.$item['id'].'">
                                                <li class="notification-item">
                                                    <i class="'.$icon.'"></i>
                                                    <div>
                                                        <h4>'.$item['name'].'</h4>
                                                        <p>'.$item['desc'].'</p>
                                                        <p>'.$item['created_at'].'</p>
                                                    </div>
                                                </li>
                                              </a>
                                              <li>
                                                <hr class="dropdown-divider">
                                              </li>';
                }
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


