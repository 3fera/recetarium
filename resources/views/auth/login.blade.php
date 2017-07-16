@extends('layouts.default')

@section('content')

<div class="container">

    <div class="one-third column"><br /></div>
    <!-- Login Form -->
    <div class="one-third column login">

    		<!-- Contact Form -->
    		<section id="login">

    			<!-- Success Message -->
    			<mark id="message"></mark>

    			<!-- Form -->
                <form name="contactform" id="contactform" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}

    				<fieldset>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label>
                                Contraseña
                                <a class="label-link" href="{{ url('/password/reset') }}">¿La has olvidado?</a>
                            </label>
                            <input type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

    				</fieldset>
    				<div id="result"></div>
    				<input type="submit" value="Acceder">
    				<div class="clearfix"></div>
    			</form>

    		</section>
    		<!-- Contact Form / End -->
    		<div class="margin-bottom-50"></div>
    </div>
</div>

@endsection
