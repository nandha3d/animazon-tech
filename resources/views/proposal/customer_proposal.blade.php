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

    // Custom overrides for specific proposals to enhance social media previews
    if (isset($proposal) && $proposal->url_slug == 'ipcatn-event') {
        $metatitle = 'IPCATN 2026 Event | On-Screen Presentation & Display Videos';
        $metsdesc = 'Explore the proposal for On-Screen Event Presentation & Display Videos for the upcoming IPCATN 2026 event. Includes screen layouts, showrunner segments, and cost estimates.';
        $meta_image = asset('assets/images/');
        $meta_logo = '/ipcatn_preview.png';
    }

    $get_cookie = \App\Models\Utility::getCookieSetting();
    $settings = DB::table('settings')->where('created_by', $user->creatorId())->pluck('value', 'name')->toArray();

@endphp
    <!DOCTYPE html>

 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
   @if(isset($isPlatinaaProposal) && $isPlatinaaProposal)
   <title>Ceramic balls for refinery industry - website build - Platinaa ceramics</title>
   @elseif(isset($proposal) && $proposal->url_slug == 'ipcatn-event')
   <title>IPCATN 2026 Event | On-Screen Presentation & Display Videos</title>
   @else
   <title>{{(Utility::companyData($proposal->created_by,'title_text')) ? Utility::companyData($proposal->created_by,'title_text') : config('app.name', 'ANIMAZON')}} - {{__('Proposal')}}</title>
   @endif
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
         $isShivRudrakshaProposal = ($proposal->proposal_id == 4 || $proposal->id == 4 || $proposal->url_slug == 'shiv-rudraksha' || (isset($customer) && (str_contains(strtolower($customer->name ?? ''), 'shiv rudraksh') || str_contains(strtolower($customer->name ?? ''), 'guddu shah'))));
         $isBabuProposal = ($proposal->proposal_id == 6 || $proposal->id == 8 || $proposal->url_slug == 'ipcatn-event' || (isset($customer) && (str_contains(strtolower($customer->name ?? ''), 'babu'))));
         $isPlatinaaProposal = !$isBabuProposal && ($proposal->proposal_id == 5 || $proposal->id == 5 || $proposal->url_slug == 'platinaa-ceramics-refinery-estimate' || (isset($customer) && (str_contains(strtolower($customer->name ?? ''), 'platinaa'))));
         $isGenericEcomProposal = ($proposal->url_slug == 'ecom-crm-erp' || (isset($customer) && (str_contains(strtolower($customer->name ?? ''), 'random client'))));
     @endphp
      @if(!$isRudraProposal && !$isKpstaProposal && !$isShivRudrakshaProposal && !$isPlatinaaProposal && !$isBabuProposal && !$isGenericEcomProposal)
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
                          data-tts-voice="{{ $settings['proposal_read_aloud_voice'] ?? 'en-IN-female' }}"
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
             @elseif($isShivRudrakshaProposal)
                 @include('proposal.shiv_rudraksha_proposal_view')
             @elseif($isBabuProposal)
                 @include('proposal.babu_proposal_view')
             @elseif($isGenericEcomProposal)
                 @include('proposal.generic_ecom_proposal_view')
             @elseif($isPlatinaaProposal)
                 @include('proposal.platinaa_proposal_view')
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

    @if(!$isRudraProposal && !$isKpstaProposal && !$isShivRudrakshaProposal && !$isPlatinaaProposal && !$isBabuProposal && !$isGenericEcomProposal)
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

@php
    $chatbot_primary_color = '#0f9c86';
    $chatbot_company_whatsapp = '918089405950';
    $chatbot_company_phone = '+918089405950';
    $chatbot_footer_email = 'hello@animazon.in';
    $chatbot_wa_message = "Hi Animazon! I'm reaching out regarding my proposal.";
    $chatbot_wa_link = 'https://wa.me/' . $chatbot_company_whatsapp . '?text=' . urlencode($chatbot_wa_message);
@endphp

<!-- On-site Live Chat widget -->
<div id="acw" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:inherit;">
    <!-- Chat panel -->
    <div id="acwPanel" style="display:none;flex-direction:column;width:350px;max-width:92vw;height:470px;max-height:72vh;background:#0F1020;border:1px solid #1E293B;border-radius:18px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.5);margin-bottom:14px;">
        <!-- Header -->
        <div style="background:{{ $chatbot_primary_color }};padding:14px 16px;display:flex;align-items:center;gap:11px;color:#fff;">
            <div style="width:38px;height:38px;border-radius:9999px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="ti ti-messages" style="font-size:20px;"></i>
            </div>
            <div style="flex:1;line-height:1.2;">
                <div style="font-weight:700;font-size:15px;">Animazon Support</div>
                <div style="font-size:11px;opacity:.9;"><span style="display:inline-block;width:7px;height:7px;border-radius:9999px;background:#4ade80;margin-right:5px;"></span>Online · replies in minutes</div>
            </div>
            <button type="button" onclick="acwToggle(false)" aria-label="Close chat" style="background:none;border:none;color:#fff;cursor:pointer;font-size:20px;line-height:1;"><i class="ti ti-x"></i></button>
        </div>
        <!-- Messages -->
        <div id="acwMsgs" style="flex:1;overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:10px;background:#0A0A0F;"></div>
        <!-- Input -->
        <form id="acwForm" style="display:flex;gap:8px;padding:10px;border-top:1px solid #1E293B;background:#0F1020;">
            <input id="acwInput" type="text" autocomplete="off" placeholder="Type your message…" style="flex:1;background:#0A0A0F;border:1px solid #1E293B;border-radius:9999px;padding:9px 14px;color:#fff;font-size:13px;outline:none;">
            <button type="submit" aria-label="Send" style="background:{{ $chatbot_primary_color }};border:none;color:#fff;width:40px;height:40px;border-radius:9999px;cursor:pointer;flex-shrink:0;"><i class="ti ti-send" style="font-size:17px;"></i></button>
        </form>
    </div>
    <!-- Bubble -->
    <button type="button" id="acwToggle" onclick="acwToggle()" aria-label="Open live chat"
        style="background:{{ $chatbot_primary_color }};color:#fff;border:none;cursor:pointer;display:flex;align-items:center;gap:9px;border-radius:9999px;padding:12px 18px;box-shadow:0 10px 30px rgba(0,0,0,.35);margin-left:auto;">
        <i id="acwIcon" class="ti ti-message-circle" style="font-size:22px;"></i>
        <span style="font-weight:700;font-size:14px;white-space:nowrap;">Chat with us</span>
    </button>
</div>
<script>
(function () {
    var WA = @json($chatbot_wa_link);
    var WA_BASE = 'https://wa.me/' + @json($chatbot_company_whatsapp);
    var TEL = @json('tel:' . $chatbot_company_phone);
    var EMAIL = @json('mailto:' . $chatbot_footer_email);
    var BRIDGE = @json((bool) config('whatsapp.enabled')); 
    var CSRF = @json(csrf_token());
    var SEND_URL = @json(url('/chat/send'));
    var POLL_URL = @json(url('/chat/poll'));
    var opened = false, greeted = false;

    var SID = localStorage.getItem('acw_sid_p');
    if (!SID) { SID = 'prop-' + Date.now() + '-' + Math.random().toString(36).slice(2, 8); localStorage.setItem('acw_sid_p', SID); }
    var lastId = 0, pollTimer = null;

    window.acwToggle = function (force) {
        var panel = document.getElementById('acwPanel');
        var icon = document.getElementById('acwIcon');
        opened = (typeof force === 'boolean') ? force : !opened;
        panel.style.display = opened ? 'flex' : 'none';
        icon.className = opened ? 'ti ti-chevron-down' : 'ti ti-message-circle';
        if (opened && !greeted) { greeted = true; greet(); }
        if (opened) { setTimeout(function(){ var i=document.getElementById('acwInput'); if(i) i.focus(); }, 50); if (BRIDGE) startPoll(); }
        else { stopPoll(); }
    };

    function startPoll() { if (pollTimer) return; poll(); pollTimer = setInterval(poll, 4000); }
    function stopPoll() { if (pollTimer) { clearInterval(pollTimer); pollTimer = null; } }

    function poll() {
        fetch(POLL_URL + '?session_id=' + encodeURIComponent(SID) + '&after=' + lastId, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.messages) return;
                data.messages.forEach(function (m) { lastId = m.id; bubble(esc(m.body), 'bot'); });
            })
            .catch(function () {});
    }

    function esc(s){ var d=document.createElement('div'); d.textContent=s; return d.innerHTML; }

    function bubble(text, who) {
        var m = document.getElementById('acwMsgs');
        var b = document.createElement('div');
        if (who === 'user') {
            b.style.cssText = 'align-self:flex-end;max-width:80%;background:{{ $chatbot_primary_color }};color:#fff;padding:9px 13px;border-radius:14px 14px 4px 14px;font-size:13px;line-height:1.45;';
        } else {
            b.style.cssText = 'align-self:flex-start;max-width:85%;background:#1A1B2E;color:#E2E8F0;padding:9px 13px;border-radius:14px 14px 14px 4px;font-size:13px;line-height:1.45;';
        }
        b.innerHTML = text;
        m.appendChild(b);
        m.scrollTop = m.scrollHeight;
        return b;
    }

    function actions() {
        var m = document.getElementById('acwMsgs');
        var wrap = document.createElement('div');
        wrap.style.cssText = 'display:flex;flex-wrap:wrap;gap:8px;align-self:flex-start;margin-top:2px;';
        wrap.innerHTML =
            '<a href="'+WA+'" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:6px;background:#25D366;color:#fff;padding:8px 13px;border-radius:9999px;font-size:12px;font-weight:600;text-decoration:none;"><i class="ti ti-brand-whatsapp"></i> WhatsApp</a>'+
            '<a href="'+TEL+'" style="display:inline-flex;align-items:center;gap:6px;background:#1A1B2E;color:#E2E8F0;padding:8px 13px;border-radius:9999px;font-size:12px;font-weight:600;text-decoration:none;"><i class="ti ti-phone"></i> Call</a>'+
            '<a href="'+EMAIL+'" style="display:inline-flex;align-items:center;gap:6px;background:#1A1B2E;color:#E2E8F0;padding:8px 13px;border-radius:9999px;font-size:12px;font-weight:600;text-decoration:none;"><i class="ti ti-mail"></i> Email</a>';
        m.appendChild(wrap);
        m.scrollTop = m.scrollHeight;
    }

    function greet() {
        bubble('👋 Hi! Welcome to Animazon Web Studio. Do you have any questions about this proposal?', 'bot');
        setTimeout(actions, 400);
    }

    function botReply(topic) {
        bubble('Our team is ready to help. Tap below to reach us directly on WhatsApp — we reply fast.', 'bot');
        setTimeout(actions, 200);
    }

    var noteShown = false;
    function send(text) {
        text = (text || '').trim();
        if (!text) return;
        bubble(esc(text), 'user');
        var i = document.getElementById('acwInput'); if (i) i.value = '';

        if (BRIDGE) {
            startPoll();
            fetch(SEND_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ session_id: SID, message: text })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data && data.bridged === false) { WA = WA_BASE + '?text=' + encodeURIComponent(text); setTimeout(function(){ botReply(''); }, 200); return; }
                if (!noteShown) { noteShown = true; setTimeout(function(){ bubble('✅ Sent! Our team will reply right here in a moment.', 'bot'); }, 300); }
            })
            .catch(function () { WA = WA_BASE + '?text=' + encodeURIComponent(text); setTimeout(function(){ botReply(''); }, 200); });
        } else {
            WA = WA_BASE + '?text=' + encodeURIComponent(text + ' — sent from proposal page');
            setTimeout(function(){ botReply(text.length < 24 ? text : ''); }, 350);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var f = document.getElementById('acwForm');
        if (f) f.addEventListener('submit', function (e) { e.preventDefault(); send(document.getElementById('acwInput').value); });
    });
})();
</script>

</body>
</html>





