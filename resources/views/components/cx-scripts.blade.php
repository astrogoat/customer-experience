@if(settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'enabled') === true)
    @push('footer')
        <script src="{{ asset('vendor/customer-experience/js/customer-experience.js') }}"></script>
    @endpush
@endif
