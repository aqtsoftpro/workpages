<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Sector;
use App\Models\Language;
use App\Models\Location;
use App\Models\Timezone;
use App\Models\Technology;
use App\Models\JobCategory;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use PHPUnit\Event\Exception;
use App\Models\GlobalVariable;
use Laravel\Cashier\PaymentMethod;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class AdminSettingsController extends Controller
{
    public function index(){
        $this->authorize('viewAny', SiteSettings::class);
        $languages = Language::all();
        $timezones = Timezone::all();
        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();

        $notification = [
            ['id' => 1, 'name' => 'Enable'],
            ['id' => 0, 'name' => 'Disable']
        ];
    
        return view('admin.settings.site_settings', compact('languages', 'timezones', 'notification', 'settings'));

        die();
    }

    public function update_main_settings(Request $request){

        $this->authorize('create', SiteSettings::class);

        $settings = $request->input('setting', []);
   
        if($request->setting_form_type == 'slider_settings')
        {
            if($request->file('_slider_img'))
            {
                $FileName = 'slider-img-'.time().'-'.rand(100000,1000000).'.'.$request->file('_slider_img')->extension();
                $request->file('_slider_img')->storeAs('public', $FileName);
                
                if(isset($FileName)){
                    $img_array['_slider_img'] = env('APP_URL') . 'storage/' . $FileName;
                    SiteSettings::update_setting($img_array);
                }
            }

        }


        if($request->setting_form_type == 'design_settings')
        {
            
            if($request->file('_site_logo'))
            {
                $FileName = 'site-logo-'.time().'-'.rand(100000,1000000).'.'.$request->file('_site_logo')->extension();
                $request->file('_site_logo')->storeAs('public', $FileName);
                
                if(isset($FileName)){
                    echo $img_array['_site_logo'] = env('APP_URL') . 'storage/' . $FileName;
                    SiteSettings::update_setting($img_array);
                }
            }

  
            if($request->file('_site_favicon'))
            {
                $FileName = 'site_favicon-'.time().'-'.rand(100000,1000000).'.'.$request->file('_site_favicon')->extension();
                $request->file('_site_favicon')->storeAs('public', $FileName);
                
                if(isset($FileName)){
                    $img_array['_site_favicon'] = env('APP_URL') . 'storage/' . $FileName;
                    SiteSettings::update_setting($img_array);
                }
            }

        }
  


        if($request->setting_form_type == 'payment_gateway_settings')
        {
            if(isset($request->_strip_status))
                {
                    $settings['_strip_status'] = 1;
                }
                else
                {
                    $settings['_strip_status'] = 0;
                }

        }

        if($request->setting_form_type == 'notification_settings')
        {
            if(isset($request->_notification_newsletter))
                {
                    $settings['_notification_newsletter'] = 1;
                }
                else
                {
                    $settings['_notification_newsletter'] = 0;
                };

            if(isset($request->_notification_job_activity))
                {
                    $settings['_notification_job_activity'] = 1;
                }
                else
                {
                    $settings['_notification_job_activity'] = 0;
                }
            if(isset($request->_notification_package_subscription))
                {
                    $settings['_notification_package_subscription'] = 1;
                }
                else
                {
                    $settings['_notification_package_subscription'] = 0;
                }

        }
        // echo "<pre>";
        // print_r($request->setting);
        // echo "</pre>";

        $request->merge(['setting' => $settings]);

        SiteSettings::update_setting($request->setting);

        // die();
        

        if($request->setting_form_type == 'payment_gateway_settings')
        {
            $response_msg = 'Payment gateway settings updated successfully';
        }
        elseif($request->setting_form_type == 'general_settings')
        {
            $response_msg = 'General settings updated successfully';
        }
        elseif($request->setting_form_type == 'social_media_settings')
        {
            $response_msg = 'Social Media settings updated successfully';
        }
        elseif($request->setting_form_type == 'design_settings')
        {
            $response_msg = 'Design settings updated successfully';
        }
        elseif($request->setting_form_type == 'mailchimp_settings')
        {
            $response_msg = 'Mailchimp setting updated successfully';
        }
        elseif($request->setting_form_type == 'twilio_settings')
        {
            $response_msg = 'Twilio setting updated successfully';
        }
        elseif($request->setting_form_type == 'slider_settings')
        {
            $response_msg = 'Slider setting updated successfully';
        }
        elseif($request->setting_form_type == 'job_seeker_settings')
        {
            $response_msg = 'Job Seeker setting updated successfully';
        }
        elseif($request->setting_form_type == 'notification_settings')
        {
            $response_msg = 'Notification updated successfully';
        }


        return redirect()->back()->with('success', $response_msg);
    }

    public function design_settings(){

        $this->authorize('create', SiteSettings::class);

        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();

        return view('admin.settings.design_settings',  compact('settings'));
    }

    public function social_media_settings()
    {
        $this->authorize('create', SiteSettings::class);

        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();

        return view('admin.settings.social_media_settings',  compact( 'settings'));
    }

    public function payment_settings(){
        $this->authorize('create', SiteSettings::class);

        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();

        return view('admin.settings.payment_settings',  compact( 'settings'));
    }

    
    public function notification_settings(){
        $this->authorize('create', SiteSettings::class);

        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();

        return view('admin.settings.notification_settings',  compact( 'settings'));
    }

    public function checkout(){

        $stripe = new \Stripe\StripeClient('sk_test_51NAG7cD44LmC2yIiYIvendXwdc5Ij7rj7jCIYLrNqz2zDScIFp0wMRQynR5o54FlCDnrMsljs5H3DgdzCzHmU7wx00H9HlmFws');
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
              'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                  'name' => 'T-shirt',
                ],
                'unit_amount' => 2000,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>  url('/admin/settings/payment_success'),
            'cancel_url' => url('/admin/settings/payment_cancel'),
          ]);

          return  redirect($checkout_session->url);
    }

    public function payment_success(){

        return view('admin.settings.payment_success');
    }

    public function payment_cancel(){

        return 'payment cancel';
        return view('admin.settings.payment_cancel');
    }

    public function newsletter_settings(){
        $this->authorize('create', SiteSettings::class);
        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();
        return view('admin.settings.newsletter_settings',  compact('settings'));
    }

    public function sms_settings(){
        $this->authorize('create', SiteSettings::class);
        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();
        return view('admin.settings.sms_settings',  compact('settings'));
    }

    public function slider_settings(){
        $this->authorize('create', SiteSettings::class);
        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();
        return view('admin.settings.slider_settings',  compact('settings'));
    }


    
    public function job_seeker_settings(){
        $this->authorize('create', SiteSettings::class);
        $settings = SiteSettings::select('meta_key', 'meta_val')->get()->keyBy('meta_key')->toArray();
        return view('admin.settings.job_seeker_settings',  compact('settings'));
    }

    public function job_categories(){

        $job_categories = JobCategory::all();

        return view('admin.settings.job_categories', compact('job_categories'));
    }

    public function sectors(){

        $sectors = Sector::all();

        return view('admin.settings.sectors', compact('sectors'));
    }

    public function create_sector(Request $request, Sector $sector){
        if($sector->create($request->all())){
            return redirect('/admin/settings/sectors')->with('success', 'Sector created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function locations(){

        $locations = Location::all();
        return view('admin.settings.locations', compact('locations'));
    }


    public function skills(){
        $skills = Skill::all();
        return view('admin.settings.skills', compact('skills'));
    }


    public function technologies(){
        $technologies = Technology::all();
        return view('admin.settings.technologies', compact('technologies'));
    }

    public function create_location(Request $request, Location $location){
        if($location->create($request->all())){
            return redirect('/admin/settings/locations')->with('success', 'Location created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create_skill(Request $request, Skill $skill){
        if($skill->create($request->all())){
            return redirect('/admin/settings/skills')->with('success', 'Skill created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create_job_category(Request $request, JobCategory $job_category){
        if($job_category->create($request->all())){
            return redirect('/admin/settings/job_categories')->with('success', 'Job Category created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create_technology(Request $request, Technology $technology){
        if($technology->create($request->all())){
            return redirect('/admin/settings/technologies')->with('success', 'Technology created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


    public function edit_sector($sector_id){
        $sector = Sector::find($sector_id);
        return view('admin.settings.edit_sector', compact('sector'));
    }

    public function edit_location($location_id){
        $location = Location::find($location_id);
        return view('admin.settings.edit_location', compact('location'));
    }

    public function edit_skill($skill_id){
        $skill = Skill::find($skill_id);
        return view('admin.settings.edit_skill', compact('skill'));
    }

    public function edit_technology($technology_id){
        $technology = Technology::find($technology_id);
        return view('admin.settings.edit_technology', compact('technology'));
    }

    public function edit_job_category($job_category_id){
        $job_category = JobCategory::find($job_category_id);
        return view('admin.settings.edit_job_category', compact('job_category'));
    }

    public function update_location(Request $request, $location_id){
        $location = Location::find($location_id);
        $location->update($request->all());
        return redirect('/admin/settings/locations')->with('success', 'Location updated successfully');
    }

    public function update_skill(Request $request, $skill_id){
        $skill = Skill::find($skill_id);
        $skill->update($request->all());
        return redirect('/admin/settings/skills')->with('success', 'Skill updated successfully');
    }

    public function update_technology(Request $request, $technology_id){
        $technology = Technology::find($technology_id);
        $technology->update($request->all());
        return redirect('/admin/settings/technologies')->with('success', 'Technology updated successfully');
    }

    public function update_job_category(Request $request, $job_category_id){
        $job_category = JobCategory::find($job_category_id);
        $job_category->update($request->all());
        return redirect('/admin/settings/job_categories')->with('success', 'Job Category updated successfully');
    }

    public function update_sector(Request $request, $sector_id){
        $sector = Sector::find($sector_id);
        $sector->update($request->all());
        return redirect('/admin/settings/sectors')->with('success', 'Sector updated successfully');
    }

    public function delete_location($location_id){
        $location = Location::find($location_id);
        $location->delete();
        return redirect()->back()->with('success', 'Location deleted successfully');
    }

    public function delete_skill($skill_id){
        $skill = Skill::find($skill_id);
        $skill->delete();
        return redirect()->back()->with('success', 'Skill deleted successfully');
    }

    public function delete_technology($technology_id){
        $technology = Technology::find($technology_id);
        $technology->delete();
        return redirect()->back()->with('success', 'Technology deleted successfully');
    }

    public function delete_job_category($job_category_id){
        $job_category = JobCategory::find($job_category_id);
        $job_category->delete();
        return redirect()->back()->with('success', 'Job Category deleted successfully');
    }

    public function delete_sector($sector_id){
        $sector = Sector::find($sector_id);
        $sector->delete();
        return redirect()->back()->with('success', 'Sector deleted successfully');
    }

}
