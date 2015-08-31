<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-route.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angulartics/0.19.2/angulartics.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.8.0/loading-bar.min.js" defer></script>
<script src="{{ routeAssets('js.vendor.angulartics-google-analytics') }}" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
<script src="{{ routeAssets('js.vendor.arrive') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.9.0/validator.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.8/autosize.min.js" defer></script>
<script src="https://www.google.com/recaptcha/api.js" defer></script>
<script src="{{ routeAssets('js.ccu') }}" defer></script>
<script src="{{ routeAssets('js.angular') }}" defer></script>
<script src="{{ routeAssets('js.routes') }}" defer></script>

@inject('filesystem', 'Illuminate\Filesystem\Filesystem')

@foreach($jsDirectories as $directory)
    @foreach($filesystem->allFiles(base_path("resources/views/js/{$directory}")) as $file)
        @if (ends_with($file->getRelativePathname(), '.js.php'))
            <script src="{{ routeAssets("js.{$directory}." . str_replace('/', '.', substr($file->getRelativePathname(), 0, -7))) }}" defer></script>
        @endif
    @endforeach
@endforeach

@if (app()->environment('production'))
    <script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-65962475-2', 'auto');</script>
@endif