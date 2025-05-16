<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Image Generate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5">
                    <div class="card-body">

                        @session('success')
                        <img src="{{ $value }}" alt="">
                        @endsession
                        @session('error')
                        <div class="alert alert-danger" role="alert">
                            {{ $value }}
                        </div>
                        @endsession

                        <form method='post' action="{{ route('image.generate.new') }}">
                            @csrf

                            <strong>Image description:</strong>
                            <textarea class="form-control" name="details" placeholder="Enter Detail of Image">{{ old('details') }}</textarea>
                            <button class="btn btn-success mt-3" type="submit" style="margin-top: 20px; width: 100%;padding: 7px;">Generate Image </button>
                        <form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
