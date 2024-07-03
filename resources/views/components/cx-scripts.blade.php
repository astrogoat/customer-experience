@if(app(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class)->isEnabled())
    @push('footer')
        <script src="{{ asset('vendor/customer-experience/js/customer-experience.js') }}"></script>
    @endpush
@endif
