<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Help_FAQController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.apps.help-faq.faq");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadFaqW9()
    {
        $filename = "Consent Form_CDA.pdf";
        $path = public_path("libs/faqs/{$filename}");

        if (file_exists($path)) {
            return response()->download($path);
        }else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadFaqAttachment()
    {
        $filename = "W_9 CDA Flyer_SRRP_ENG.SPAN.pdf";
        $path = public_path("libs/faqs/{$filename}");

        if (file_exists($path)) {
            return response()->download($path);
        }else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
