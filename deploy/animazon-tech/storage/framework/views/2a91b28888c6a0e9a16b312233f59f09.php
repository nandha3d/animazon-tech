<?php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();

    $logo = \App\Models\Utility::get_file('uploads/logo');

    $company_favicon = $setting['company_favicon'] ?? '';

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    $primary_color = $setting['primary_color'] ?? '#00c1de';
    $secondary_color = $setting['secondary_color'] ?? '#ff6122';

    $SITE_RTL = $setting['SITE_RTL'] ?? '';

    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }

    $metatitle = isset($setting['meta_title']) ? $setting['meta_title'] : '';
    $metsdesc = isset($setting['meta_desc']) ? $setting['meta_desc'] : '';
    $meta_logo = isset($setting['meta_image']) ? $setting['meta_image'] : '';

?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">

<meta name="csrf-token" id="csrf-token" content="<?php echo e(csrf_token()); ?>">

<head>
    <title><?php echo e($setting['title_text'] ? $setting['title_text'] : config('app.name', 'ANIMAZON')); ?> - <?php echo $__env->yieldContent('page-title'); ?>
    </title>

    <meta name="title" content="<?php echo e($metatitle); ?>">
    <meta name="description" content="<?php echo e($metsdesc); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($metatitle); ?>">
    <meta property="og:description" content="<?php echo e($metsdesc); ?>">
    <meta property="og:image" content="<?php echo e(\App\Models\Utility::get_file('uploads/meta/' . $meta_logo)); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($metatitle); ?>">
    <meta property="twitter:description" content="<?php echo e($metsdesc); ?>">
    <meta property="twitter:image" content="<?php echo e(\App\Models\Utility::get_file('uploads/meta/' . $meta_logo)); ?>">


    <script src="<?php echo e(asset('js/html5shiv.js')); ?>"></script>


    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="url" content="<?php echo e(url('') . '/' . config('chatify.path')); ?>" data-user="<?php echo e(Auth::user()->id); ?>">
    <link rel="icon"
        href="<?php echo e(\App\Models\Utility::get_file('uploads/logo/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png'))  . '?' . time()); ?>"
        type="image" sizes="16x16">

    <!-- Favicon icon -->
    <!-- Calendar-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/main.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/animate.min.css')); ?>">

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">

    <!-- vendor css -->

    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>

    <?php if($setting['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">


    <link rel="stylesheet" href="<?php echo e(asset('css/custom-color.css')); ?>">
    <?php echo $__env->yieldPushContent('css-page'); ?>

    <style>
        :root {
            --color-customColor: <?php echo e($primary_color); ?>;
            --primary: <?php echo e($primary_color); ?>;
            --secondary: <?php echo e($secondary_color); ?>;
            --bs-primary: <?php echo e($primary_color); ?>;
            --bs-primary-rgb: <?php echo e(implode(',', Utility::hex2rgb($primary_color))); ?>;
            --bs-success: <?php echo e($primary_color); ?>;
            --bs-success-rgb: <?php echo e(implode(',', Utility::hex2rgb($primary_color))); ?>;
        }
        
        /* ===== SIDEBAR: Reset ACTIVE parent items to transparent ===== */
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link,
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.dash-trigger > .dash-link,
        .dash-sidebar.light-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link {
            background-color: transparent !important;
        }
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link i,
        .dash-sidebar .dash-navbar .dash-item.dash-hasmenu.dash-trigger > .dash-link i,
        .dash-sidebar.light-sidebar .dash-navbar .dash-item.dash-hasmenu.active > .dash-link i {
        }

        /* ===== SIDEBAR: Only highlight LEAF submenu items (no children) ===== */
        .dash-sidebar .dash-navbar .dash-submenu > .dash-item.active > .dash-link {
            background-color: <?php echo e($primary_color); ?> !important;
            color: #1e1e2d !important;
            font-weight: 700 !important;
        }
        .dash-sidebar .dash-navbar .dash-submenu > .dash-item.active > .dash-link i {
            color: #1e1e2d !important;
        }

        /* ===== SIDEBAR: Top-level items WITHOUT submenu (e.g. Dashboard, Analytics) ===== */
        .dash-sidebar .dash-navbar > .dash-item.active:not(.dash-hasmenu) > .dash-link {
            background-color: <?php echo e($primary_color); ?> !important;
            color: #1e1e2d !important;
            font-weight: 700 !important;
        }
        .dash-sidebar .dash-navbar > .dash-item.active:not(.dash-hasmenu) > .dash-link i {
            color: #1e1e2d !important;
        }
        
        /* Buttons & Backgrounds */
        .btn-primary, .bg-primary, .btn-success, .bg-success, .dash-link.btn-primary {
            --bs-btn-bg: <?php echo e($primary_color); ?> !important;
            --bs-btn-border-color: <?php echo e($primary_color); ?> !important;
            background-color: <?php echo e($primary_color); ?> !important;
            border-color: <?php echo e($primary_color); ?> !important;
            color: #fff !important;
        }
        
        /* Text Colors */
        .text-primary, .text-success, .dash-link.text-primary, .dash-link.text-success {
            color: <?php echo e($primary_color); ?> !important;
        }

        /* KILL THE GREEN & BLACK - Force Brand Colors Globally */
        .btn-primary, .btn-success, .btn-info, .btn-secondary, .btn-dark,
        .bg-primary, .bg-success, .bg-info, .bg-secondary, .bg-dark,
        .badge-success, .badge-primary, .badge-info,
        .form-check-input:checked,
        .nav-pills .nav-link.active,
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: <?php echo e($primary_color); ?> !important;
            border-color: <?php echo e($primary_color); ?> !important;
            color: #ffffff !important;
        }

        /* Secondary themed buttons use brand secondary (Orange) */
        .btn-warning, .bg-warning {
            background-color: <?php echo e($secondary_color); ?> !important;
            border-color: <?php echo e($secondary_color); ?> !important;
            color: #ffffff !important;
        }

        /* Light variants */
        .btn-light-primary, .btn-outline-primary {
            color: <?php echo e($primary_color); ?> !important;
            border-color: <?php echo e($primary_color); ?> !important;
        }
        
        .btn-light-primary:hover, .btn-outline-primary:hover {
            background-color: <?php echo e($primary_color); ?> !important;
            color: #ffffff !important;
        }

        /* Hover states */
        .btn-primary:hover, .btn-success:hover, .bg-primary:hover, .bg-success:hover {
            background-color: <?php echo e($secondary_color); ?> !important;
            border-color: <?php echo e($secondary_color); ?> !important;
        }



        /* Header Elements */
        .dash-header .header-wrapper .dash-navbar-left .dash-link i,
        .dash-header .header-wrapper .ms-auto .dash-link i {
            color: <?php echo e($primary_color); ?> !important;
        }

        /* Border Accents (Force Brand Color on ALL green/success borders) */
        [style*="border-color: rgb(111, 217, 67)"], 
        [style*="border-color: #6fd943"], 
        .border-primary, 
        .border-success,
        .section-title,
        .page-header h4 {
            border-color: <?php echo e($primary_color); ?> !important;
            border-left-color: <?php echo e($primary_color); ?> !important;
        }
        
        /* Focus/Check states */
        .form-check-input:checked {
            background-color: <?php echo e($primary_color); ?> !important;
            border-color: <?php echo e($primary_color); ?> !important;
        }

        /* Target the specific "Settings" vertical bar in breadcrumbs */
        .page-header .breadcrumb-item.active {
            color: <?php echo e($primary_color); ?> !important;
        }
        /* Force Dark Mode Background if setting is ON */
        <?php if($setting['cust_darklayout'] == 'on'): ?>
        body, body.custom-color {
            background: #22242c !important;
        }
        .dash-sidebar.light-sidebar {
            background: #22242c !important;
        }
        .crm-sales-card {
            background: transparent !important;
        }
        .crm-sales-card .card-header {
            background: #2b2d39 !important;
            border-top: 2px solid <?php echo e($primary_color); ?> !important;
            color: #fff !important;
        }
        .sales-item {
            background: #2b2d39 !important;
            border: 1px solid #3d4052 !important;
            color: #fff !important;
        }
        .sales-item .dashboard-link {
            color: #fff !important;
        }
        <?php endif; ?>
    </style>


</head>



<body class="<?php echo e($themeColor); ?> <?php echo e($setting['cust_darklayout'] == 'on' ? 'dash-sidebar-dark' : 'dash-sidebar-light'); ?>">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <?php echo $__env->make('partials.admin.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <?php echo $__env->make('partials.admin.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Modal -->
    <div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <h6 class="mt-2">
                        <i data-feather="monitor" class="me-2"></i>Desktop settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting1" checked />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting1">Allow desktop notification</label>
                    </div>
                    <p class="text-muted ms-5">
                        you get lettest content at a time when data will updated
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting2" />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting2">Store Cookie</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="save" class="me-2"></i>Application settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting3" />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting3">Backup Storage</label>
                    </div>
                    <p class="text-muted mb-4 ms-5">
                        Automaticaly take backup as par schedule
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting4" />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting4">Allow guest to print
                            file</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="cpu" class="me-2"></i>System settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting5" checked />
                        <label class="form-check-label f-w-600 pl-1" for="pcsetting5">View other user chat</label>
                    </div>
                    <p class="text-muted ms-5">Allow to show public user message</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-light-primary btn-sm">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="dash-container">
        <div class="dash-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <div class="page-header-title">
                                <h4 class="mb-2"><?php echo $__env->yieldContent('page-title'); ?></h4>
                            </div>
                            <ul class="breadcrumb">
                                <?php echo $__env->yieldContent('breadcrumb'); ?>
                            </ul>
                        </div>
                        <div class="action-btn-col">
                            <?php echo $__env->yieldContent('action-btn'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->yieldContent('content'); ?>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php echo $__env->make('partials.admin.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('Chatify::layouts.footerLinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html>
<?php /**PATH D:\PROJECTS\WEBSITES\animazon-tech\resources\views/layouts/admin.blade.php ENDPATH**/ ?>