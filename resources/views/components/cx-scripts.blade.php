@if(settings(\Astrogoat\CustomerExperience\Settings\CustomerExperienceSettings::class, 'enabled') === true)
    @push('footer')
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/utc.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/timezone.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/customParseFormat.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.7/plugin/advancedFormat.min.js"></script>
    @endpush
@endif
