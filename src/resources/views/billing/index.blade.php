@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Billing</div>

                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-info">
                                {{session('message')}}
                            </div>
                        @endif
                        @if(is_null($currentPlan->stripe_plan ))
                            You are on a free plan. Please Upgrade if you wish
                        @endif
                        <br><br>
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-md-4 text-center">
                                    <h3>{{$plan->name}}</h3>
                                    <b>${{ number_format($plan->price / 100, 2)}} / month</b>
                                    <hr>
                                    @if($plan->stripe_plan_id == $currentPlan->stripe_plan )
                                        Your Current Plan
                                        <br>
                                        @if (!$currentPlan->onGracePeriod())
                                            <a href="{{route('billing.cancel')}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Cancel Plan</a>
                                        @else
                                            Your Subscription will end on {{$currentPlan->ends_at->toDateString()}}
                                            <br>
                                            <a href="{{route('billing.resume')}}" class="btn btn-primary">Resume Plan</a>
                                        @endif
                                    @else
                                        <a href="{{route('checkout', $plan->id )}}" class="btn btn-primary">Subscribe to {{$plan->name}} Plan</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>
                @if(!is_null($currentPlan))
                <div class="card">
                    <div class="card-header">Payment Methods</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Expires at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paymentMethods as $paymentMethod)
                                <tr>
                                <td>{{$paymentMethod->card->brand}}</td>
                                <td>{{$paymentMethod->card->exp_month}} / {{$paymentMethod->card->exp_year}}</td>
                                <td>
                                    @if($defaultPaymentMethod->id == $paymentMethod->id)
                                        Default
                                    @else
                                        <a href="{{route('payment-method.markAsDefault',$paymentMethod->id)}}">Make Default</a>
                                    @endif
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{route('payment-method.create')}}" class="btn btn-primary">Add Payment Method</a>

                    </div>
                </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
