<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <title>Recetarium | @yield('title')</title>

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
        ================================================== -->
        {!! HTML::style('assets/css/style.css') !!}
        {!! HTML::style('assets/css/font-awesome.css') !!}
        {!! HTML::style('assets/css/responsive.css') !!}
        {!! HTML::style('assets/css/colors/green.css') !!}
        {!! HTML::style('assets/css/custom.css') !!}
        @yield('styles')

        <!--[if lt IE 9]>
        	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body>
        <!-- Wrapper -->
        <div id="wrapper">

            <!-- Header
            ================================================== -->
            <header id="header">
                @section('header')
                    @include('layouts.partials.header')
                @show
            </header>

            @include('flash::message')

            <!-- Content
            ================================================== -->
            @yield('content')

            <div class="margin-top-5"></div>

        </div>
        <!-- Wrapper / End -->

        <!-- Footer
        ================================================== -->
        <div id="footer">
            @section('footer')
                @include('layouts.partials.footer')
            @show
        </div>
        <!-- Footer / End -->

        <!-- Footer Bottom / Start -->
        <div id="footer-bottom">

        	<!-- Container -->
        	<div class="container">

        		<div class="eight columns"><a href="#">Recetarium</a>. </div>

        	</div>
        	<!-- Container / End -->

        </div>
        <!-- Footer Bottom / End -->

        <!-- Back To Top Button -->
        <div id="backtotop"><a href="#"></a></div>

        <!-- Java Script
        ================================================== -->
        {!! HTML::script('assets/scripts/jquery-1.11.0.min.js') !!}
        {!! HTML::script('assets/scripts/jquery.tooltips.min.js') !!}
        {!! HTML::script('assets/scripts/jquery-migrate-1.2.1.min.js') !!}
        {!! HTML::script('assets/scripts/jquery.superfish.js') !!}
        {!! HTML::script('assets/scripts/jquery.royalslider.min.js') !!}
        {!! HTML::script('assets/scripts/jquery-ui.min.js') !!}
        {!! HTML::script('assets/scripts/responsive-nav.js') !!}
        {!! HTML::script('assets/scripts/hoverIntent.js') !!}
        {!! HTML::script('assets/scripts/isotope.pkgd.min.js') !!}
        {!! HTML::script('assets/scripts/chosen.jquery.min.js') !!}
        {!! HTML::script('assets/scripts/jquery.magnific-popup.min.js') !!}
        {!! HTML::script('assets/scripts/jquery.pricefilter.js') !!}
        {!! HTML::script('assets/scripts/custom.js') !!}

        <!-- WYSIWYG Editor -->
        {!! HTML::script('assets/scripts/jquery.sceditor.bbcode.min.js') !!}
        {!! HTML::script('assets/scripts/jquery.sceditor.js') !!}
        @yield('scripts')

    </body>
</html>
