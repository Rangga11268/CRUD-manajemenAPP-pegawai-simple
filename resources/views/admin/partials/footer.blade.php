<footer class="c-footer">
    <div>
        <a href="#">{{ \App\Models\Setting::value('company_name', config('app.name')) }}</a> &copy; {{ date('Y') }}. versi 1.0.0
    </div>
    <div class="ml-auto">
        Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a>
    </div>
</footer>
