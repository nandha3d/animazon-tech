<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Leads')); ?> <?php if($pipeline): ?>
        - <?php echo e($pipeline->name); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/dragula.min.css')); ?>" id="main-style-link">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('css/summernote/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/dragula.min.js')); ?>"></script>
    <script>
        ! function(a) {
            "use strict";
            var t = function() {
                this.$body = a("body")
            };
            t.prototype.init = function() {
                a('[data-plugin="dragula"]').each(function() {
                    var t = a(this).data("containers"),
                        n = [];
                    if (t)
                        for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]);
                    else n = [a(this)[0]];
                    var r = a(this).data("handleclass");
                    r ? dragula(n, {
                        moves: function(a, t, n) {
                            return n.classList.contains(r)
                        }
                    }) : dragula(n).on('drop', function(el, target, source, sibling) {

                        var order = [];
                        $("#" + target.id + " > div").each(function() {
                            order[$(this).index()] = $(this).attr('data-id');
                        });

                        var id = $(el).attr('data-id');

                        var old_status = $("#" + source.id).data('status');
                        var new_status = $("#" + target.id).data('status');
                        var stage_id = $(target).attr('data-id');
                        var pipeline_id = '<?php echo e($pipeline->id); ?>';

                        $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div")
                            .length);
                        $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div")
                            .length);
                        $.ajax({
                            url: '<?php echo e(route('leads.order')); ?>',
                            type: 'POST',
                            data: {
                                lead_id: id,
                                stage_id: stage_id,
                                order: order,
                                new_status: new_status,
                                old_status: old_status,
                                pipeline_id: pipeline_id,
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                show_toastr(data.status, data.message, data.status);
                            },
                            error: function(data) {
                                data = data.responseJSON;
                                show_toastr(data.status, data.message, data.status)
                            }
                        });
                    });
                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery),
        function(a) {
            "use strict";

            a.Dragula.init()

        }(window.jQuery);
    </script>
    <script>
        $(document).on("change", "#default_pipeline_id", function() {
            $('#change-pipeline').submit();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Lead')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end ">
        <?php echo e(Form::open(['route' => 'deals.change.pipeline', 'id' => 'change-pipeline', 'class' => 'btn btn-sm'])); ?>

        <?php echo e(Form::select('default_pipeline_id', $pipelines, $pipeline->id, ['class' => 'form-control select me-2', 'id' => 'default_pipeline_id'])); ?>

        <?php echo e(Form::close()); ?>


        <a href="<?php echo e(route('leads.list')); ?>" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('List View')); ?>"
            class="btn btn-sm bg-light-blue-subtitle me-1">
            <i class="ti ti-list"></i>
        </a>
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('leads.import')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Import Lead CSV file')); ?>"
            class="btn btn-sm bg-brown-subtitle me-1">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="<?php echo e(route('leads.export')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>"
            class="btn btn-sm btn-secondary me-1">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="#" data-size="lg" data-url="<?php echo e(route('leads.create')); ?>" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="<?php echo e(__('Create New Lead')); ?>" data-title="<?php echo e(__('Create Lead')); ?>"
            class="btn btn-sm btn-primary me-1">
            <i class="ti ti-plus"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
                $lead_stages = $pipeline->leadStages;
                $json = [];
                foreach ($lead_stages as $lead_stage) {
                    $json[] = 'task-list-' . $lead_stage->id;
                }
            ?>
            <div class="row kanban-wrapper horizontal-scroll-cards" data-containers='<?php echo json_encode($json); ?>'
                data-plugin="dragula">
                <?php $__currentLoopData = $lead_stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead_stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($leads = $lead_stage->lead()); ?>
                    <div class="col">
                        <div class="crm-sales-card mb-4">
                            <div class="card-header d-flex align-items-center justify-content-between gap-3">
                                <h4 class="mb-0"><?php echo e($lead_stage->name); ?></h4>
                                <span class="f-w-600 count"><?php echo e(count($leads)); ?></span>
                            </div>
                            <div class="sales-item-wrp" id="task-list-<?php echo e($lead_stage->id); ?>"
                                data-id="<?php echo e($lead_stage->id); ?>">
                                <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="sales-item" data-id="<?php echo e($lead->id); ?>">
                                        <div class="sales-item-top border-bottom">
                                            <div class="d-flex align-items-center">
                                                <h5 class="mb-0 flex-1">
                                                    <a href="<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view lead')): ?><?php if($lead->is_active): ?><?php echo e(route('leads.show', $lead->id)); ?><?php else: ?>#<?php endif; ?> <?php else: ?>#<?php endif; ?>"
                                                        class="dashboard-link"><?php echo e($lead->name); ?></a>
                                                </h5>
                                                <?php if(Auth::user()->type != 'client'): ?>
                                                    <div class="btn-group card-option">
                                                        <button type="button" class="btn p-0 border-0"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu icon-dropdown dropdown-menu-end">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                                                <a href="#!" data-size="md"
                                                                    data-url="<?php echo e(URL::to('leads/' . $lead->id . '/labels')); ?>"
                                                                    data-ajax-popup="true" class="dropdown-item"
                                                                    data-bs-original-title="<?php echo e(__('Add Labels')); ?>">
                                                                    <i class="ti ti-bookmark"></i>
                                                                    <span><?php echo e(__('Labels')); ?></span>
                                                                </a>

                                                                <a href="#!" data-size="lg"
                                                                    data-url="<?php echo e(URL::to('leads/' . $lead->id . '/edit')); ?>"
                                                                    data-ajax-popup="true" class="dropdown-item"
                                                                    data-bs-original-title="<?php echo e(__('Edit Lead')); ?>">
                                                                    <i class="ti ti-pencil"></i>
                                                                    <span><?php echo e(__('Edit')); ?></span>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete lead')): ?>
                                                                <?php echo Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['leads.destroy', $lead->id],
                                                                    'id' => 'delete-form-' . $lead->id,
                                                                ]); ?>

                                                                <a href="#!" class="dropdown-item bs-pass-para">
                                                                    <i class="ti ti-trash"></i>
                                                                    <span> <?php echo e(__('Delete')); ?> </span>
                                                                </a>
                                                                <?php echo Form::close(); ?>

                                                            <?php endif; ?>


                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="badge-wrp d-flex flex-wrap align-items-center gap-2">
                                                <?php ($labels = $lead->labels()); ?>
                                                <?php if($labels): ?>
                                                    <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div
                                                            class="badge-xs badge bg-light-<?php echo e($label->color); ?> p-2 rounded text-md f-w-600">
                                                            <?php echo e($label->name); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                        $products = $lead->products();
                                        $sources = $lead->sources();
                                        ?>
                                        <div class="sales-item-bottom d-flex align-items-center justify-content-between">
                                            <ul class="d-flex flex-wrap align-items-center gap-2 p-0 m-0">
                                                <li class="d-inline-flex align-items-center gap-1 p-1 px-2 border rounded-1"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Product')); ?>">
                                                    <i class="f-16 ti ti-shopping-cart"></i> <?php echo e(count($products)); ?>

                                                </li>
                                                <li class="d-inline-flex align-items-center gap-1 p-1 px-2 border rounded-1"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Source')); ?>">
                                                    <i class="f-16 ti ti-social"></i><?php echo e(count($sources)); ?>

                                                </li>
                                            </ul>
                                            <div class="user-group">
                                                <?php $__currentLoopData = $lead->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <img src="<?php if($user->avatar): ?> <?php echo e(asset('/storage/uploads/avatar/' . $user->avatar)); ?> <?php else: ?> <?php echo e(asset('storage/uploads/avatar/avatar.png')); ?> <?php endif; ?>"
                                                        alt="image" data-bs-toggle="tooltip"
                                                        title="<?php echo e($user->name); ?>">
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECTS\WEBSITES\animazon-tech\resources\views/leads/index.blade.php ENDPATH**/ ?>