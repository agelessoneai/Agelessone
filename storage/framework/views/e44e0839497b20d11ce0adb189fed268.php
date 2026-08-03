<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$initials = strtoupper(substr($user->name,0,1));
?>

<style>

:root{--bg:#0e1320;--card:#151b29;--card2:#1c2436;--line:#262f47;--text:#e8edf6;--muted:#8794ac;--blue:#3f6fe0;--purple:#9b6bff;--green:#37c281;--red:#ff5a6e;--orange:#f2b53b}
body{margin:0;background:var(--bg);color:var(--text);font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.mobile-app-shell { max-width: 100% !important; margin: 0 !important; border-radius: 0 !important; border: 0 !important; min-height: 100vh !important; }
.app-content { padding: 0 !important; }
.container{max-width:100%!important;padding:0!important;margin:0!important}
.full-wrapper {
    min-height: 100vh;
    padding: 18px;
    padding-bottom: 90px;
    background: var(--bg);
}
.left-panel {
    background: radial-gradient(circle at top right,rgba(91,140,255,.25),transparent 30%),radial-gradient(circle at bottom left,rgba(155,107,255,.22),transparent 30%),var(--bg);
    border-radius: 24px;
    padding: 18px;
}
.right-panel {
    margin-top: 24px;
}
.desktop-title { display: none; }
.app-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
.profile{display:flex;align-items:center;gap:12px}
.avatar{width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,var(--blue),var(--purple));display:grid;place-items:center;font-weight:800;font-size:18px}
.profile h3{font-size:18px;margin:0}.profile p{margin:2px 0 0;color:var(--muted);font-size:12px}
.logout{background:var(--card);border:1px solid var(--line);color:var(--text);border-radius:14px;padding:10px 14px;font-size:13px;transition:.2s}
.logout:hover{background:var(--card2)}
.title{font-size:24px;font-weight:800;margin:8px 0 4px}.sub{color:var(--muted);font-size:13px;margin-bottom:18px}

@media(min-width:1024px){
    .full-wrapper {
        display: grid;
        grid-template-columns: 450px 1fr;
        gap: 24px;
        padding: 24px;
        align-items: start;
        min-height: 100vh;
    }
    .left-panel {
        padding: 24px;
        border: 1px solid var(--line);
        border-radius: 24px;
        min-height: calc(100vh - 48px);
    }
    .right-panel {
        background: radial-gradient(circle at top left,rgba(91,140,255,.05),transparent 40%), var(--bg);
        border: 1px solid var(--line);
        border-radius: 24px;
        padding: 32px;
        margin-top: 0;
        min-height: calc(100vh - 48px);
    }
    .bottom-nav {
        max-width: 500px;
        margin: auto;
        left: 0;
        right: 0;
        bottom: 24px;
    }
}
.ticket-card{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:18px;margin-bottom:16px}
.ticket-top{display:flex;justify-content:space-between;gap:10px;margin-bottom:12px}
.ticket-no{font-weight:800;color:#fff}.date{color:var(--muted);font-size:12px}
.badge{padding:6px 10px;border-radius:999px;font-size:11px;font-weight:800}
.priority-low{background:rgba(135,148,172,.18);color:var(--muted)}
.priority-normal{background:rgba(91,140,255,.18);color:#8fb0ff}
.priority-high{background:rgba(242,181,59,.18);color:var(--orange)}
.priority-urgent{background:rgba(255,90,110,.18);color:var(--red)}
.status{background:var(--card2);color:#fff}
.st-pending{background:rgba(242,181,59,.18);color:var(--orange)}
.st-accepted{background:rgba(55,194,129,.18);color:var(--green)}
.st-rejected{background:rgba(255,90,110,.18);color:var(--red)}
.info{margin-top:12px}.info span{display:block;color:var(--muted);font-size:12px;margin-bottom:3px}.info b{font-size:15px}
.actions{margin-top:16px;display:grid;gap:10px}
.site-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px}
.btn-green,.btn-blue,.btn-red{border:0;border-radius:16px;padding:14px;color:#fff;font-weight:800;width:100%;cursor:pointer}
.btn-green{background:linear-gradient(135deg,var(--green),#22c55e)}
.btn-blue{background:linear-gradient(135deg,var(--blue),var(--purple))}
.btn-red{background:linear-gradient(135deg,var(--red),#ef4444)}
.empty{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:28px;text-align:center;color:var(--muted)}
.bottom-nav{position:fixed;left:12px;right:12px;bottom:12px;background:rgba(21,27,41,.95);border:1px solid var(--line);border-radius:24px;display:grid;grid-template-columns:repeat(4,1fr);padding:10px 6px;backdrop-filter:blur(16px);z-index:100}
.bottom-nav a{text-align:center;color:var(--muted);text-decoration:none;font-size:11px}.bottom-nav a.active{color:#fff}.bottom-nav i{display:block;font-style:normal;font-size:20px;margin-bottom:3px}
.mobile-input{width:100%;background:var(--card2);border:1px solid var(--line);color:#fff;border-radius:16px;padding:13px;margin-bottom:10px;font-size:14px}
.mobile-input::placeholder{color:var(--muted)}

/* Modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center}
.modal-overlay.active{display:flex}
.modal-box{background:#151b29;border:1px solid var(--line);border-radius:28px;padding:36px 32px;max-width:380px;width:90%;text-align:center;animation:modalIn .25s ease}
@keyframes modalIn{from{transform:scale(.88);opacity:0}to{transform:scale(1);opacity:1}}
.modal-icon{font-size:48px;margin-bottom:14px}
.modal-title{font-size:20px;font-weight:800;margin-bottom:8px}
.modal-msg{font-size:14px;color:var(--muted);margin-bottom:28px}
.modal-actions{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.modal-cancel{background:var(--card2);border:1px solid var(--line);color:var(--text);border-radius:16px;padding:14px;font-size:15px;font-weight:700;cursor:pointer;transition:.2s}
.modal-cancel:hover{background:var(--line)}
.modal-confirm{border:0;border-radius:16px;padding:14px;font-size:15px;font-weight:800;color:#fff;width:100%;cursor:pointer}
</style>

<div class="full-wrapper">

    <div class="left-panel">
        <div class="app-header">
            <div class="profile">
                <div class="avatar"><?php echo e($initials); ?></div>
                <div>
                    <h3><?php echo e($user->name); ?></h3>
                    <p>Staff Service Panel</p>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout">Logout</button>
            </form>
        </div>

        <div class="title">My Tickets</div>

        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div class="ticket-card">

                <div class="ticket-top">
                    <div>
                        <div class="ticket-no"><?php echo e($ticket->ticket_no); ?></div>
                        <div class="date"><?php echo e($ticket->created_at->format('d M Y h:i A')); ?></div>
                    </div>

                    <span class="badge priority-<?php echo e($ticket->priority); ?>">
                        <?php echo e(ucfirst($ticket->priority)); ?>

                    </span>
                </div>

                <span class="badge status">
                    <?php echo e(str_replace('_',' ',ucfirst($ticket->status))); ?>

                </span>

                <div class="info">
                    <span>Park</span>
                    <b><?php echo e($ticket->park->name); ?></b>
                </div>

                <div class="info">
                    <span>Item / Ride</span>
                    <b><?php echo e($ticket->item_name); ?></b>
                </div>

                <div class="info">
                    <span>Complaint</span>
                    <b><?php echo e($ticket->complaint_title); ?></b>
                </div>

                <?php if($ticket->complaint_description): ?>
                    <div class="info">
                        <span>Details</span>
                        <b><?php echo e($ticket->complaint_description); ?></b>
                    </div>
                <?php endif; ?>

               <div class="actions">
                <?php if($ticket->status == 'accepted' && $ticket->travel_status != 'travelling'): ?>
                    <button class="btn-blue" type="button" onclick="startTravel(<?php echo e($ticket->id); ?>)">
                        🚗 Start Travel
                    </button>
                <?php endif; ?>

                <?php if($ticket->travel_status == 'travelling'): ?>
                    <button class="btn-green" type="button" onclick="markArrived(<?php echo e($ticket->id); ?>)">
                        📍 Mark Arrived
                    </button>
                <?php endif; ?>

                <?php if($ticket->status == 'pending'): ?>
                    <form method="POST" action="<?php echo e(route('tickets.accept',$ticket->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn-green">✅ Accept Job</button>
                    </form>
                <?php endif; ?>

                <?php if($ticket->status == 'accepted'): ?>
                    <form method="POST" action="<?php echo e(route('tickets.start',$ticket->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn-blue">▶ Start Work</button>
                    </form>
                <?php endif; ?>

                <?php if(in_array($ticket->status, ['work_started','need_spare_parts'])): ?>

                    <form method="POST" action="<?php echo e(route('tickets.update',$ticket->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="update_type" value="progress">
                        <textarea name="note" class="mobile-input" rows="3" placeholder="Work progress note"></textarea>
                        <input type="file" name="image" class="mobile-input" accept="image/*" capture="environment">
                        <button class="btn-blue">📝 Add Progress Update</button>
                    </form>

                    <form method="POST" action="<?php echo e(route('tickets.update',$ticket->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="update_type" value="spare_parts">
                        <input type="text" name="spare_parts" class="mobile-input" placeholder="Required spare parts">
                        <textarea name="note" class="mobile-input" rows="2" placeholder="Reason / details"></textarea>
                        <input type="file" name="image" class="mobile-input" accept="image/*" capture="environment">
                        <button class="btn-red">📦 Request Spare Parts</button>
                    </form>

                    <form method="POST" action="<?php echo e(route('tickets.complete',$ticket->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <textarea name="note" class="mobile-input" rows="3" placeholder="Completion note" required></textarea>
                        <input type="file" name="image" class="mobile-input" accept="image/*" capture="environment">
                        <button class="btn-green">✅ Complete Ticket</button>
                    </form>

                <?php endif; ?>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty">
                No tickets assigned yet.
            </div>
        <?php endif; ?>
    </div>

    <div class="right-panel">
        <div class="title" style="font-size:24px;">Site Tickets</div>
        <div class="sub">Work assigned to you from a work site</div>

        <?php $__empty_1 = true; $__currentLoopData = $siteTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siteTicket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="ticket-card">
                <div class="ticket-top">
                    <div>
                        <div class="ticket-no">Site ticket #<?php echo e($siteTicket->id); ?></div>
                        <div class="date"><?php echo e($siteTicket->created_at->format('d M Y h:i A')); ?></div>
                    </div>
                    <span class="badge <?php echo e($siteTicket->status == 'pending' ? 'st-pending' : ($siteTicket->status == 'accepted' ? 'st-accepted' : 'st-rejected')); ?>">
                        <?php echo e(ucfirst($siteTicket->status)); ?>

                    </span>
                </div>

                <div class="info">
                    <span>Site</span>
                    <b><?php echo e($siteTicket->site?->site_name ?? 'Site unavailable'); ?></b>
                </div>

                <div class="info">
                    <span>Zone</span>
                    <b><?php echo e($siteTicket->zone?->zone_name ?? 'Not specified'); ?></b>
                </div>

                <div class="info">
                    <span>Work required</span>
                    <b><?php echo e($siteTicket->work); ?></b>
                </div>

                <?php if($siteTicket->note): ?>
                    <div class="info">
                        <span>Note</span>
                        <b><?php echo e($siteTicket->note); ?></b>
                    </div>
                <?php endif; ?>

                <?php if($siteTicket->status == 'pending'): ?>
                    <div class="site-actions">
                        <button class="btn-green" type="button" onclick="openSiteModal(<?php echo e($siteTicket->id); ?>, 'accept')">
                            ✅ Accept
                        </button>
                        <button class="btn-red" type="button" onclick="openSiteModal(<?php echo e($siteTicket->id); ?>, 'reject')">
                            ❌ Reject
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty">
                No site tickets assigned yet.
            </div>
        <?php endif; ?>
    </div>

</div>


<div id="siteTicketModal" class="modal-overlay" onclick="closeModalBg(event)">
    <div class="modal-box">
        <div id="modalIcon" class="modal-icon"></div>
        <div id="modalTitle" class="modal-title"></div>
        <div id="modalMsg" class="modal-msg"></div>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closeSiteModal()">Cancel</button>
            <form id="modalForm" method="POST">
                <?php echo csrf_field(); ?>
                <button id="modalConfirmBtn" class="modal-confirm" type="submit"></button>
            </form>
        </div>
    </div>
</div>

<div class="bottom-nav">
    <a href="<?php echo e(route('user.dashboard')); ?>"><i>🏠</i>Home</a>
    <a href="<?php echo e(route('staff.tickets')); ?>" class="active"><i>🎫</i>Tickets</a>
    <a href="#"><i>👤</i>Profile</a>
    <a href="#"><i>⚙</i>Settings</a>
</div>

<script>
let watchId = null;

function startTravel(ticketId){
    fetch(`/tickets/${ticketId}/travel/start`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
            "Accept": "application/json"
        }
    }).then(() => {
        alert("Travel started. Live tracking enabled.");

        watchId = navigator.geolocation.watchPosition(function(position){
            fetch(`/tickets/${ticketId}/travel/location`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                })
            });
        }, function(){
            alert("Please allow location permission.");
        }, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 15000
        });

        setTimeout(() => location.reload(), 1000);
    });
}

function markArrived(ticketId){
    fetch(`/tickets/${ticketId}/travel/arrived`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
            "Accept": "application/json"
        }
    }).then(() => {
        if(watchId){
            navigator.geolocation.clearWatch(watchId);
        }
        alert("Marked as arrived.");
        location.reload();
    });
}

function openSiteModal(id, action) {
    const modal = document.getElementById('siteTicketModal');
    const form  = document.getElementById('modalForm');
    const btn   = document.getElementById('modalConfirmBtn');
    const icon  = document.getElementById('modalIcon');
    const title = document.getElementById('modalTitle');
    const msg   = document.getElementById('modalMsg');

    if (action === 'accept') {
        icon.textContent  = '✅';
        title.textContent = 'Accept Site Ticket?';
        msg.textContent   = 'You are confirming that you accept this site ticket and will proceed with the assigned work.';
        btn.textContent   = 'Accept';
        btn.style.background = 'linear-gradient(135deg,#37c281,#22c55e)';
        form.action = `/site-tickets/${id}/accept`;
    } else {
        icon.textContent  = '❌';
        title.textContent = 'Reject Site Ticket?';
        msg.textContent   = 'You are declining this site ticket. It will be marked as rejected.';
        btn.textContent   = 'Reject';
        btn.style.background = 'linear-gradient(135deg,#ff5a6e,#ef4444)';
        form.action = `/site-tickets/${id}/reject`;
    }

    modal.classList.add('active');
}

function closeSiteModal() {
    document.getElementById('siteTicketModal').classList.remove('active');
}

function closeModalBg(e) {
    if (e.target.id === 'siteTicketModal') closeSiteModal();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\user\tickets\index.blade.php ENDPATH**/ ?>