@extends('layouts.app')

@section('content')

<div class="tw-bg-gray-100 tw-w-full tw-flex tw-justify-around lg:tw-items-start tw-h-screen">
    <login-form inline-template old-email="{{ old('email') }}">
        <div class="lg:tw-container lg:tw-ml-16 lg:tw-mt-48 lg:tw-w-4/5 tw-w-full tw-flex tw-flex-wrap tw-bg-white lg:tw-rounded-lg tw-shadow tw-border-t-8 tw-border-orange-500">
            <div class="tw-w-full lg:tw-pt-8 tw-pt-64 tw-pb-8 tw-px-12">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if ($errors->has('email'))
                        <div 
                            class="tw-rounded tw-py-2 tw-mb-4 tw-text-center tw-bg-red-200 
                            tw-border tw-border-red-700">
                            <span role="alert" class="tw-text-red-700 tw-text-sm">
                            {{ $errors->first('email') }}
                            </span>
                        </div>
                    @endif            
                    <div>
                        <div class="tw-flex tw-items-center tw-w-full">
                            <label class="tw-w-1/4">
                                Login 
                            </label>
                            <div class="tw-w-3/4">
                                <base-input
                                        id="email"
                                        v-model="email"
                                        type="email"
                                        class="
                                            {{ $errors->has('email') ? ' is-invalid' : '' }}
                                            tw-mb-2 tw-w-full tw-text-base
                                            "
                                        name="email" 
                                        value="{{ old('email') }}"
                                        placeholder=""
                                        autocomplete="off"
                                        required autofocus
                                ></base-input>
                            </div>
                        </div>
                    </div>
                    <div class="tw-mb-1">
                        <div class="tw-flex tw-items-center tw-w-full">
                            <label class="tw-w-1/4">
                                Password 
                            </label>
                            <div class="tw-w-3/4">
                                <base-input
                                        id="password"
                                        v-model="password"
                                        type="password"
                                        class="
                                                {{ $errors->has('password') ? ' is-invalid' : '' }}
                                                tw-mb-2 tw-w-full tw-text-base
                                            "
                                        name="password"
                                        placeholder=""
                                        required
                                        show-password
                                ></base-input>
                            </div>
                        </div>
                    </div>
                    <base-button type="submit" class="tw-py-4 tw-w-full tm-mx-auto tw-mb-5 tw-center tw-text-base tw-text-white tw-font-semibold tw-bg-orange-400">
                        {{ __('Log in') }}
                    </base-button>
                        
                    <div class="tw-flex tw-justify-around tw-items-center tw-mb-4">
                        <span>
                            <base-checkbox
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >{{ __('Remember Me') }}</base-checkbox>
                        </span>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </login-form>
    <img class="tw-hidden lg:tw-block lg:tw-w-1/2" src="/images/splash.jpg"></img>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
