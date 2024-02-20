<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;
use GuzzleHttp\Client;
use App\Models\SiteSettings;

class AdminNewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apiKey = config('newsletter.driver_arguments.api_key');
        // $listId = config('newsletter.lists.subscribers.id');
        $listId = $request->list_id;

        $list_ids = SiteSettings::where('meta_key', '_mailchimp_list_id')->get();

        $url = "https://us6.api.mailchimp.com/3.0/lists/{$listId}/members?count=100";

        $client = new Client();

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
                ],

            ]);
        
            $statusCode = $response->getStatusCode();
            $members = json_decode($response->getBody(), true);
            $members = json_decode(json_encode($members['members']));
        
            if ($statusCode == 200) {
                return view('admin.news_letters.index', compact('members', 'list_ids'))->with('success','Members list got successfully.');
            } else {
                $members = [];
                return view('admin.news_letters.index', compact('members', 'list_ids'))->with('error','Failed to fetch members. Status code: ' . $statusCode,);

                // abort($statusCode, 'Failed to fetch members. Status code: ' . $statusCode,);
            }
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage(),
            // ]);
            $members = [];
            return view('admin.news_letters.index', compact('members', 'list_ids'))->with('error',$e->getMessage());

        }

    }
    /**
     * Show the form for creating a new resource.
     */
    public function status($status, $hash)
    {
        $apiKey = config('newsletter.driver_arguments.api_key');
        $listId = config('newsletter.lists.subscribers.id');
        $url = "https://us6.api.mailchimp.com/3.0/lists/{$listId}/members/{$hash}";

        $client = new Client();

        try {
            $response = $client->patch($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
                ],
                'json' => [
                    'status' => $status == 'subscribed' ? 'unsubscribed' : 'subscribed', // toggle the status
                ],
            ]);
        
            $statusCode = $response->getStatusCode();
            // $member = json_decode($response->getBody(), true);
        
            if ($statusCode == 200) {
                // Handle $members as needed
                return redirect()->route('news.letter')->with('success', 'Members list updated successfully.');
            } else {
                return redirect()->route('news.letter')->with('error', 'Failed to update member status. Status code: ' . $statusCode );
            }
        } catch (\Exception $e) {
            return redirect()->route('news.letter')->with('error', $e->getMessage() );
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function archive($status, $hash)
    {
        $apiKey = config('newsletter.driver_arguments.api_key');
        $listId = config('newsletter.lists.subscribers.id');
        $url = "https://us6.api.mailchimp.com/3.0/lists/{$listId}/members/{$hash}";

        $client = new Client();

        try {
            $response = $client->delete($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 204) {
                // Member successfully removed
                return redirect()->route('news.letter')->with('success', 'Member removed from the list successfully.');
            } else {
                return redirect()->route('news.letter')->with('error', 'Failed to remove member from the list. Status code: ' . $statusCode );
            }
        } catch (\Exception $e) {

            return redirect()->route('news.letter')->with('error', 'Failed to remove member from the list. Status code: ' . $e->getMessage() );

        }
    }
    /**
     * Display the specified resource.
     */
    public function deletePermanent($status, $hash)
    {
        $apiKey = config('newsletter.driver_arguments.api_key');
        $listId = config('newsletter.lists.subscribers.id');
        $url = "https://us6.api.mailchimp.com/3.0/lists/{$listId}/members/{$hash}/actions/delete-permanent";
        $client = new Client();
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 204) {
                return redirect()->route('news.letter')->with('success', 'Member deleted permanently from the list successfully.');
            } else {
                return redirect()->route('news.letter')->with('error', 'Failed to delete member from the list. Error is:' . $statusCode );
            }
        } catch (\Exception $e) {
            return redirect()->route('news.letter')->with('error', 'Failed to delete member from the list. Error is: ' . $e->getMessage() );
        }
    }
}
