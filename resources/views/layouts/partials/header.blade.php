<!-- Container -->
<div class="container">

    <!-- Logo / Mobile Menu -->
    <div class="three columns">
        <div id="logo">
            <h1><a href="/"><img src="{{ asset('assets/images/logo.png') }}"/></a></h1>
        </div>
    </div>

    <!-- Navigation
    ================================================== -->
    <div class="thirteen columns navigation">

        <nav id="navigation" class="menu nav-collapse">
            {!! $mainMenu->asUl() !!}
        </nav>

    </div>

</div>
<!-- Container / End -->
