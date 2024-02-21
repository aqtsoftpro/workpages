<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Expr\Print_;

class AdminDashboardController extends Controller
{
    public function index(Request $request){

        $time = 'today';
        $val = Carbon::now();
        $column = 'created_at';
        $where = 'whereDate';
        $company_id = '';
        $user_id = '';
        $limit = 10;
        $records['sales'] = $this->sales($time, $where, $column, $val, $company_id, $user_id);
        $records['revenue'] =  $this->revenue($time, $where, $column, $val, $company_id, $user_id);
        $records['subscription_wise_earning'] =  $this->subscription_wise_earning();
        $records['jobs_posted'] = $this->jobs($time="", $where="", $column="",  $val="", $company_id="", $user_id="", $limit);
        $records['signups'] =  $this->signups();

        // dd($records['signups']);
   
        // DB::enableQueryLog();
        // $limit = 5;

        // if( $_GET ) {
        //     $startDate = $_GET['start'];
        //     $endDate = $_GET['end'];
        // }
        
        // // get posted jobs
        // $jobs = new Job();
        // $jobs_query = $jobs->newQuery();

        // if($_GET)
        // {
        //     $jobs_query->whereBetween('created_at', [$startDate, $endDate])->get();
        // }
        // $jobs_query->orderBy('created_at', 'desc');
        // $jobs_query->limit($limit);
        // $records['jobs_posted'] = $jobs_query->get();

        // $query = DB::getQueryLog();
        // dd($query);

        // echo $records['jobs'];
        // die();

        $records['companies'] = Company::count();
        $records['jobs'] = Job::count();
        $records['job_seekers'] = Role::find(2)->users->count();
        $records['applications'] = Application::count();

        return view('dashboard', compact('records'));

        die();
    }

    function stats_ajax_call(Request $request)
        {   

            if($request->time == 'Today')
                {
                    $val = Carbon::now();
                    $column = 'created_at';
                    $where = 'whereDate';
                    $company_id = '';
                    $user_id = '';
                    
                }
            if($request->time == 'This Month')
            {
                $currentDate = Carbon::now();
                $endDate = $currentDate->format('Y-m-d');

                $oneMonthAgo = $currentDate->subMonth();
                $startDate = $oneMonthAgo->format('Y-m-d');

                $val = [$startDate, $endDate];
                $column = 'created_at';
                $where = 'whereBetween';
                $company_id = '';
                $user_id = '';
            }
            if($request->time == 'This Year')
            {
                $currentDate = Carbon::now();
                $endDate = $currentDate->format('Y-m-d');

                $oneMonthAgo = $currentDate->subYear();
                $startDate = $oneMonthAgo->format('Y-m-d');

                $val = [$startDate, $endDate];
                $column = 'created_at';
                $where = 'whereBetween';
                $company_id = '';
                $user_id = '';
            }   
     
            if($request->state_type == 'sales')
            {
                $records =  $this->sales($request->time, $where, $column, $val, $company_id, $user_id);
            }
            if($request->state_type == 'revenue')
            {
                $records =  $this->revenue($request->time, $where, $column, $val, $company_id, $user_id);
            }
            if($request->state_type == 'signups')
            {
                $records =  $this->signups($request->time, $where, $column, $val, $company_id, $user_id);
            }
            if($request->state_type == 'jobs')
            {
                $records =  $this->jobs($request->time, $where, $column, $val, $company_id, $user_id);
            }
        
            $response = [
                'status' => 'success',
                'data' => $records
            ];
  
            return response()->json($response);

        }


    function jobs($time="", $where="", $column="",  $val="", $company_id="", $user_id="", $limit='')
    {  
        DB::enableQueryLog();

        $dotColorArray = array(
            "text-primary",
            "text-secondary",
            "text-success",
            "text-danger",
            "text-warning",
            "text-info",
            "text-light",
            "text-dark",
            "text-muted",
        );
        

        $jobs = new Job();
        $jobs_query = $jobs->newQuery();

        $n_query = new Job();
        $query = $n_query->newQuery();

        if($time)
        {
            $query->$where($column, $val);
        }

        $query->orderBy('created_at', 'desc');
        $query->limit($limit);
        
        $jobs = $query->get()->toArray();
        // $query = DB::getQueryLog();
        // dd($query);
       
        $result = '';
       
        foreach ($jobs as $job)
        {
            // echo "<pre>";
            // print_r($job);
            // echo "</pre>";
            $randomIndex = rand(0, count($dotColorArray) - 1);
            $result .= '<div class="activity-item d-flex">
              <div class="activite-label"></div>
              <i class="bi bi-circle-fill activity-badge '.$dotColorArray[$randomIndex].' align-self-start"></i>
              <div class="activity-content">'.$job['job_title'].'
           
              </div>
            </div>';

        }

        return $result;
    }

    function sales($time="", $where="", $column="",  $val="", $company_id="", $user_id="")
    {  
        DB::enableQueryLog();

        $n_query = new Subscription();
        $query = $n_query->newQuery();
        if($time)
        {
            $query->$where($column, $val);
        }

        $result = $query->count();
        // $query = DB::getQueryLog();
        // dd($query);

        return $result;
    }

    function revenue($time="", $where="", $column="",  $val="", $company_id="", $user_id="")
    {  
        DB::enableQueryLog();

        $n_query = new Subscription();
        $query = $n_query->newQuery();

        if($time)
        {
            $query->$where($column, $val);
        }

        $result = $query->sum('stripe_price');
        // $query = DB::getQueryLog();
        // dd($query);

        return $result;
    }

    function subscription_wise_earning($time="", $where="", $column="",  $val="", $company_id="", $user_id="")
    {  
        DB::enableQueryLog();

        $n_query = new Subscription();
        $query = $n_query->newQuery();

        if($time)
        {
            $query->$where($column, $val);
        }

        $subscriptions = Subscription::select('package_id', \DB::raw('SUM(stripe_price) as total_amount'))
        ->groupBy('package_id')
        ->get();
        
        $labels = array();
        $prices = array();
        foreach ($subscriptions as $subscription) {
            $package = Package::find($subscription->package_id);

            $labels[] = $package->name;
            $prices[] = $subscription->total_amount;
        }

        $result['labels'] = $labels;
        $result['prices'] = $prices;
        return $result;
    }


    function signups($time="", $where="", $column="",  $val="", $company_id="", $user_id="")
    { 
        
        $now = now();

        // $tenMonthsAgo = $now->copy()->subMonths(10);

        // $totalSignupCount = User::where('created_at', '>=', $tenMonthsAgo)
        //     ->count();

        // $roleWiseSignupCount = User::select('role_id', DB::raw('COUNT(*) as count'))
        //     ->where('created_at', '>=', $tenMonthsAgo)
        //     ->whereIn('role_id', [2, 3])
        //     ->groupBy('role_id')
        //     ->get();

        // $roleWiseSignupCount = User::select('id', DB::raw('COUNT(*) as count'))
        //     ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        //     ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        //     // ->where('model_has_roles.role_id', '2')
        //     // ->orWhere('model_has_roles.role_id', '3')
        //     ->whereIn('model_has_roles.role_id', [2, 3])
        //     ->get();

        $lastTenMonths = collect(range(-1, 10))->map(function ($month) {
            return Carbon::now()->subMonths($month)->startOfMonth();
        });
        

        foreach($lastTenMonths as $month)
        {

            // echo "<pre>";
            //     print_r((array)$month);
            // echo "</pre>";
            $getTime = (array)$month;
            // echo "<pre>";
            // echo $getTime['date'];
            // echo "</pre>";

            $split_date = explode('-', date('Y-m-d', strtotime($getTime['date'])));

            $year = $split_date[0];
            $month = $split_date[1];

            $query_result = DB::table('roles')
                ->select('roles.name as role_name')
                ->selectRaw('COUNT(users.id) as count')
                ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->leftJoin('users', 'model_has_roles.model_id', '=', 'users.id')
                ->whereYear('users.created_at', '=', $year)
                ->whereMonth('users.created_at', '=', $month)
                ->groupBy('roles.id', 'roles.name')
                ->orderBy('roles.id')
                ->get()->ToArray();  
            // echo "<pre>";
            // print_r($query_result);
            // echo "</pre>";
            foreach($query_result as $query_stat)
            {
                // print_r($query_stat);
                if($query_stat->role_name == 'Employer')
                {
                    $companies_data[] = $query_stat->count;
                    $company_add_to_total = $query_stat->count;
                    $total_signups['companies'] = array(
                        'label' => 'Companies',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 2,
                        'data' => $companies_data,
                    );
                }
                else
                {
                    
                    $companies_data[] = 0;
                    $company_add_to_total = 0;
                    $total_signups['companies'] = array(
                        'label' => 'Companies',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 2,
                        'data' => $companies_data,
                    );
                }
                if($query_stat->role_name == 'Job Seeker')
                {
                    $job_seeker_data[] = $query_stat->count;
                    $job_seeker_add_to_total = $query_stat->count;
                    $total_signups['job_seeker'] = array(
                        'label' => 'Job Seeker',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 2,
                        'data' => $job_seeker_data,
                    );
                }
                else
                {
                    
                    $job_seeker_data[] = 0;
                    $job_seeker_add_to_total = 0;
                    $total_signups['job_seeker'] = array(
                        'label' => 'Job Seeker',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 2,
                        'data' => $job_seeker_data,
                    );  
                }
                
                $total_signup_data[] = $job_seeker_add_to_total + $company_add_to_total;
                $total_signups['total_signups'] = array(
                    'label' => 'Signups',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                    'data' => $total_signup_data,
                );
            }

            $months[] = date('M', strtotime($getTime['date']));


        }

        $result['labels'] = $months;
        foreach($total_signups as $signup)
        {
            $result['signups'][] = $signup;
        }
        
        
        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";
        // echo json_encode($result['signups']);

        // echo "[
        //     {
        //       label: 'SignUps',
        //       backgroundColor: 'rgba(255, 99, 132, 0.2)',
        //       borderColor: 'rgba(255, 99, 132, 1)',
        //       borderWidth: 2,
        //       data: [12, 19, 3, 5, 2]
        //     },
        //     {
        //       label: 'Companies',
        //       backgroundColor: 'rgba(54, 162, 235, 0.2)',
        //       borderColor: 'rgba(54, 162, 235, 1)',
        //       borderWidth: 2,
        //       data: [7, 11, 5, 8, 3]
        //     },
        //     {
        //       label: 'Job Seekers',
        //       backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //       borderColor: 'rgba(75, 192, 192, 1)',
        //       borderWidth: 2,
        //       data: [9, 15, 8, 12, 6]
        //     }
        //   ]";
        //   echo "</pre>";
            // die();

        // echo "<pre>";
        //     print_r($result);
        // echo "</pre>";
        // $result['prices'] = $prices;
        // die();
        return $result;
    }



    function signupsbk($time="", $where="", $column="",  $val="", $company_id="", $user_id="")
    {  
        DB::enableQueryLog();

        $n_query = new Subscription();
        $query = $n_query->newQuery();

        if($time)
        {
            $query->$where($column, $val);
        }

        $subscriptions = Subscription::select('package_id', \DB::raw('SUM(stripe_price) as total_amount'))
        ->groupBy('package_id')
        ->get();
        
        $labels = array();
        $prices = array();
        foreach ($subscriptions as $subscription) {
            $package = Package::find($subscription->package_id);

            $labels[] = $package->name;
            $prices[] = $subscription->total_amount;
        }

        $result['labels'] = $labels;
        $result['prices'] = $prices;
        return $result;
    }




}
