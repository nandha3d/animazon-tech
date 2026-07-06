@php
    // $logo=asset(Storage::url('uploads/logo/'));
     $logo=\App\Models\Utility::get_file('uploads/logo');
     $company_favicon=Utility::companyData($proposal->created_by,'company_favicon');
     $setting = \App\Models\Utility::colorset();
     $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
     $company_setting=\App\Models\Utility::settingsById($proposal->created_by);

    $getseo= App\Models\Utility::getSeoSetting();
    $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
    $metsdesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';
    $get_cookie = \App\Models\Utility::getCookieSetting();
    $settings = DB::table('settings')->where('created_by', $user->creatorId())->pluck('value', 'name')->toArray();

@endphp
    <!DOCTYPE html>

 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
   <title>{{(Utility::companyData($proposal->created_by,'title_text')) ? Utility::companyData($proposal->created_by,'title_text') : config('app.name', 'ANIMAZON')}} - {{__('Proposal')}}</title>

     <meta name="title" content="{{$metatitle}}">
     <meta name="description" content="{{$metsdesc}}">

     <!-- Open Graph / Facebook -->
     <meta property="og:type" content="website">
     <meta property="og:url" content="{{ env('APP_URL') }}">
     <meta property="og:title" content="{{$metatitle}}">
     <meta property="og:description" content="{{$metsdesc}}">
     <meta property="og:image" content="{{$meta_image.$meta_logo}}">

     <!-- Twitter -->
     <meta property="twitter:card" content="summary_large_image">
     <meta property="twitter:url" content="{{ env('APP_URL') }}">
     <meta property="twitter:title" content="{{$metatitle}}">
     <meta property="twitter:description" content="{{$metsdesc}}">
     <meta property="twitter:image" content="{{$meta_image.$meta_logo}}">


     <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">

     <!-- font css -->
     <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

     <!-- vendor css -->
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
     <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
     <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="main-style-link">
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

     @stack('css-page')

     <meta name="csrf-token" content="{{ csrf_token() }}">
     <style>
         #card-element {
             border: 1px solid #a3afbb !important;
             border-radius: 10px !important;
             padding: 10px !important;
         }
     </style>
 </head>

 <body class="{{ $color }}">
 <header class="header header-transparent" id="header-main">

 </header>

 <div class="main-content container">
     @php
         $isExpired = $proposal->isExpired();
         $isAccepted = $proposal->isAccepted();
         $isDeclined = $proposal->isDeclined();
         $isPending = !$isAccepted && !$isDeclined;
         $totalDue = $proposal->getDue();
         $totalPaid = $proposal->amountPaid();
         $isRudraProposal = ($proposal->proposal_id == 1 || $proposal->proposal_id == 2 || $proposal->id == 1 || $proposal->id == 2 || (isset($customer) && str_contains(strtolower($customer->name ?? ''), 'rudra')));
         $isKpstaProposal = ($proposal->proposal_id == 3 || $proposal->id == 3 || $proposal->url_slug == 'kpsta-website' || (isset($customer) && (str_contains(strtolower($customer->name ?? ''), 'kpsta') || str_contains(strtolower($customer->name ?? ''), 'kerala pradesh') || str_contains(strtolower($customer->name ?? ''), 'teacher'))));
     @endphp
      @if(!$isRudraProposal && !$isKpstaProposal)
      <div class="row justify-content-between align-items-center mb-3">
          <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
              <div class="all-button-box mx-2">
                  <a href="{{ route('proposal.pdf', Crypt::encrypt($proposal->id))}}" target="_blank" class="btn btn-primary mt-3" >
                      {{__('Download')}}
                  </a>
              </div>
              <div class="all-button-box mx-2">
                  <button type="button" class="btn btn-outline-primary mt-3" data-role="proposal-read-aloud"
                          data-tts-audio-url="{{ $proposal->getTtsAudioUrl(\App::getLocale() ?? 'en') }}"
                          data-tts-segments="{{ json_encode($proposal->getSpeechSegments($settings)) }}">
                      <i class="ti ti-volume-2"></i> {{ __('Read Aloud') }}
                  </button>
              </div>
          </div>
      </div>
      @endif
     <div class="row">
         <div class="col-12">
             @if($isKpstaProposal)
                 @include('proposal.kpsta_proposal_view')
             @elseif($isRudraProposal)
                 @if($proposal->url_slug == 'rudra-spirit-agreement' || request()->get('doc') == '1' || request()->get('view') == 'agreement' || ($proposal->proposal_id == 1 && $proposal->url_slug != 'rudra-spirit-hosting'))
                     @include('proposal.rudra_agreement_view')
                 @else
                     @include('proposal.rudra_proposal_view')
                 @endif
             @else
             <div class="card">
                 <div class="card-body">
                     <div class="proposal">
                         <div class="proposal-print">
                            <div class="row invoice-title mt-2">
                                 <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                     <h2>{{__('Proposal')}}</h2>
                                 </div>
                                 <div class="col-12">
                                     <hr>
                                 </div>
                             </div>
                             <div class="row">
                                 @if(!empty($customer->billing_name))
                                     <div class="col">
                                         <small class="font-style">
                                             <strong>{{__('Billed To')}} :</strong><br>
                                             {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                                             {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                                             {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                                             {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                                             {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?$customer->billing_state:'',', '}} {{!empty($customer->billing_country)?$customer->billing_country:''}}
                                         </small>
                                     </div>
                                 @endif
                                 @if(\Utility::companyData($proposal->created_by,'shipping_display')=='on')
                                     <div class="col">
                                         <small>
                                             <strong>{{__('Shipped To')}} :</strong><br>
                                             {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                                             {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                                             {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                                             {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                                             {{!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '}} {{!empty($customer->shipping_state)?$customer->shipping_state:'' .', '}},{{!empty($customer->shipping_country)?$customer->shipping_country:''}}
                                         </small>
                                     </div>
                                 @endif
                                 <div class="col">
                                     <div class="float-end mt-3">
                                        @if(($settings['qr_display'] ?? null) == 'on')
                                         {!! DNS2D::getBarcodeHTML($proposal->getPublicUrl(), "QRCODE",2,2) !!}
                                        @endif
                                     </div>
                                 </div>

                             </div>
                             <div class="row mt-2">
                                <div class="col">
                                    @if(($company_setting['vat_gst_number_switch'] ?? null) == 'on')
                                    @if(!empty($company_setting['tax_type']) && !empty($company_setting['vat_number'])){{$company_setting['tax_type'].' '. __('Number')}} : {{$company_setting['vat_number']}} <br>@endif

                                    <strong>{{__('Tax Number ')}} : </strong>{{!empty($customer->tax_number)?$customer->tax_number:'--'}}
                                    @endif
                                </div>
                            </div>
                             <div class="row mt-3">
                                 <div class="col">
                                     <small>
                                         <strong>{{__('Status')}} :</strong><br>
                                         @if($proposal->status == 0)
                                             <span class="badge badge-pill badge-primary">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                         @elseif($proposal->status == 1)
                                             <span class="badge badge-pill badge-info">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                         @elseif($proposal->status == 2)
                                             <span class="badge badge-pill badge-success">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                         @elseif($proposal->status == 3)
                                             <span class="badge badge-pill badge-warning">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                         @elseif($proposal->status == 4)
                                             <span class="badge badge-pill badge-danger">{{ __(\App\Models\Proposal::$statues[$proposal->status]) }}</span>
                                         @endif
                                     </small>
                                 </div>

                                 <div class="row">
                                     <div class="col text-end">
                                         <div class="d-flex align-items-center justify-content-end">
                                             <div class="me-4">
                                                 <small>
                                                     <strong>{{__('Issue Date')}} :</strong><br>
                                                     {{$user->dateFormat($proposal->issue_date)}}<br><br>
                                                 </small>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             @if(!empty($customFields) && count($proposal->customField)>0)
                                     @foreach($customFields as $field)
                                         <div class="col text-md-right">
                                             <small>
                                                 <strong>{{$field->name}} :</strong><br>
                                                 {{!empty($proposal->customField)?$proposal->customField[$field->id]:'-'}}
                                                 <br><br>
                                             </small>
                                         </div>
                                     @endforeach
                                 @endif
                             </div>
                             <div class="row mt-4">
                                 <div class="col-md-12">
                                     <div class="font-weight-bold">{{__('Product Summary')}}</div>
                                     <small>{{__('All items here cannot be deleted.')}}</small>
                                     <div class="table-responsive mt-2">
                                         <table class="table mb-0 table-striped">
                                             <tr>
                                                 <th class="text-dark" data-width="40">#</th>
                                                 <th class="text-dark">{{__('Product')}}</th>
                                                 <th class="text-dark">{{__('Quantity')}}</th>
                                                 <th class="text-dark">{{__('Rate')}}</th>
                                                 <th class="text-dark">{{__('Tax')}}</th>
                                                 <th class="text-dark"> {{__('Discount')}}</th>
                                                 <th class="text-dark">{{__('Description')}}</th>
                                                 <th class="text-end text-dark" width="12%">{{__('Price')}}<br>
                                                     <small class="text-danger font-weight-bold">{{__('after tax & discount')}}</small>
                                                 </th>
                                             </tr>
                                             @php
                                                 $totalQuantity=0;
                                                 $totalRate=0;
                                                 $totalTaxPrice=0;
                                                 $totalDiscount=0;
                                                 $taxesData=[];
                                            @endphp

                                            @foreach($iteams as $key =>$iteam)
                                                @if(!empty($iteam->tax))
                                                    @php
                                                        $taxes=\Utility::tax($iteam->tax);
                                                        $totalQuantity+=$iteam->quantity;
                                                        $totalRate+=$iteam->price;
                                                        $totalDiscount+=$iteam->discount;
                                                        foreach($taxes as $taxe){
                                                            $taxDataPrice=\Utility::taxRate($taxe->rate,$iteam->price,$iteam->quantity);
                                                            if (array_key_exists($taxe->name,$taxesData))
                                                            {
                                                                $taxesData[$taxe->name] = $taxesData[$taxe->name]+$taxDataPrice;
                                                            }
                                                            else
                                                            {
                                                                $taxesData[$taxe->name] = $taxDataPrice;
                                                            }
                                                        }
                                                    @endphp
                                                @endif
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{!empty($iteam->product)?$iteam->product->name:''}}</td>
                                                    <td>{{$iteam->quantity}}</td>
                                                    <td>{{\App\Models\Utility::priceFormat($settings,$iteam->price)}}</td>
                                                    <td>
                                                        @if(!empty($iteam->tax))
                                                            <table>
                                                                @php $totalTaxRate = 0;@endphp
                                                                @foreach($taxes as $tax)
                                                                    @php
                                                                        $taxPrice=\Utility::taxRate($tax->rate,$iteam->price,$iteam->quantity);
                                                                        $totalTaxPrice+=$taxPrice;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{$tax->name .' ('.$tax->rate .'%)'}}</td>
                                                                        <td>{{\App\Models\Utility::priceFormat($settings,$taxPrice)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{\App\Models\Utility::priceFormat($settings,$iteam->discount)}}</td>
                                                    <td>{{!empty($iteam->description)?$iteam->description:'-'}}</td>
                                                    <td class="text-end">{{\App\Models\Utility::priceFormat($settings,$iteam->price*$iteam->quantity)}}</td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td><b>{{__('Total')}}</b></td>
                                                <td><b>{{$totalQuantity}}</b></td>
                                                <td><b>{{\App\Models\Utility::priceFormat($settings,$totalRate)}}</b></td>
                                                <td><b>{{\App\Models\Utility::priceFormat($settings,$totalTaxPrice)}}</b></td>
                                                <td><b>{{\App\Models\Utility::priceFormat($settings,$totalDiscount)}}</b></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Sub Total')}}</b></td>
                                                <td class="text-end">{{\App\Models\Utility::priceFormat($settings,$proposal->getSubTotal())}}</td>
                                            </tr>
                                            <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{__('Discount')}}</b></td>
                                                    <td class="text-end">{{\App\Models\Utility::priceFormat($settings,$proposal->getTotalDiscount())}}</td>
                                                </tr>

                                            @if(!empty($taxesData))
                                                @foreach($taxesData as $taxName => $taxPrice)
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b>{{$taxName}}</b></td>
                                                        <td class="text-end">{{ \App\Models\Utility::priceFormat($settings,$taxPrice) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="blue-text text-end"><b>{{__('Total')}}</b></td>
                                                <td class="blue-text text-end">{{\App\Models\Utility::priceFormat($settings,$proposal->getTotal())}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($isKpstaProposal)
                @include('proposal.kpsta_proposal_view')
            @endif
            @endif
        </div>
    </div>

    {{-- Client Collaboration & Asset Upload Hub --}}
    <div class="row mt-4">
        <div class="col-12">
            @include('proposal.client_collaboration')
        </div>
    </div>

    @if(!$isRudraProposal && !$isKpstaProposal)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Status & Actions') }}</h5>
                </div>
                <div class="card-body">

                    {{-- Validity --}}
                    @if($proposal->valid_till)
                        <p class="text-muted mb-3">
                            <i class="ti ti-calendar-due"></i>
                            {{ __('Valid till') }} <strong>{{ $user->dateFormat($proposal->valid_till) }}</strong>
                            @if($isExpired && $isPending)
                                <span class="badge bg-danger ms-1">{{ __('Expired') }}</span>
                            @endif
                        </p>
                    @endif

                    {{-- Terms --}}
                    @if(!empty($proposal->terms))
                        <div class="alert alert-light border mb-4">
                            <strong>{{ __('Terms') }}:</strong>
                            <div style="white-space:pre-line">{{ $proposal->terms }}</div>
                        </div>
                    @endif

                    {{-- Decision banner / actions --}}
                    @if($isAccepted)
                        <div class="alert alert-success d-flex align-items-center gap-2">
                            <i class="ti ti-circle-check fs-4"></i>
                            <div>
                                <strong>{{ __('Accepted') }}</strong>
                                @if($proposal->accepted_at)
                                    — {{ $user->dateFormat($proposal->accepted_at) }}
                                @endif
                            </div>
                        </div>
                    @elseif($isDeclined)
                        <div class="alert alert-secondary d-flex align-items-center gap-2">
                            <i class="ti ti-circle-x fs-4"></i>
                            <div>
                                <strong>{{ __('Declined') }}</strong>
                                @if($proposal->declined_at)
                                    — {{ $user->dateFormat($proposal->declined_at) }}
                                @endif
                                @if($proposal->decline_reason)
                                    <br><small class="text-muted">{{ $proposal->decline_reason }}</small>
                                @endif
                            </div>
                        </div>
                    @elseif($isExpired)
                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="ti ti-clock-exclamation fs-4"></i>
                            <div>{{ __('This proposal has expired. Please contact us for a revised quote.') }}</div>
                        </div>
                    @else
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            {!! Form::open(['route' => ['proposal.public.approve', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)], 'method' => 'POST', 'class' => 'd-inline']) !!}
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-check"></i> {{ __('Approve Proposal') }}
                            </button>
                            {!! Form::close() !!}

                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#declineModal">
                                <i class="ti ti-x"></i> {{ __('Decline') }}
                            </button>
                        </div>

                        <div class="modal fade" id="declineModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    {!! Form::open(['route' => ['proposal.public.decline', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)], 'method' => 'POST']) !!}
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Decline this proposal') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label">{{ __('Reason (optional)') }}</label>
                                        <textarea name="reason" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-danger">{{ __('Decline Proposal') }}</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Payment summary --}}
                    <hr>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-4">
                            <small class="text-muted d-block">{{ __('Total') }}</small>
                            <strong class="fs-5">{{ \App\Models\Utility::priceFormat($settings, $proposal->getTotal()) }}</strong>
                        </div>
                        <div class="col-sm-4">
                            <small class="text-muted d-block">{{ __('Paid') }}</small>
                            <strong class="fs-5 text-success">{{ \App\Models\Utility::priceFormat($settings, $totalPaid) }}</strong>
                        </div>
                        <div class="col-sm-4">
                            <small class="text-muted d-block">{{ __('Due') }}</small>
                            <strong class="fs-5 {{ $totalDue > 0 ? 'text-danger' : 'text-success' }}">{{ \App\Models\Utility::priceFormat($settings, max($totalDue, 0)) }}</strong>
                        </div>
                    </div>

                    @if($proposal->payments->count() > 0)
                        <div class="table-responsive mb-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Method') }}</th>
                                        <th>{{ __('Reference') }}</th>
                                        <th class="text-end">{{ __('Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proposal->payments as $payment)
                                        <tr>
                                            <td>{{ $user->dateFormat($payment->date) }}</td>
                                            <td>{{ ucfirst($payment->payment_type) }}</td>
                                            <td class="text-muted">{{ $payment->transaction_id }}</td>
                                            <td class="text-end">{{ \App\Models\Utility::priceFormat($settings, $payment->amount) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Pay Now --}}
                    @if(!$isDeclined && !$isExpired && $totalDue > 0)
                        <div class="border rounded p-3 text-center">
                            @if(!empty($razorpayKey))
                                <button id="rzpProposalPayBtn" type="button" class="btn btn-primary btn-lg">
                                    <i class="ti ti-shield-check"></i> {{ __('Pay Now') }} — {{ \App\Models\Utility::priceFormat($settings, $totalDue) }}
                                </button>
                                <p class="text-muted small mt-2 mb-0"><i class="ti ti-lock"></i> {{ __('Secured by Razorpay') }}</p>
                            @else
                                <p class="text-muted mb-0">{{ __('Online payment is not configured yet. Please contact us to arrange payment.') }}</p>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(!$isDeclined && !$isExpired && $totalDue > 0 && !empty($razorpayKey))
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('rzpProposalPayBtn').addEventListener('click', function () {
            var options = {
                key: "{{ $razorpayKey }}",
                amount: {{ (int) round($totalDue * 100) }},
                currency: "INR",
                name: "{{ Utility::companyData($proposal->created_by, 'title_text') ?: config('app.name', 'ANIMAZON') }}",
                description: "{{ __('Proposal') }} {{ $user->proposalNumberFormat($proposal->proposal_id) }}",
                handler: function (response) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('proposal.public.pay.razorpay', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)) }}";

                    var csrf = document.createElement('input');
                    csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = "{{ csrf_token() }}";
                    form.appendChild(csrf);

                    var payId = document.createElement('input');
                    payId.type = 'hidden'; payId.name = 'razorpay_payment_id'; payId.value = response.razorpay_payment_id;
                    form.appendChild(payId);

                    var amt = document.createElement('input');
                    amt.type = 'hidden'; amt.name = 'amount'; amt.value = "{{ $totalDue }}";
                    form.appendChild(amt);

                    document.body.appendChild(form);
                    form.submit();
                },
                prefill: {
                    name: "{{ $customer->name ?? '' }}",
                    email: "{{ $customer->email ?? '' }}",
                    contact: "{{ $customer->contact ?? '' }}"
                },
                theme: { color: "#0f9c86" }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        });
    </script>
@endif

<footer id="footer-main">
    <div class="footer-dark">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                <div class="col-md-6">
                    <div class="copyright text-sm font-weight-bold text-center text-md-left">
                        {{!empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : ''}}
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-dribbble"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>

<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>


<script src="{{ asset('js/jscolor.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/proposal-read-aloud.js') }}"></script>

@if($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! $message !!}');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! $message !!}');
    </script>
@endif

@if($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif





