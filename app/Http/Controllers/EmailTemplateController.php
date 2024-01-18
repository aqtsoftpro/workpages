<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{

    public function index()
    {

    }

    public function create()
    {
        $record = EmailTemplate::all();
        return view('admin.email_templates.create', compact('record'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'email_type' => 'required',
        ]);


        if($template = EmailTemplate::create($request->all()))
        {
            return redirect('admin/email_templates/' . $template->id . '/edit')->with('success', $request->name.' email template created successfully');
        }
        else
        {
            return redirect()->back()->with('danger', 'Something went wrong. Please try again!');
        }
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $record = EmailTemplate::find($id);

        // dd($record);

        return view('admin.email_templates.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $EmailTemplate = EmailTemplate::find($id);


        if($EmailTemplate->update($request->all()))
            {
                return redirect()->back()->with('success', ''.$request->name.' email template updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    }

    public function destroy(string $id)
    {

    }

    public function get_template($slug)
    {
        $template = EmailTemplate::where('slug', $slug)->first()->toArray();
        return $template;
    }

    public function company_templates()
    {
        $email_type = 'company';
        $title = 'Company Email Templates';
        $records = EmailTemplate::where('email_type', $email_type)->orderBy('name', 'ASC')->get();
        return view('admin.email_templates.index', compact('records', 'title'));
    }

    public function job_seeker_templates()
    {
        $email_type = 'job seeker';
        $title = 'Job Seeker Email Templates';
        $records = EmailTemplate::where('email_type', $email_type)->orderBy('name', 'ASC')->get();
        return view('admin.email_templates.index', compact('records', 'title'));
    }

    public function admin_templates()
    {
        $email_type = 'admin';
        $title = 'Admin Email Templates';
        $records = EmailTemplate::where('email_type', $email_type)->orderBy('name', 'ASC')->get();
        return view('admin.email_templates.index', compact('records', 'title'));
    }


}
