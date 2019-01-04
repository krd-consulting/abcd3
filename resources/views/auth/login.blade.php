@extends('layouts.app')

@section('head-scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('content')

<div class="tw-bg-grey-lighter tw-w-full tw-flex lg:tw-items-center tw-h-screen">
    <login-form inline-template>
        <div class="lg:tw-container lg:tw-mx-auto lg:tw-w-3/5 tw-w-full tw-flex tw-flex-wrap tw-bg-white lg:tw-rounded-lg tw-shadow tw-border-t-8 tw-border-blue">
            <div class="lg:tw-w-1/2 tw-w-full tw-pt-16 tw-pb-16 tw-px-12" >
                <div v-if="!forgotPasswordActive">
                    <h1 class="tw-text-3xl tw-mb-4">{{ __('Welcome Back!') }}</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <base-input
                            id="email"
                            type="email"
                            class="
                                {{ $errors->has('email') ? ' is-invalid' : '' }}
                                tw-mb-2 tw-w-full tw-text-base tw-py-2
                            "
                            name="email" value="{{ old('email') }}"
                            placeholder="Email Address"
                            autocomplete="off"
                            required autofocus
                        ></base-input>

                        @if ($errors->has('email'))
                            <span role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                        <base-input
                            id="password"
                            type="password"
                            class="
                                {{ $errors->has('password') ? ' is-invalid' : '' }}
                                tw-mb-2 tw-w-full tw-text-base tw-py-2
                            "
                            name="password"
                            placeholder="Password"
                            required
                        ></base-input>

                        @if ($errors->has('password'))
                            <span role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                            <span>
                                <base-checkbox
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                ></base-checkbox>

                                <label for="remember" class="tw-text-xs">
                                    {{ __('Remember Me') }}
                                </label>
                            </span>
                            <a class="tw-text-xs" @click="forgotPasswordActive = true" role="button">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>

                        <base-button type="submit" class="tw-py-2 tw-w-full tw-text-base tw-text-white tw-font-semibold tw-bg-blue">
                            {{ __('Log in') }}
                        </base-button>

                    </form>
                </div>
                <div v-if="forgotPasswordActive">
                    <a
                        class="tw-text-xs"
                        @click="forgotPasswordActive = false"
                        role="button"
                    >
                        <base-icon class="tw-text-sm tw-align-text-top">arrow_back</base-icon>
                        Back
                    </a>
                    <h2 class="tw-text-2xl tw-mb-4">
                        {{ __('Forgot Password?!') }}
                    </h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <base-input
                            id="email"
                            type="email"
                            class="
                                {{ $errors->has('email') ? ' is-invalid' : '' }}
                                tw-mb-2 tw-w-full tw-text-base tw-py-2
                            "
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email Address"
                            required
                        >
                        </base-input>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                        <base-button type="submit" class="tw-py-2 tw-w-full tw-text-base tw-text-white tw-font-semibold tw-bg-blue">
                            {{ __('Send Password Reset Link') }}
                        </base-button>
                    </form>
                </div>
            </div>
            <div class="lg:tw-w-1/2 tw-w-full tw-pt-16 tw-pb-16 tw-px-12 tw-bg-blue-lightest">
                <h2 class="tw-text-xl tw-mt-2">A Better Community Database</h2>
                <ul class="tw-list-reset">
                    <li class="tw-mt-6 tw-font-semibold tw-text-blue-darker">
                        <base-icon class="tw-text-2xl tw-text-blue tw-mr-2">check_circle</base-icon>
                        A feature/description.
                    </li>
                    <li class="tw-mt-6 tw-font-semibold tw-text-blue-darker">
                        <base-icon class="tw-text-2xl tw-text-blue tw-mr-2">check_circle</base-icon>
                        B feature/description.
                    </li>
                    <li class="tw-mt-6 tw-font-semibold tw-text-blue-darker">
                        <base-icon class="tw-text-2xl tw-text-blue tw-mr-2">check_circle</base-icon>
                        C feature/description.
                    </li>
                    <li class="tw-mt-6 tw-font-semibold tw-text-blue-darker">
                        <base-icon class="tw-text-2xl tw-text-blue tw-mr-2">check_circle</base-icon>
                        D feature/description.
                    </li>
                </ul>
            </div>
        </div>
    </login-form>
</div>
@endsection
