<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <style media="all">
        @page { margin: 0; padding:0; }
        html, body {
            height: 100%;
        }
        body {
            font-size: 0.85rem;
            font-family: '<?php echo $font_family ?>';
            direction: <?php echo $direction ?>;
            text-align: <?php echo $text_align ?>;
            margin: 20px;
            display: flex;
            flex-direction: column;
        }

        /* General table rules */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px; border: 1px solid #000; font-size: 12px; vertical-align: top; }
        .no-border td, .no-border th { border: none !important; }
        .title { font-size: 18px; font-weight: bold; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .section-label { font-weight: bold; }

        /* header info row with bg, but no borders */
        .info-strip { background: #eceff4; border: none; }
        .info-strip td { border: none !important; padding: 8px 6px; font-size: 12px; }

        /* Company name row larger */
        .company-row td { padding: 16px 6px; font-weight: bold; font-size: 14px; }

        /* Product table specifics */
        .items-table thead th { background: #fff; }
        .items-table td, .items-table th { border: 1px solid #000; }
        .items-table tbody tr td { padding: 8px 6px; }
        /* ensure each product row always has border when more rows added */
        .items-table tbody tr { border-bottom: 1px solid #000; }

        /* Make main content area flexible so totals remain at bottom */
        .invoice-wrapper { display: flex; flex-direction: column; min-height: 0; flex: 1 1 auto; }
        .items-area { flex: 1 1 auto; display: flex; flex-direction: column; }

        /* Force product table to expand to occupy available space (so totals appear at bottom) */
        .items-table { width: 100%; table-layout: fixed; }
        .items-table tbody { /* allow table to stretch; many PDF renderers will respect this */
            /* nothing required here for server-side PDF engines, but keep for browsers */
        }

        /* Totals box — visually aligned with item columns */
        .totals-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .totals-table td, .totals-table th { border: 1px solid #000; padding: 6px; }

        /* Footer area */
        .footer { margin-top: 12px; }

        /* Declaration centered */
        .declaration { text-align: center; font-size: 11px; margin-top: 8px; }

        /* Make first column width distribution match earlier design */
        .col-product { width: 35%; }
        .col-delivery { width: 15%; }
        .col-qty { width: 10%; text-align: center; }
        .col-unit { width: 15%; }
        .col-tax { width: 10%; }
        .col-total { width: 15%; text-align: right; }

        /* Small adjustments for long product names to wrap */
        .items-table td { word-wrap: break-word; }

        /* Remove border for the header/top contact row in product area */
        .header-no-border td { border: none !important; padding: 4px; }

        /* On printed PDF, ensure spacing looks balanced */
        @media print {
            body { margin: 10px; }
        }
    </style>
</head>
<body>
    @php $logo = get_setting('header_logo'); @endphp

    <!-- Header: logo + INVOICE title -->
    <table class="no-border header-no-border">
        <tr>
            <td class="no-border" style="vertical-align: middle;">
                @if($logo != null)
                    <img src="{{ uploaded_asset($logo) }}" height="48">
                @else
                    <img src="{{ static_asset('assets/img/logo.png') }}" height="48">
                @endif
            </td>
            <td class="no-border text-right title" style="vertical-align: middle;">
                {{ translate('INVOICE') }}
            </td>
        </tr>
    </table>

    <!-- Info strip: Email / Phone | Date / Order Id (bg #eceff4, no border) -->
    <table class="info-strip no-border" style="margin-top:8px;">
        <tr>
            <td style="padding:8px;">
                {{ translate('Email') }}: {{ get_setting('contact_email') }}<br> 
                {{ translate('Phone') }}: {{ get_setting('contact_phone') }}
            </td>
            <td style="padding:8px;">
                {{ translate('Date') }}: {{ date('d-m-Y', $order->date) }} <br>
                {{ translate('Order Id') }}: {{ $order->code }}
            </td>
        </tr>
    </table>


    <!-- Customer info and payment mode -->
    @php $shipping_address = json_decode($order->shipping_address); @endphp
    <table style="margin-top:8px; border-collapse: collapse;">
        <tr class="no-border">
            <td style="border: none; vertical-align: top; padding: 8px;">
                <strong>{{ translate('Bill No') }}:</strong> {{ $order->code }} <br>
                <strong>{{ translate('Customer Name') }}:</strong> {{ $shipping_address->name }} <br>
                <strong>{{ translate('Number') }}:</strong> {{ $shipping_address->phone }} <br>
                <strong>{{ translate('Email Id') }}:</strong> {{ $shipping_address->email }} <br>
                <strong>{{ translate('Address') }}:</strong>
                {{ $shipping_address->address }}, {{ $shipping_address->city }},
                @if(isset($shipping_address->state)) {{ $shipping_address->state }} - @endif
                {{ $shipping_address->postal_code }}, {{ $shipping_address->country }}
            </td>
            <td style="border: none; vertical-align: top; padding: 8px;">
                <strong>{{ translate('Payment Mode') }}:</strong>
                {{ translate(ucfirst(str_replace('_',' ',$order->payment_type))) }}
            </td>
        </tr>
    </table>

    <!-- Items area (flex grow) -->
    <div class="invoice-wrapper">
        <div class="items-area">

            <!-- Product table with full borders across columns -->
            <table class="items-table" style="margin-top:6px;">
                <thead>
                    <tr>
                        <th class="col-product">{{ translate('Product Details') }}</th>
                        <th class="col-delivery">{{ translate('Delivery Type') }}</th>
                        <th class="col-qty">{{ translate('QTY') }}</th>
                        <th class="col-unit">{{ translate('Unit Price') }}</th>
                        <th class="col-tax">{{ translate('Tax') }}</th>
                        <th class="col-total">{{ translate('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $key => $orderDetail)
                        @if ($orderDetail->product != null)
                            <tr>
                                <td style="padding:10px;">
                                    {{ $orderDetail->product->name }}
                                    @if($orderDetail->variation != null) ({{ $orderDetail->variation }}) @endif
                                    <br>
                                    <small>{{ translate('SKU') }}: {{ $orderDetail->product->stocks->first()->sku ?? '' }}</small>
                                </td>
                                <td style="padding:10px;">
                                    @if ($order->shipping_type == 'home_delivery')
                                        {{ translate('Home Delivery') }}
                                    @elseif ($order->shipping_type == 'pickup_point')
                                        {{ $order->pickup_point->getTranslation('name') ?? translate('Pickup Point') }}
                                    @elseif ($order->shipping_type == 'carrier')
                                        {{ $order->carrier->name ?? translate('Carrier') }}
                                    @endif
                                </td>
                                <td style="text-align:center;">{{ $orderDetail->quantity }}</td>
                                <td class="currency">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
                                <td class="currency">{{ single_price($orderDetail->tax/$orderDetail->quantity) }}</td>
                                <td class="text-right currency">{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
                            </tr>
                        @endif
                    @endforeach

                    <!-- If you want a visual spacer so totals move to bottom with fewer items,
                         we could optionally inject blank rows here. Keep commented out. -->
                    {{-- @for($i = 0; $i < $some_blank_rows; $i++)
                        <tr>
                            <td style="height:18px;">&nbsp;</td>
                            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        </tr>
                    @endfor --}}
                </tbody>
            </table>

            <!-- Totals: placed after items but the layout is flex so the wrapper will push this toward bottom -->
            <table class="totals-table" style="margin-top:auto;">
                <tbody>
                    <tr>
                        <th style="width:70%; text-align:left;">{{ translate('Sub Total') }}</th>
                        <td style="width:30%; text-align:right;">{{ single_price($order->orderDetails->sum('price')) }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">{{ translate('Shipping Cost') }}</th>
                        <td style="text-align:right;">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">{{ translate('Total Tax') }}</th>
                        <td style="text-align:right;">{{ single_price($order->orderDetails->sum('tax')) }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left;">{{ translate('Coupon Discount') }}</th>
                        <td style="text-align:right;">{{ single_price($order->coupon_discount) }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:left; font-weight: bold;">{{ translate('Grand Total') }}</th>
                        <td style="text-align:right; font-weight: bold;">{{ single_price($order->grand_total) }}</td>
                    </tr>
                </tbody>
            </table>

        </div> <!-- end items-area -->
    </div> <!-- end invoice-wrapper -->

    <!-- Footer: Company name & For Artistiqe Consulting left side -->
    <table class="footer" style="margin-top:12px;">
        <tr>
            <td style="padding:12px;">
                <strong>{{ translate('Company Name') }}:</strong> Artivine Consulting <br>
                <strong>GST No:</strong> 07ACKFA5095K1ZY
            </td>
            <td style="padding:12px; border: 1px solid #000;">
                <strong>{{ translate('For') }} Artivine Consulting</strong>
            </td>
        </tr>
    </table>

    <div class="declaration">
        <em>{{ translate('Declaration') }}: We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</em>
    </div>

</body>
</html>
