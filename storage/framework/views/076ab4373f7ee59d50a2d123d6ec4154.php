
<?php $__env->startSection('content'); ?>

<style>
body{background:#0e1320;color:#e8edf6;overflow:hidden}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:0!important}

.app{display:grid;grid-template-columns:270px 1fr;height:100vh}
.side{background:#151b29;border-right:1px solid #262f47}
.brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
.logo{width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#5b8cff,#9b6bff);display:grid;place-items:center;font-weight:800;font-size:22px;color:#fff}
.brand h1{margin:0;font-size:17px}
.brand p{margin:0;font-size:11px;color:#8794ac}

.nav-title{padding:18px 24px 8px;font-size:11px;color:#8794ac;font-weight:700;letter-spacing:1px}
.nav a{display:flex;padding:14px 22px;text-decoration:none;color:#a8b4cc}
.nav a.active{background:#3f6fe0;color:#fff;border-radius:0 12px 12px 0}

.main{overflow:auto}
.top{height:76px;background:#151b29;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #262f47}
.search{width:450px;padding:13px;background:#0e1320;border:1px solid #262f47;border-radius:12px;color:#fff}
.user{margin-left:auto;display:flex;align-items:center;gap:12px}
.avatar{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#5b8cff,#37c281);display:grid;place-items:center;font-weight:700;color:#fff}
.logout{background:transparent;border:1px solid #334155;padding:10px 18px;color:#fff;border-radius:10px}

.content{padding:30px}
.card-dark{background:#151b29;border:1px solid #262f47;border-radius:18px;padding:25px}
.muted{color:#8794ac}

.stats{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:25px}
.stat{background:#151b29;border:1px solid #262f47;border-radius:18px;padding:18px}
.stat h2{margin:0;font-size:34px;font-weight:900;color:#fff}
.stat p{margin:6px 0 0;font-size:13px;color:#8794ac}
.pending{border-left:5px solid #f2b53b}
.accepted{border-left:5px solid #3f6fe0}
.working{border-left:5px solid #37c281}
.spare{border-left:5px solid #ff5a6e}
.completed{border-left:5px solid #22c55e}

.table{width:100%;color:#fff!important;margin-bottom:0}
.table thead th{background:#0e1320;color:#8fa3c7!important;border-color:#262f47!important;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:15px}
.table tbody td{background:#151b29;color:#ffffff!important;border-color:#262f47!important;vertical-align:middle;font-size:15px;font-weight:500;padding:15px}
.table tbody tr:hover td{background:#1c2436}
.table td strong{color:#ffffff!important;font-weight:800}

.btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:10px;padding:10px 16px;text-decoration:none}
.badge-status{padding:6px 12px;border-radius:20px;font-size:12px;font-weight:700}
</style>

<div class="stats">
                <div class="stat pending">
                    <h2><?php echo e($pending); ?></h2>
                    <p>Pending</p>
                </div>

                <div class="stat accepted">
                    <h2><?php echo e($accepted); ?></h2>
                    <p>Accepted</p>
                </div>

                <div class="stat working">
                    <h2><?php echo e($working); ?></h2>
                    <p>Working</p>
                </div>

                <div class="stat spare">
                    <h2><?php echo e($spare); ?></h2>
                    <p>Need Spare</p>
                </div>

                <div class="stat completed">
                    <h2><?php echo e($completed); ?></h2>
                    <p>Completed</p>
                </div>
            </div>

            <div class="card-dark">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3>Complaint Tickets</h3>
                        <p class="muted mb-0">Park complaint assignment and staff work status</p>
                    </div>

                    <a href="<?php echo e(route('admin.tickets.create')); ?>" class="btn-blue">+ Add Ticket</a>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Park</th>
                                <th>Item</th>
                                <th>Complaint</th>
                                <th>Staff</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('admin.tickets.show', $ticket->id)); ?>"
                                           style="color:#fff;font-weight:800;text-decoration:none;">
                                            <?php echo e($ticket->ticket_no); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($ticket->park->name); ?></td>
                                    <td><?php echo e($ticket->item_name); ?></td>
                                    <td><?php echo e($ticket->complaint_title); ?></td>
                                    <td><?php echo e($ticket->staff->name ?? '-'); ?></td>
                                    <td><?php echo e(ucfirst($ticket->priority)); ?></td>
                                    <td>
                                        <span class="badge-status bg-primary">
                                            <?php echo e(str_replace('_',' ',ucfirst($ticket->status))); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($ticket->created_at->format('d M Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php echo e($tickets->links()); ?>


            </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\admin\tickets\index.blade.php ENDPATH**/ ?>