@extends('lego::layouts.lego')

@section('content')
    <livewire:astrogoat.customer-experience.http.livewire.models.faqs-form :faq="\Astrogoat\CustomerExperience\Models\Faq::make()"/>
@endsection
