<<<<<<< HEAD
<?php $__env->startSection('content'); ?>

<style>
body{margin:0;background:#0e1320;color:#e8edf6;overflow:hidden;font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:0!important}

.app{display:grid;grid-template-columns:270px 1fr;height:100vh}
.side{background:#151b29;border-right:1px solid #262f47}
.brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
.logo{
width:48px;
height:48px;
border-radius:14px;
background:linear-gradient(135deg,#5b8cff,#9b6bff);
display:grid;
place-items:center;
font-weight:800;
font-size:22px;
color:#fff;
}
.brand h1{margin:0;font-size:17px}
.brand p{margin:0;font-size:11px;color:#8794ac}

.nav-title{
padding:18px 24px 8px;
font-size:11px;
color:#8794ac;
font-weight:700;
letter-spacing:1px;
}

.nav a{
display:flex;
padding:14px 22px;
text-decoration:none;
color:#a8b4cc;
}

.nav a.active{
background:#3f6fe0;
color:#fff;
border-radius:0 12px 12px 0;
}

.main{overflow:auto}

.top{
height:76px;
background:#151b29;
display:flex;
align-items:center;
padding:0 30px;
border-bottom:1px solid #262f47;
}

.search{
width:450px;
padding:13px;
background:#0e1320;
border:1px solid #262f47;
border-radius:12px;
color:#fff;
}

.user{
margin-left:auto;
display:flex;
align-items:center;
gap:12px;
}

.avatar{
width:46px;
height:46px;
border-radius:50%;
background:linear-gradient(135deg,#5b8cff,#37c281);
display:grid;
place-items:center;
font-weight:700;
color:#fff;
}

.logout{
background:transparent;
border:1px solid #334155;
padding:10px 18px;
color:#fff;
border-radius:10px;
}

.content{
padding:30px;
}

.card-dark{
background:#151b29;
border:1px solid #262f47;
border-radius:18px;
padding:30px;
}

label{
color:#8794ac;
margin-bottom:7px;
font-size:13px;
}

.form-control{
background:#0e1320;
border:1px solid #262f47;
color:#fff;
border-radius:12px;
padding:13px;
}

.form-control:focus{
background:#0e1320;
border-color:#3f6fe0;
color:#fff;
box-shadow:none;
}

.btn-blue{
background:#3f6fe0;
color:#fff;
border:0;
padding:12px 22px;
border-radius:12px;
font-weight:700;
}

.btn-back{
border:1px solid #334155;
padding:12px 22px;
border-radius:12px;
text-decoration:none;
color:#fff;
}

.muted{
color:#8794ac;
}
</style>

<div class="card-dark">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h2>Add Park / Client</h2>
                        <p class="muted mb-0">
                            Register a new customer park
                        </p>
                    </div>

                    <a href="<?php echo e(route('admin.parks')); ?>"
                       class="btn-back">
                        Back
                    </a>

                </div>

                <form method="POST"
                      action="<?php echo e(route('admin.parks.store')); ?>">

                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label>Park / Client Name *</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Wonder World Park"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Contact Person</label>

                        <input type="text"
                               name="contact_person"
                               class="form-control"
                               placeholder="Manager Name">
                    </div>

                    <div class="mb-3">
                        <label>Phone Number</label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="9876543210">
                    </div>

                    <div class="mb-4">
                        <label>Location</label>

                        <input type="text"
                               name="location"
                               class="form-control"
                               placeholder="Kochi, Kerala">
                    </div>

                    <button class="btn-blue">
                        Save Park
                    </button>

                </form>

=======
<?php $__env->startSection('content'); ?>

<style>
body{margin:0;background:#0e1320;color:#e8edf6;overflow:hidden;font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:0!important}

.app{display:grid;grid-template-columns:270px 1fr;height:100vh}
.side{background:#151b29;border-right:1px solid #262f47}
.brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
.logo{
width:48px;
height:48px;
border-radius:14px;
background:linear-gradient(135deg,#5b8cff,#9b6bff);
display:grid;
place-items:center;
font-weight:800;
font-size:22px;
color:#fff;
}
.brand h1{margin:0;font-size:17px}
.brand p{margin:0;font-size:11px;color:#8794ac}

.nav-title{
padding:18px 24px 8px;
font-size:11px;
color:#8794ac;
font-weight:700;
letter-spacing:1px;
}

.nav a{
display:flex;
padding:14px 22px;
text-decoration:none;
color:#a8b4cc;
}

.nav a.active{
background:#3f6fe0;
color:#fff;
border-radius:0 12px 12px 0;
}

.main{overflow:auto}

.top{
height:76px;
background:#151b29;
display:flex;
align-items:center;
padding:0 30px;
border-bottom:1px solid #262f47;
}

.search{
width:450px;
padding:13px;
background:#0e1320;
border:1px solid #262f47;
border-radius:12px;
color:#fff;
}

.user{
margin-left:auto;
display:flex;
align-items:center;
gap:12px;
}

.avatar{
width:46px;
height:46px;
border-radius:50%;
background:linear-gradient(135deg,#5b8cff,#37c281);
display:grid;
place-items:center;
font-weight:700;
color:#fff;
}

.logout{
background:transparent;
border:1px solid #334155;
padding:10px 18px;
color:#fff;
border-radius:10px;
}

.content{
padding:30px;
}

.card-dark{
background:#151b29;
border:1px solid #262f47;
border-radius:18px;
padding:30px;
}

label{
color:#8794ac;
margin-bottom:7px;
font-size:13px;
}

.form-control{
background:#0e1320;
border:1px solid #262f47;
color:#fff;
border-radius:12px;
padding:13px;
}

.form-control:focus{
background:#0e1320;
border-color:#3f6fe0;
color:#fff;
box-shadow:none;
}

.btn-blue{
background:#3f6fe0;
color:#fff;
border:0;
padding:12px 22px;
border-radius:12px;
font-weight:700;
}

.btn-back{
border:1px solid #334155;
padding:12px 22px;
border-radius:12px;
text-decoration:none;
color:#fff;
}

.muted{
color:#8794ac;
}
</style>

<div class="card-dark">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h2>Add Park / Client</h2>
                        <p class="muted mb-0">
                            Register a new customer park
                        </p>
                    </div>

                    <a href="<?php echo e(route('admin.parks')); ?>"
                       class="btn-back">
                        Back
                    </a>

                </div>

                <form method="POST"
                      action="<?php echo e(route('admin.parks.store')); ?>">

                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label>Park / Client Name *</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Wonder World Park"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Contact Person</label>

                        <input type="text"
                               name="contact_person"
                               class="form-control"
                               placeholder="Manager Name">
                    </div>

                    <div class="mb-3">
                        <label>Phone Number</label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="9876543210">
                    </div>

                    <div class="mb-4">
                        <label>Location</label>

                        <input type="text"
                               name="location"
                               class="form-control"
                               placeholder="Kochi, Kerala">
                    </div>

                    <button class="btn-blue">
                        Save Park
                    </button>

                </form>

>>>>>>> 353115acd2f12e033eed9c0c3cba0304f0b467b5
            </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\parks\create.blade.php ENDPATH**/ ?>