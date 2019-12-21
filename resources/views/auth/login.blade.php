@extends('layouts.app')
@section('content')

<div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
	    @if ($errors->has('email'))
				<div class="alert alert-danger">
					{{ $errors->first('email') }}
				</div>
		@endif
		    @if ($errors->has('password'))
				<div class="alert alert-danger">
					<strong>{{ $errors->first('password') }}</strong>
				</div>
			 @endif

        <form method="POST" action="{{ route('login') }}" >
            @csrf
            <h1>Log In</h1>
            <div>
                <input id="email" placeholder="Email Address"  required type="text" class=" form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" >
            </div>

			<div>
				<input id="password" placeholder="Password" required type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >
			</div>

			<div>
                <button type="submit" class="btn btn-success" style="float:right;">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
                <div>
                    <h1>{{ Helper::setting()->name }}</h1>
                </div>
            </div>
        </form>
      </section>
    </div>
</div>

@endsection
