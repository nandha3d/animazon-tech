@extends('layouts.admin')

@section('page-title') {{__('Gantt Chart')}} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.show',$project->id)}}">    {{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{__('Gantt Chart')}}</li>
@endsection


@section('action-btn')
<div class="float-end">
    <div class="btn-group mr-2" id="change_view" role="group">
        <a href="{{route('projects.gantt',[$project->id,'Quarter Day'])}}" class="btn btn-primary @if($duration == 'Quarter Day')active @endif" data-value="Quarter Day">{{__('Quarter Day')}}</a>
        <a href="{{route('projects.gantt',[$project->id,'Half Day'])}}" class="btn btn-primary @if($duration == 'Half Day')active @endif" data-value="Half Day">{{__('Half Day')}}</a>
        <a href="{{route('projects.gantt',[$project->id,'Day'])}}" class="btn btn-primary @if($duration == 'Day')active @endif" data-value="Day">{{__('Day')}}</a>
        <a href="{{route('projects.gantt',[$project->id,'Week'])}}" class="btn btn-primary @if($duration == 'Week')active @endif" data-value="Week">{{__('Week')}}</a>
        <a href="{{route('projects.gantt',[$project->id,'Month'])}}" class="btn btn-primary @if($duration == 'Month')active @endif" data-value="Month">{{__('Month')}}</a>
    </div>
    @can('manage project')
        <a href="{{ route('projects.show',$project->id) }}" class="btn btn-primary " data-bs-toggle="tooltip" title="{{__('Back')}}">
            <span class="btn-inner--icon"><i class="ti ti-arrow-left"></i></span>
        </a>
    @endcan
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if($project && ($costEstimate || $projectInvoices->count() > 0))
                <div class="card mb-3">
                    <div class="card-body d-flex flex-wrap align-items-center gap-3 py-2">
                        <strong class="me-2"><i class="ti ti-link"></i> {{ __('Linked Billing') }}:</strong>
                        @if($costEstimate)
                            <span class="badge bg-info p-2 px-3 rounded">
                                {{ __('Estimate') }}: {{ ucfirst($costEstimate->status) }}
                                ({{ $costEstimate->currency_code }} {{ number_format($costEstimate->grand_total, 2) }})
                            </span>
                        @endif
                        @if($projectInvoices->count() > 0)
                            @foreach($projectInvoices as $inv)
                                <a href="{{ route('invoice.show', \Crypt::encrypt($inv->id)) }}"
                                    class="badge bg-primary p-2 px-3 rounded text-white">
                                    {{ \Auth::user()->invoiceNumberFormat($inv->invoice_id) }} —
                                    {{ __(\App\Models\Invoice::$statues[$inv->status]) }}
                                </a>
                            @endforeach
                        @else
                            <span class="text-muted">{{ __('No invoice generated yet.') }}</span>
                        @endif
                    </div>
                </div>
            @endif
            <div class="card card-stats border-0">
                <div class="card-body"></div>
                @if($project)
                    <div class="gantt-target"></div>
                @else
                    <h1>404</h1>
                    <div class="page-description">
                        {{ __('Page Not Found') }}
                    </div>
                    <div class="page-search">
                        <p class="text-muted mt-3">{{ __("It's looking like you may have taken a wrong turn. Don't worry... it happens to the best of us. Here's a little tip that might help you get back on track.")}}</p>
                        <div class="mt-3">
                            <a class="btn-return-home badge-blue" href="{{route('dashboard')}}"><i class="ti ti-reply"></i> {{ __('Return Home')}}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@if($project)
    @push('css-page')
        <link rel="stylesheet" href="{{asset('css/frappe-gantt.css')}}" />
        <style>
            .bar-wrapper.milestone .bar { fill: #6f42c1; }
            .bar-wrapper.milestone .bar-progress { fill: #4b2c85; }
        </style>
    @endpush
    @push('script-page')
        @php
            $currantLang = basename(App::getLocale());
        @endphp
        <script>
            const month_names = {
                "{{$currantLang}}": [
                    '{{__('January')}}',
                    '{{__('February')}}',
                    '{{__('March')}}',
                    '{{__('April')}}',
                    '{{__('May')}}',
                    '{{__('June')}}',
                    '{{__('July')}}',
                    '{{__('August')}}',
                    '{{__('September')}}',
                    '{{__('October')}}',
                    '{{__('November')}}',
                    '{{__('December')}}'
                ],
                "en": [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
            };
        </script>
        <script src="{{asset('js/frappe-gantt.js')}}"></script>
        <script>
            var tasks = JSON.parse('{!! addslashes(json_encode($tasks)) !!}');
            var gantt_chart = new Gantt(".gantt-target", tasks, {
                custom_popup_html: function(task) {
                    var status_class = 'success';
                    if(task.custom_class == 'medium'){
                        status_class = 'info'
                    }else if(task.custom_class == 'high'){
                        status_class = 'danger'
                    }
                    return `<div class="details-container">
                                <div class="title">${task.name} <span class="badge badge-${status_class} float-right">${task.extra.priority}</span></div>
                                <div class="subtitle">
                                    <b>${task.progress}%</b> {{ __('Progress')}} <br>
                                    <b>${task.extra.comments}</b> {{ __('Comments')}} <br>
                                    <b>{{ __('Duration')}}</b> ${task.extra.duration}
                                </div>
                            </div>
                          `;
                },
                on_click: function (task) {
                },
                on_date_change: function(task, start, end) {
                    // Milestones are read-only markers on this timeline, not draggable tasks.
                    if (String(task.id).indexOf('milestone_') === 0) {
                        return;
                    }
                    task_id = task.id;
                    start = moment(start);
                    end = moment(end);
                    $.ajax({
                        url: "{{route('projects.gantt.post',[$project->id])}}",
                        data:{
                            start:start.format('YYYY-MM-DD HH:mm:ss'),
                            end:end.format('YYYY-MM-DD HH:mm:ss'),
                            task_id:task_id,
                            _token : "{{ csrf_token() }}",
                        },
                        type:'POST',
                        success:function (data) {

                        },
                        error:function (data) {
                            show_toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                        }
                    });
                },
                view_mode: '{{$duration}}',
                language: '{{$currantLang}}'
            });
        </script>
    @endpush
@endif
