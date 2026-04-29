<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Deals')); ?> <?php if($pipeline): ?>
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
                            url: '<?php echo e(route('deals.order')); ?>',
                            type: 'POST',
                            data: {
                                deal_id: id,
                                stage_id: stage_id,
                                order: order,
                                new_status: new_status,
                                old_status: old_status,
                                pipeline_id: pipeline_id,
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                show_toastr(data.status, data.message, data.status)
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
    <li class="breadcrumb-item"><?php echo e(__('Deal')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php echo e(Form::open(['route' => 'deals.change.pipeline', 'id' => 'change-pipeline', 'class' => 'btn btn-sm'])); ?>

        <?php echo e(Form::select('default_pipeline_id', $pipelines, $pipeline->id, ['class' => 'form-control select me-4', 'id' => 'default_pipeline_id'])); ?>

        <?php echo e(Form::close()); ?>


        <a href="<?php echo e(route('deals.list')); ?>" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('List View')); ?>"
            class="btn btn-sm bg-light-blue-subtitle me-1">
            <i class="ti ti-list"></i>
        </a>
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('deals.import')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Import Deal CSV file')); ?>"
            class="btn btn-sm bg-brown-subtitle me-1">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="<?php echo e(route('deals.export')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>"
            class="btn btn-sm btn-secondary me-1">
            <i class="ti ti-file-export"></i>
        </a>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create deal')): ?>
            <a href="#" data-size="lg" data-url="<?php echo e(route('deals.create')); ?>" data-ajax-popup="true"
                data-bs-toggle="tooltip" title="<?php echo e(__('Create New Deal')); ?>" data-title="<?php echo e(__('Create Deal')); ?>"
                class="btn btn-sm btn-primary me-1">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row mb-4 gy-4">
    <div class="col-xxl-3 col-md-4 col-sm-6 col-12 deals-card">
        <div class="deals-card-inner d-flex align-items-center gap-3">
            <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                    fill="#FF3A6E"></path>
            </svg>

            <div class="deals-icon">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_63_1597)">
                        <path
                            d="M12.4261 4.64887C12.8269 4.64887 13.1519 4.32388 13.1519 3.92301V1.52567C13.1519 1.1248 12.8269 0.799805 12.4261 0.799805C12.0252 0.799805 11.7002 1.1248 11.7002 1.52567V3.92301C11.7002 4.32388 12.0252 4.64887 12.4261 4.64887Z"
                            fill="white" />
                        <path
                            d="M15.8138 5.88077C15.9996 5.88077 16.1853 5.80987 16.327 5.66814L18.2627 3.7325C18.5461 3.44907 18.5461 2.98945 18.2627 2.70598C17.9792 2.42255 17.5196 2.42255 17.2361 2.70598L15.3005 4.64162C15.017 4.92504 15.017 5.38466 15.3005 5.66814C15.4422 5.80987 15.628 5.88077 15.8138 5.88077Z"
                            fill="white" />
                        <path
                            d="M8.52525 5.66814C8.66698 5.80987 8.85276 5.88077 9.03848 5.88077C9.22421 5.88077 9.41003 5.80987 9.55172 5.66814C9.83519 5.38471 9.83519 4.92509 9.55172 4.64162L7.61608 2.70598C7.33265 2.42255 6.87303 2.42255 6.58956 2.70598C6.30608 2.9894 6.30608 3.44902 6.58956 3.7325L8.52525 5.66814Z"
                            fill="white" />
                        <path
                            d="M18.9459 11.0591L16.1282 8.24129C15.5836 7.69675 14.8451 7.39087 14.0751 7.39087H9.66765C8.56893 7.39087 7.53603 7.81874 6.75916 8.59561L6.52717 8.82755L6.51217 8.84255H0.763951C0.36308 8.84255 0.0380859 9.16754 0.0380859 9.56841V17.311C0.0380859 17.7118 0.36308 18.0368 0.763951 18.0368H4.38297L6.10602 19.7598C6.24215 19.896 6.42676 19.9725 6.61926 19.9725H7.27651C7.03324 19.5959 6.87665 19.1753 6.81534 18.735C6.27268 18.5585 5.78437 18.2326 5.40828 17.7843C4.31493 16.4812 4.48551 14.5316 5.78853 13.4382L8.5474 11.1233H14.0559C14.2484 11.1233 14.4331 11.1997 14.5692 11.3359L16.5959 13.3626C17.2468 14.0135 18.3261 14.0274 18.9658 13.3655C19.5873 12.7225 19.5806 11.6938 18.9459 11.0591Z"
                            fill="white" />
                        <path
                            d="M24.8138 11.0684C24.8138 10.6674 24.4888 10.3425 24.0879 10.3425H20.2425C21.1706 11.5557 21.081 13.3031 19.972 14.4122C19.3875 14.9966 18.6097 15.3185 17.7821 15.3185C16.9543 15.3185 16.1766 14.9966 15.5922 14.4122L13.7549 12.5749H8.93948L8.36929 13.0533L6.52777 14.5985C5.8368 15.1783 5.74669 16.2084 6.32646 16.8994C6.90624 17.5904 7.93638 17.6805 8.62736 17.1007C7.93638 17.6805 7.84628 18.7106 8.42605 19.4016C9.00583 20.0926 10.036 20.1827 10.7269 19.6029C10.036 20.1827 9.94587 21.2128 10.5256 21.9038C11.1054 22.5948 12.1356 22.6849 12.8265 22.1051L14.112 21.0264L13.9387 21.1719C13.2477 21.7517 13.1576 22.7819 13.7374 23.4728C14.3171 24.1638 15.3473 24.2539 16.0382 23.6741L20.969 19.5367H24.088C24.4889 19.5367 24.8139 19.2117 24.8139 18.8109L24.8138 11.0684Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_63_1597">
                            <rect width="24.7762" height="24.7762" fill="white"
                                transform="translate(0.0380859 0.0400391)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="deals-content flex-1">
                <h4 class="h6"><?php echo e(__('Total Deals')); ?></h4>
                <h5 class="m-0"><?php echo e($cnt_deal['total']); ?></h5>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-4 col-sm-6 col-12 deals-card">
        <div class="deals-card-inner d-flex align-items-center gap-3">
            <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                    fill="#FF3A6E"></path>
            </svg>
            <div class="deals-icon">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_63_1597)">
                        <path
                            d="M12.4261 4.64887C12.8269 4.64887 13.1519 4.32388 13.1519 3.92301V1.52567C13.1519 1.1248 12.8269 0.799805 12.4261 0.799805C12.0252 0.799805 11.7002 1.1248 11.7002 1.52567V3.92301C11.7002 4.32388 12.0252 4.64887 12.4261 4.64887Z"
                            fill="white" />
                        <path
                            d="M15.8138 5.88077C15.9996 5.88077 16.1853 5.80987 16.327 5.66814L18.2627 3.7325C18.5461 3.44907 18.5461 2.98945 18.2627 2.70598C17.9792 2.42255 17.5196 2.42255 17.2361 2.70598L15.3005 4.64162C15.017 4.92504 15.017 5.38466 15.3005 5.66814C15.4422 5.80987 15.628 5.88077 15.8138 5.88077Z"
                            fill="white" />
                        <path
                            d="M8.52525 5.66814C8.66698 5.80987 8.85276 5.88077 9.03848 5.88077C9.22421 5.88077 9.41003 5.80987 9.55172 5.66814C9.83519 5.38471 9.83519 4.92509 9.55172 4.64162L7.61608 2.70598C7.33265 2.42255 6.87303 2.42255 6.58956 2.70598C6.30608 2.9894 6.30608 3.44902 6.58956 3.7325L8.52525 5.66814Z"
                            fill="white" />
                        <path
                            d="M18.9459 11.0591L16.1282 8.24129C15.5836 7.69675 14.8451 7.39087 14.0751 7.39087H9.66765C8.56893 7.39087 7.53603 7.81874 6.75916 8.59561L6.52717 8.82755L6.51217 8.84255H0.763951C0.36308 8.84255 0.0380859 9.16754 0.0380859 9.56841V17.311C0.0380859 17.7118 0.36308 18.0368 0.763951 18.0368H4.38297L6.10602 19.7598C6.24215 19.896 6.42676 19.9725 6.61926 19.9725H7.27651C7.03324 19.5959 6.87665 19.1753 6.81534 18.735C6.27268 18.5585 5.78437 18.2326 5.40828 17.7843C4.31493 16.4812 4.48551 14.5316 5.78853 13.4382L8.5474 11.1233H14.0559C14.2484 11.1233 14.4331 11.1997 14.5692 11.3359L16.5959 13.3626C17.2468 14.0135 18.3261 14.0274 18.9658 13.3655C19.5873 12.7225 19.5806 11.6938 18.9459 11.0591Z"
                            fill="white" />
                        <path
                            d="M24.8138 11.0684C24.8138 10.6674 24.4888 10.3425 24.0879 10.3425H20.2425C21.1706 11.5557 21.081 13.3031 19.972 14.4122C19.3875 14.9966 18.6097 15.3185 17.7821 15.3185C16.9543 15.3185 16.1766 14.9966 15.5922 14.4122L13.7549 12.5749H8.93948L8.36929 13.0533L6.52777 14.5985C5.8368 15.1783 5.74669 16.2084 6.32646 16.8994C6.90624 17.5904 7.93638 17.6805 8.62736 17.1007C7.93638 17.6805 7.84628 18.7106 8.42605 19.4016C9.00583 20.0926 10.036 20.1827 10.7269 19.6029C10.036 20.1827 9.94587 21.2128 10.5256 21.9038C11.1054 22.5948 12.1356 22.6849 12.8265 22.1051L14.112 21.0264L13.9387 21.1719C13.2477 21.7517 13.1576 22.7819 13.7374 23.4728C14.3171 24.1638 15.3473 24.2539 16.0382 23.6741L20.969 19.5367H24.088C24.4889 19.5367 24.8139 19.2117 24.8139 18.8109L24.8138 11.0684Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_63_1597">
                            <rect width="24.7762" height="24.7762" fill="white"
                                transform="translate(0.0380859 0.0400391)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="deals-content flex-1">
                <h4 class="h6"><?php echo e(__('This Month Total Deals')); ?></h4>
                <h5 class="m-0"><?php echo e($cnt_deal['this_month']); ?></h5>
            </div>

        </div>
    </div>
    <div class="col-xxl-3 col-md-4 col-sm-6 col-12 deals-card">
        <div class="deals-card-inner d-flex align-items-center gap-3">
            <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                    fill="#FF3A6E"></path>
            </svg>
            <div class="deals-icon">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_63_1597)">
                        <path
                            d="M12.4261 4.64887C12.8269 4.64887 13.1519 4.32388 13.1519 3.92301V1.52567C13.1519 1.1248 12.8269 0.799805 12.4261 0.799805C12.0252 0.799805 11.7002 1.1248 11.7002 1.52567V3.92301C11.7002 4.32388 12.0252 4.64887 12.4261 4.64887Z"
                            fill="white" />
                        <path
                            d="M15.8138 5.88077C15.9996 5.88077 16.1853 5.80987 16.327 5.66814L18.2627 3.7325C18.5461 3.44907 18.5461 2.98945 18.2627 2.70598C17.9792 2.42255 17.5196 2.42255 17.2361 2.70598L15.3005 4.64162C15.017 4.92504 15.017 5.38466 15.3005 5.66814C15.4422 5.80987 15.628 5.88077 15.8138 5.88077Z"
                            fill="white" />
                        <path
                            d="M8.52525 5.66814C8.66698 5.80987 8.85276 5.88077 9.03848 5.88077C9.22421 5.88077 9.41003 5.80987 9.55172 5.66814C9.83519 5.38471 9.83519 4.92509 9.55172 4.64162L7.61608 2.70598C7.33265 2.42255 6.87303 2.42255 6.58956 2.70598C6.30608 2.9894 6.30608 3.44902 6.58956 3.7325L8.52525 5.66814Z"
                            fill="white" />
                        <path
                            d="M18.9459 11.0591L16.1282 8.24129C15.5836 7.69675 14.8451 7.39087 14.0751 7.39087H9.66765C8.56893 7.39087 7.53603 7.81874 6.75916 8.59561L6.52717 8.82755L6.51217 8.84255H0.763951C0.36308 8.84255 0.0380859 9.16754 0.0380859 9.56841V17.311C0.0380859 17.7118 0.36308 18.0368 0.763951 18.0368H4.38297L6.10602 19.7598C6.24215 19.896 6.42676 19.9725 6.61926 19.9725H7.27651C7.03324 19.5959 6.87665 19.1753 6.81534 18.735C6.27268 18.5585 5.78437 18.2326 5.40828 17.7843C4.31493 16.4812 4.48551 14.5316 5.78853 13.4382L8.5474 11.1233H14.0559C14.2484 11.1233 14.4331 11.1997 14.5692 11.3359L16.5959 13.3626C17.2468 14.0135 18.3261 14.0274 18.9658 13.3655C19.5873 12.7225 19.5806 11.6938 18.9459 11.0591Z"
                            fill="white" />
                        <path
                            d="M24.8138 11.0684C24.8138 10.6674 24.4888 10.3425 24.0879 10.3425H20.2425C21.1706 11.5557 21.081 13.3031 19.972 14.4122C19.3875 14.9966 18.6097 15.3185 17.7821 15.3185C16.9543 15.3185 16.1766 14.9966 15.5922 14.4122L13.7549 12.5749H8.93948L8.36929 13.0533L6.52777 14.5985C5.8368 15.1783 5.74669 16.2084 6.32646 16.8994C6.90624 17.5904 7.93638 17.6805 8.62736 17.1007C7.93638 17.6805 7.84628 18.7106 8.42605 19.4016C9.00583 20.0926 10.036 20.1827 10.7269 19.6029C10.036 20.1827 9.94587 21.2128 10.5256 21.9038C11.1054 22.5948 12.1356 22.6849 12.8265 22.1051L14.112 21.0264L13.9387 21.1719C13.2477 21.7517 13.1576 22.7819 13.7374 23.4728C14.3171 24.1638 15.3473 24.2539 16.0382 23.6741L20.969 19.5367H24.088C24.4889 19.5367 24.8139 19.2117 24.8139 18.8109L24.8138 11.0684Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_63_1597">
                            <rect width="24.7762" height="24.7762" fill="white"
                                transform="translate(0.0380859 0.0400391)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="deals-content flex-1">
                <h4 class="h6"><?php echo e(__('This Week Total Deals')); ?></h4>
                <h5 class="m-0"><?php echo e($cnt_deal['this_week']); ?></h5>
            </div>

        </div>
    </div>
    <div class="col-xxl-3 col-md-4 col-sm-6 col-12 deals-card">
        <div class="deals-card-inner d-flex align-items-center gap-3">
            <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                    fill="#FF3A6E"></path>
            </svg>
            <div class="deals-icon">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_63_1597)">
                        <path
                            d="M12.4261 4.64887C12.8269 4.64887 13.1519 4.32388 13.1519 3.92301V1.52567C13.1519 1.1248 12.8269 0.799805 12.4261 0.799805C12.0252 0.799805 11.7002 1.1248 11.7002 1.52567V3.92301C11.7002 4.32388 12.0252 4.64887 12.4261 4.64887Z"
                            fill="white" />
                        <path
                            d="M15.8138 5.88077C15.9996 5.88077 16.1853 5.80987 16.327 5.66814L18.2627 3.7325C18.5461 3.44907 18.5461 2.98945 18.2627 2.70598C17.9792 2.42255 17.5196 2.42255 17.2361 2.70598L15.3005 4.64162C15.017 4.92504 15.017 5.38466 15.3005 5.66814C15.4422 5.80987 15.628 5.88077 15.8138 5.88077Z"
                            fill="white" />
                        <path
                            d="M8.52525 5.66814C8.66698 5.80987 8.85276 5.88077 9.03848 5.88077C9.22421 5.88077 9.41003 5.80987 9.55172 5.66814C9.83519 5.38471 9.83519 4.92509 9.55172 4.64162L7.61608 2.70598C7.33265 2.42255 6.87303 2.42255 6.58956 2.70598C6.30608 2.9894 6.30608 3.44902 6.58956 3.7325L8.52525 5.66814Z"
                            fill="white" />
                        <path
                            d="M18.9459 11.0591L16.1282 8.24129C15.5836 7.69675 14.8451 7.39087 14.0751 7.39087H9.66765C8.56893 7.39087 7.53603 7.81874 6.75916 8.59561L6.52717 8.82755L6.51217 8.84255H0.763951C0.36308 8.84255 0.0380859 9.16754 0.0380859 9.56841V17.311C0.0380859 17.7118 0.36308 18.0368 0.763951 18.0368H4.38297L6.10602 19.7598C6.24215 19.896 6.42676 19.9725 6.61926 19.9725H7.27651C7.03324 19.5959 6.87665 19.1753 6.81534 18.735C6.27268 18.5585 5.78437 18.2326 5.40828 17.7843C4.31493 16.4812 4.48551 14.5316 5.78853 13.4382L8.5474 11.1233H14.0559C14.2484 11.1233 14.4331 11.1997 14.5692 11.3359L16.5959 13.3626C17.2468 14.0135 18.3261 14.0274 18.9658 13.3655C19.5873 12.7225 19.5806 11.6938 18.9459 11.0591Z"
                            fill="white" />
                        <path
                            d="M24.8138 11.0684C24.8138 10.6674 24.4888 10.3425 24.0879 10.3425H20.2425C21.1706 11.5557 21.081 13.3031 19.972 14.4122C19.3875 14.9966 18.6097 15.3185 17.7821 15.3185C16.9543 15.3185 16.1766 14.9966 15.5922 14.4122L13.7549 12.5749H8.93948L8.36929 13.0533L6.52777 14.5985C5.8368 15.1783 5.74669 16.2084 6.32646 16.8994C6.90624 17.5904 7.93638 17.6805 8.62736 17.1007C7.93638 17.6805 7.84628 18.7106 8.42605 19.4016C9.00583 20.0926 10.036 20.1827 10.7269 19.6029C10.036 20.1827 9.94587 21.2128 10.5256 21.9038C11.1054 22.5948 12.1356 22.6849 12.8265 22.1051L14.112 21.0264L13.9387 21.1719C13.2477 21.7517 13.1576 22.7819 13.7374 23.4728C14.3171 24.1638 15.3473 24.2539 16.0382 23.6741L20.969 19.5367H24.088C24.4889 19.5367 24.8139 19.2117 24.8139 18.8109L24.8138 11.0684Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_63_1597">
                            <rect width="24.7762" height="24.7762" fill="white"
                                transform="translate(0.0380859 0.0400391)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="deals-content flex-1">
                <h4 class="h6"><?php echo e(__('Last 30 Days Total Deals')); ?></h4>
                <h5 class="m-0"><?php echo e($cnt_deal['last_30days']); ?></h5>
            </div>

        </div>
    </div>
</div>
    <div class="row">
        <?php
            $stages = $pipeline->stages;
            $json = [];
            foreach ($stages as $stage) {
                $json[] = 'task-list-' . $stage->id;
            }
        ?>
        <div class="row kanban-wrapper horizontal-scroll-cards" data-containers='<?php echo json_encode($json); ?>'
            data-plugin="dragula">
            <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($deals = $stage->deals()); ?>
                <div class="col">
                    <div class="crm-sales-card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between gap-3">
                            <h4 class="mb-0"><?php echo e($stage->name); ?></h4>
                            <span class="f-w-600 count"><?php echo e(count($deals)); ?></span>
                        </div>
                        <div class="sales-item-wrp" id="task-list-<?php echo e($stage->id); ?>" data-id="<?php echo e($stage->id); ?>">
                            <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="sales-item" data-id="<?php echo e($deal->id); ?>">
                                    <div class="sales-item-top border-bottom">
                                        <div class="d-flex align-items-center">
                                            <h5 class="mb-0 flex-1">
                                                <a href="<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view deal')): ?><?php if($deal->is_active): ?><?php echo e(route('deals.show', $deal->id)); ?><?php else: ?>#<?php endif; ?> <?php else: ?>#<?php endif; ?>"
                                                    class="dashboard-link"><?php echo e($deal->name); ?></a>
                                            </h5>
                                            <?php if(Auth::user()->type != 'client'): ?>
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn p-0 border-0"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu icon-dropdown dropdown-menu-end">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit deal')): ?>
                                                            <a href="#!" data-size="md"
                                                                data-url="<?php echo e(URL::to('deals/' . $deal->id . '/labels')); ?>"
                                                                data-ajax-popup="true" class="dropdown-item"
                                                                data-bs-original-title="<?php echo e(__('Labels')); ?>">
                                                                <i class="ti ti-bookmark"></i>
                                                                <span><?php echo e(__('Labels')); ?></span>
                                                            </a>

                                                            <a href="#!" data-size="lg"
                                                                data-url="<?php echo e(URL::to('deals/' . $deal->id . '/edit')); ?>"
                                                                data-ajax-popup="true" class="dropdown-item"
                                                                data-bs-original-title="<?php echo e(__('Edit Deal')); ?>">
                                                                <i class="ti ti-pencil"></i>
                                                                <span><?php echo e(__('Edit')); ?></span>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete deal')): ?>
                                                            <?php echo Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['deals.destroy', $deal->id],
                                                                'id' => 'delete-form-' . $deal->id,
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
                                            <?php ($labels = $deal->labels()); ?>
                                            <?php if($labels): ?>
                                                <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div
                                                        class="badge-xs badge bg-light-<?php echo e($label->color); ?> p-2 rounded text-md f-w-600">
                                                        <?php echo e($label->name); ?></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div
                                        class="sales-item-center border-bottom d-flex align-items-center justify-content-between">
                                        <ul
                                            class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 p-0 m-0">
                                            <li class="d-inline-flex align-items-center gap-1 p-1 px-2 border rounded-1"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Tasks')); ?>">
                                                <i class="f-16 ti ti-list"></i>
                                                <?php echo e(count($deal->tasks)); ?>/<?php echo e(count($deal->complete_tasks)); ?>

                                            </li>
                                            <li class="d-inline-flex align-items-center gap-1 p-1 px-2 border rounded-1">
                                                <i class="f-16 ti ti-report-money"></i>
                                                <?php echo e(\Auth::user()->priceFormat($deal->price)); ?>

                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                    $products = $deal->products();
                                    $sources = $deal->sources();
                                    ?>
                                    <div class="sales-item-bottom d-flex align-items-center justify-content-between">
                                        <ul class="d-flex flex-wrap align-items-center gap-2 p-0 m-0">
                                            <li class="d-inline-flex align-items-center gap-1 p-1 px-2 border rounded-1"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Product')); ?>">
                                                <i class="f-16 ti ti-shopping-cart"></i>
                                                <?php echo e(count($products)); ?>

                                            </li>

                                            <li class="d-inline-flex align-items-center gap-1 p-1 px-2 border rounded-1"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Source')); ?>">
                                                <i class="f-16 ti ti-social"></i>
                                                <?php echo e(count($sources)); ?>

                                            </li>
                                        </ul>
                                        <div class="user-group">
                                            <?php $__currentLoopData = $deal->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img src="<?php if($user->avatar): ?> <?php echo e(asset('/storage/uploads/avatar/' . $user->avatar)); ?> <?php else: ?> <?php echo e(asset('storage/uploads/avatar/avatar.png')); ?> <?php endif; ?>"
                                                    alt="image" data-bs-toggle="tooltip" title="<?php echo e($user->name); ?>">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECTS\WEBSITES\animazon-tech\resources\views/deals/index.blade.php ENDPATH**/ ?>