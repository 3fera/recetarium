@extends('layouts.default')

@section('content')

<div class="container">

    <div class="twelve columns">

    		<section>

    			<!-- Form -->
                {!! Form::open(['route' => 'account.store', 'files' => true]) !!}

    				<fieldset>

                        <img src="{{ $user->image->url('thumb') }}" />

                        <label>Avatar</label>
                        <input type="file" class="form-control" name="image">

                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?: $user->name }}">

                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="{{ old('username') ?: $user->username }}">

                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') ?: $user->email  }}">

    				</fieldset>

                    <fieldset>
                        <label>Current password</label>
                        <input type="password" class="form-control" name="current_password">

                        <label>New password</label>
                        <input type="password" class="form-control" name="password">

                        <label>Repeat new password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </fieldset>

    				<input type="submit" value="Guardar">
    				<div class="clearfix"></div>

    			</form>

    		</section>

    		<div class="margin-bottom-50"></div>
    </div>
</div>

@endsection
