<style>
.page-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:20px;
}

.page-head h2{
    margin:0;
    color:#fff;
}

.card-dark{
    padding:28px;
    border:1px solid #262f47;
    border-radius:18px;
    background:#151b29;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:20px;
}

.full-width{
    grid-column:1/-1;
}

.form-label{
    display:block;
    margin-bottom:8px;
    color:#9fb3d9;
    font-size:13px;
    font-weight:700;
}

.form-control,
.form-select{
    width:100%;
    min-height:50px;
    padding:12px 14px;
    border:1px solid #2b3854;
    border-radius:12px;
    color:#fff;
    background:#0e1320;
    outline:none;
}

textarea.form-control{
    min-height:120px;
}

.form-control:focus,
.form-select:focus{
    border-color:#3f6fe0;
    box-shadow:0 0 0 4px rgba(63,111,224,.12);
}

.form-select option{
    background:#151b29;
    color:#fff;
}

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:28px;
    padding-top:22px;
    border-top:1px solid #262f47;
}

.btn-green,
.btn-red,
.btn-back{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:44px;
    padding:10px 18px;
    border:0;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
}

.btn-green{
    background:#37c281;
}

.btn-red{
    background:#ff5a6e;
}

.btn-back{
    color:#dbe4f3;
    border:1px solid #334155;
    background:#1c2436;
}

.alert-danger{
    margin-bottom:20px;
    padding:16px 18px;
    border:1px solid rgba(255,90,110,.35);
    border-radius:14px;
    color:#ffd4da;
    background:rgba(255,90,110,.12);
}

@media(max-width:780px){
    .page-head{
        flex-direction:column;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full-width{
        grid-column:auto;
    }

    .form-actions{
        flex-direction:column-reverse;
    }

    .form-actions > *{
        width:100%;
    }
}
</style>