@extends('frontend.layouts.app')

@section('content')
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">

                {{-- Progress Steps --}}
                <div class="row text-center mb-5">
                    <div class="col done">
                        <i class="las la-shopping-cart la-4x text-success"></i>
                        <p class="fs-13 mb-0">{{ translate('1. My Cart') }}</p>
                    </div>
                    <div class="col done">
                        <i class="las la-map la-4x text-success"></i>
                        <p class="fs-13 mb-0">{{ translate('2. Address') }}</p>
                    </div>
                    <div class="col done">
                        <i class="las la-truck la-4x text-success"></i>
                        <p class="fs-13 mb-0">{{ translate('3. Shipping Info') }}</p>
                    </div>
                    <div class="col done">
                        <i class="las la-credit-card la-4x text-success"></i>
                        <p class="fs-13 mb-0">{{ translate('4. Payment') }}</p>
                    </div>
                    <div class="col active">
                        <i class="las la-check-circle la-4x text-primary"></i>
                        <p class="fs-13 mb-0">{{ translate('5. Confirmation') }}</p>
                    </div>
                </div>

                @php $first_order = $combined_order->orders->first(); @endphp

                {{-- Thank You Section --}}
                <div class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="18" fill="#4CAF50"/>
                        <path d="M26 12L16 22l-6-6" stroke="#fff" stroke-width="3" fill="none"/>
                    </svg>
                    <h3 class="mt-3 text-success fw-600">{{ translate('Thank You for Your Order!') }}</h3>
                    <p class="text-muted fs-14 mb-0">
                        {{ translate('A confirmation has been sent to') }}
                        <strong>{{ json_decode($first_order->shipping_address)->email }}</strong>
                    </p>
                </div>

                {{-- Order Summary --}}
                <div class="border rounded bg-white shadow-sm p-4 mb-4">
                    <h5 class="fw-600 mb-3">{{ translate('Order Summary') }}</h5>
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="mb-1"><strong>{{ translate('Order Placed:') }}</strong> {{ date('d-m-Y H:i A', $first_order->date) }}</p>
                            <p class="mb-1"><strong>{{ translate('Order No:') }}</strong> {{ $first_order->code }}</p>
                            <p class="mb-1"><strong>{{ translate('Status:') }}</strong> {{ ucfirst(str_replace('_',' ',$first_order->delivery_status)) }}</p>
                            <p class="mb-1"><strong>{{ translate('Payment:') }}</strong> {{ ucfirst(str_replace('_',' ',$first_order->payment_type)) }}</p>
                           <p class="text-muted mt-2 mb-0" style="font-size: 10px; line-height: 1.4;">
                                <strong>{{ translate('Note:') }}</strong><br>
                     {{ translate('For your reference, please note this number. A confirmation will be sent to your registered email, and your order will be processed for shipment within 48 hours.') }}
                             </p>

                        </div>
                        <div class="col-md-4 text-center">
                            <svg viewBox="0 0 160 120" width="140" height="105">
                                <rect x="40" y="15" rx="8" ry="8" width="55" height="90" fill="#f2f5ff" stroke="#e3e7ff"/>
                                <circle cx="68" cy="60" r="14" fill="#4F46E5" opacity=".15"/>
                                <path d="M75 55l-9 9-5-5" stroke="#4F46E5" stroke-width="4" fill="none" stroke-linecap="round"/>
                                <circle cx="115" cy="78" r="7" fill="#4CAF50"/>
                                <path d="M119 75l-5 6-3-3" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="border rounded bg-white shadow-sm p-4 mb-4">
                    <h5 class="fw-600 mb-3">{{ translate('Shipping Address') }}</h5>
                    @php $ship = json_decode($first_order->shipping_address); @endphp
                    <p class="mb-1"><strong>{{ translate('Name:') }}</strong> {{ $ship->name }}</p>
                    @if(isset($ship->phone))
                        <p class="mb-1"><strong>{{ translate('Phone:') }}</strong> {{ $ship->phone }}</p>
                    @endif
                    <p class="mb-1"><strong>{{ translate('Email:') }}</strong> {{ $ship->email }}</p>
                    <p class="mb-1"><strong>{{ translate('Address:') }}</strong> {{ $ship->address }}, {{ $ship->city }}, {{ $ship->country }}</p>
                    @if(isset($ship->postal_code))
                        <p class="mb-0"><strong>{{ translate('Postal Code:') }}</strong> {{ $ship->postal_code }}</p>
                    @endif
                </div>

                {{-- Order Details --}}
@foreach ($combined_order->orders as $order)
    <div class="border rounded bg-white shadow-sm p-4 mb-4">
        <h5 class="fw-600 mb-3">
            {{ translate('Order Details') }}
            <span class="float-end text-primary">#{{ $order->code }}</span>
        </h5>

        {{-- Product Table --}}
        <table class="table table-bordered align-middle mb-2">
            <thead class="bg-light">
                <tr>
                    <th style="width:60%;">{{ translate('Product Name') }}</th>
                    <th style="width:20%;">{{ translate('Quantity') }}</th>
                    <th style="width:20%;">{{ translate('Amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>
                            @if($detail->product)
                                {{ $detail->product->getTranslation('name') }}
                            @else
                                <em>{{ translate('Unavailable') }}</em>
                            @endif
                        </td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-end">{{ single_price($detail->price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals table (separate but aligned to columns) --}}
        <table class="table align-middle mb-0"
               style="width:100%; border:1px solid #e5e7eb; border-top:3px solid #f5f5f5; margin-top:-1px;">
            <tbody>
                <tr>
                    <td colspan="2" class="text-start ps-3 fw-500" style="width:80%; border-right:1px solid #dee2e6;">
                        {{ translate('Sub Total') }}
                    </td>
                    <td class="text-end" style="width:20%;">{{ single_price($order->orderDetails->sum('price')) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start ps-3 fw-500" style="border-right:1px solid #dee2e6;">
                        {{ translate('Shipping') }}
                    </td>
                    <td class="text-end">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start ps-3 fw-500" style="border-right:1px solid #dee2e6;">
                        {{ translate('Discounts') }}
                    </td>
                    <td class="text-end">{{ single_price($order->coupon_discount) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start ps-3 fw-500" style="border-right:1px solid #dee2e6;">
                        {{ translate('Tax') }}
                    </td>
                    <td class="text-end">{{ single_price($order->orderDetails->sum('tax')) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start ps-3 fw-600 text-success" style="border-right:1px solid #dee2e6;">
                        {{ translate('Order Total:') }}
                    </td>
                    <td class="text-end fw-600 text-success">{{ single_price($order->grand_total) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- 👇 cancel note now INSIDE this box --}}
        <div class="mt-3 text-muted fs-13">
            <strong>{{ translate('Need to cancel this order?') }}</strong><br>
            {{ translate('Note: You can cancel your order within 1 hour of placing it.') }}
        </div>
    </div>
@endforeach



                <div class="border rounded bg-white shadow-sm p-4 mb-4 w-100">
    <h6 class="fw-600 mb-2">{{ translate('Help?') }}</h6>
    <p class="mb-1"><i class="las la-phone"></i> 9311442886</p>
    <p class="mb-0"><i class="las la-envelope"></i> info@artistiqe.com</p>
</div>


                {{-- Continue Button --}}
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-dark px-5 py-2 rounded-pill">
                        {{ translate('Continue Shopping') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    @if (get_setting('facebook_pixel') == 1)
        <script>
            $(function () {
                var curr = '{{ get_system_currency()->code }}';
                var amount = '{{ $combined_order->grand_total }}';
                try {
                    fbq('track', 'Purchase', {value: amount, currency: curr, content_type: 'product'});
                } catch (e) {}
            });
        </script>
    @endif
@endsection
