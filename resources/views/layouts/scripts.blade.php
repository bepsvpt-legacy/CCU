<!-- scripts -->
<script src="https://cdn.bepsvpt.net/js/vendors.min.js?v=1.2" defer></script>
<script src="https://cdn.bepsvpt.net/vendor/textboxio/textboxio.js" defer></script>
<script src="https://www.google.com/recaptcha/api.js" defer></script>

@if (app()->environment(['production']))
    <script src="{{ routeAssets('js.all', true) }}" defer></script>
    <script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-65962475-2', 'auto');</script>
@else
    <script src="{{ routeAssets('js.angular', true) }}" defer></script>
    <script src="{{ routeAssets('js.routes', true) }}" defer></script>
    <script src="{{ routeAssets('js.ccu', true) }}" defer></script>

    @inject('filesystem', 'Illuminate\Filesystem\Filesystem')

    @foreach(['controllers', 'directives', 'factories', 'filters'] as $directory)
        @foreach($filesystem->allFiles(base_path("resources/views/js/{$directory}")) as $file)
            @if (ends_with($file->getRelativePathname(), '.js.php'))
                <script src="{{ routeAssets('js.' . $directory . '.' . str_replace('/', '.', substr($file->getRelativePathname(), 0, -7)), true) }}" defer></script>
            @endif
        @endforeach
    @endforeach
@endif