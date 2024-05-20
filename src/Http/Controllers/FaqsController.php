<?php

namespace Astrogoat\CustomerExperience\Http\Controllers;

use Astrogoat\CustomerExperience\Models\Faq;
use Illuminate\Routing\Controller;

class FaqsController extends Controller
{

    public function index()
    {
        $faqs = Faq::paginate(20);
        return view('customer-experience::models.faqs.index', compact('faqs'));
    }

    public function show(Faq $faq)
    {
        $faq->load('sections');
        return view('lego::sectionables.show', ['sectionable' => $faq]);
    }

    public function create()
    {
        return view('customer-experience::models.faqs.create');
    }

    public function edit(Faq $faq)
    {
        return view('customer-experience::models.faqs.edit', compact('faq'));
    }

}
