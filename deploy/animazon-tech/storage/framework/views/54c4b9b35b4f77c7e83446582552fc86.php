<?php if(isset($projects) && !empty($projects) && count($projects) > 0): ?>
    <div class="col-12">
        <div class="row">

            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xxl-3 col-md-4 col-sm-6 col-12 d-flex">
                <div class="card w-100 border-0 rounded-3 overflow-hidden">
                    <div class="card-header d-flex align-items-center justify-content-between bg-light p-3">
                        <div class="d-flex align-items-center flex-1">
                            <img <?php echo e($project->img_image); ?>

                                class="img-fluid rounded-1 border border-2 border-primary me-2" alt=""
                                width="40" height="40">
                            <h5 class="mb-0 text-truncate">
                                <a class="text-dark text-decoration-none"
                                    href="<?php echo e(route('projects.show', $project)); ?>"><?php echo e($project->project_name); ?></a>
                            </h5>
                        </div>
                        <div class="dropdown">
                            <?php if(Gate::check('create project') ||
                                Gate::check('edit project') ||
                                Gate::check('delete project')): ?>
                                <button class="btn p-0 border-0 text-muted" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu icon-dropdown dropdown-menu-end">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create project')): ?>
                                        <li><a class="dropdown-item" data-ajax-popup="true" data-size="md"
                                                data-title="<?php echo e(__('Duplicate Project')); ?>"
                                                data-url="<?php echo e(route('project.copy', [$project->id])); ?>">
                                                <i class="ti ti-copy"></i> <?php echo e(__('Duplicate')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit project')): ?>
                                        <li><a class="dropdown-item" href="#!" data-size="lg"
                                                data-url="<?php echo e(route('projects.edit', $project->id)); ?>"
                                                data-ajax-popup="true" data-title="<?php echo e(__('Edit Project')); ?>">
                                                <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete project')): ?>
                                        <li>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $project->id]]); ?>

                                            <a href="#!" class="dropdown-item text-danger bs-pass-para">
                                                <i class="ti ti-trash"></i> <?php echo e(__('Delete')); ?></a>
                                            <?php echo Form::close(); ?>

                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <span
                            class="badge bg-light-<?php echo e(\App\Models\Project::$status_color[$project->status]); ?> py-1 px-2 text-uppercase mb-3"><?php echo e(__(\App\Models\Project::$project_status[$project->status])); ?></span>
                        <p class="text-muted text-sm"><?php echo e($project->description); ?></p>
                        <small class="fw-bold text-muted"><?php echo e(__('MEMBERS')); ?></small>
                        <div class="d-flex mt-2">
                            <?php $__currentLoopData = $project->users->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e($user->avatar ? asset('/storage/uploads/avatar/' . $user->avatar) : asset('/storage/uploads/avatar/avatar.png')); ?>"
                                    class="rounded-circle border shadow-sm me-1" width="30" height="30"
                                    title="<?php echo e($user->name); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-3 d-flex justify-content-between">
                        <div>
                            <h6 class="<?php echo e(strtotime($project->start_date) < time() ? 'text-danger' : ''); ?>">
                                <?php echo e(Utility::getDateFormated($project->start_date)); ?></h6>
                            <p class="text-muted text-sm mb-0"><?php echo e(__('Start Date')); ?></p>
                        </div>
                        <div class="text-end">
                            <h6><?php echo e(isset($project->end_date) ? Utility::getDateFormated($project->end_date) : '-'); ?></h6>
                            <p class="text-muted text-sm mb-0"><?php echo e(__('Due Date')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

<?php else: ?>
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h6 class="text-center mb-0"><?php echo e(__('No Projects Found.')); ?></h6>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH D:\PROJECTS\WEBSITES\animazon-tech\resources\views/projects/grid.blade.php ENDPATH**/ ?>