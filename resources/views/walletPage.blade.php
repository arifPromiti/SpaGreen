<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5">
                    <div class="card-body">

                        @session('success')
                        <div class="alert alert-success" role="alert">
                            {{ $value }}
                        </div>
                        @endsession

                        <form id='checkout-form' method='post' action="{{ route('wallet.add') }}">
                            @csrf

                            <strong>Name:</strong>
                            <input type="input" class="form-control" name="name" placeholder="Enter Name">
                            <br>
                            <strong>Amount:</strong>
                            <input type="input" class="form-control" name="amount" placeholder="Enter Amount">
                            <input type='hidden' name='stripeToken' id='stripe-token-id'>
                            <br>
                            <div id="card-element" class="form-control" ></div>
                            <button
                                id='pay-btn'
                                class="btn btn-success mt-3"
                                type="button"
                                style="margin-top: 20px; width: 100%;padding: 7px;"
                                onclick="createToken()">Recharge Wallet
                            </button>
                        <form>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role == 'admin')
                <div class="col-md-8 offset-md-2">
                    <div class="card mt-5">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blance as $row)
                                        <tr>
                                            <td>{{ $row->user->name }}</td>
                                            <td>${{ $row->balance }}/-</td>
                                            <td>{{ $row->trans_type }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
