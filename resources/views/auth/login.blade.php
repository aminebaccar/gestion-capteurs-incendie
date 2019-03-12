@extends('layouts.app')

@section('content')
<div class="page-single">
    <div class="container">
        <div class="row">
            <div class="col col-login mx-auto">
                <div class="text-center mb-6">
                </div>
                <form class="card" action="{{ route('login') }}" method="post" novalidate>
                    @csrf
                    <div class="card-body p-6">
                        <div class="card-title">@lang('Connecter à votre compte')</div>

                        <div class="form-group">
                            <label class="form-label" for="email">@lang('Pseudo Utilisateur')</label>
                            <input
                                type="text"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="email"
                                id="email"
                                placeholder="Entrer pseudo"
                                value="{{ old('email') }}"
                                required
                                autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                @lang('Mot de passe')
                            </label>
                            <input
                                type="password"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="password"
                                id="password"
                                placeholder="Mot de passe">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">@lang('Connecter')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
