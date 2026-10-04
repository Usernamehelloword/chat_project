<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profile</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}


body{

    min-height:100vh;

    background:
    linear-gradient(-45deg,
    #f1d3d3,
    #d98686,
    #e7bcbc,
    #f4dddd);

    background-size:400% 400%;

    animation:bgMove 10s infinite ease;

}



@keyframes bgMove{

    0%{
        background-position:0% 50%;
    }

    50%{
        background-position:100% 50%;
    }

    100%{
        background-position:0% 50%;
    }

}



.container{

    width:90%;
    max-width:1200px;

    margin:50px auto;

    animation:show .8s ease;

}



@keyframes show{

    from{

        opacity:0;
        transform:translateY(40px);

    }


    to{

        opacity:1;
        transform:translateY(0);

    }

}




.row{

    display:flex;

    gap:30px;

}




.col-md-4{

    width:35%;

}



.col-md-8{

    width:65%;

}




.card{

    background:#d98686;

    border-radius:25px;

    overflow:hidden;

    box-shadow:
    0 20px 40px rgba(0,0,0,.2);

    transition:.3s;

}



.card:hover{

    transform:translateY(-8px);

}





.card-header{

    background:#c76f6f;

    color:white;

    text-align:center;

    padding:20px;

    font-size:22px;

    font-weight:bold;

}





.card-body{

    padding:30px;

}



.text-center{

    text-align:center;

}




.rounded-circle{

    width:150px;

    height:150px;

    border-radius:50%;

    object-fit:cover;

    border:5px solid white;

    box-shadow:
    0 10px 25px rgba(0,0,0,.25);

    transition:.3s;

}

.profile-placeholder-circle{

    width:150px;

    height:150px;

    margin:0 auto;

    border-radius:50%;

    background:rgba(255,255,255,0.25);

    border:5px solid white;

    box-shadow:0 10px 25px rgba(0,0,0,.25);

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

    font-size:60px;

    transition:.3s;

}

.profile-placeholder-circle:hover,
.rounded-circle:hover{

    transform:scale(1.05);

}





h3{

    color:white;

    margin-top:20px;

    font-size:28px;

}



.text-muted{

    color:white;

    opacity:.8;

}




hr{

    border:none;

    height:1px;

    background:white;

    opacity:.5;

    margin:25px 0;

}



p{

    color:white;

    line-height:1.8;

}



.form-label{

    color:white;

    font-weight:bold;

    display:block;

    margin-bottom:8px;

}



.form-control{

    width:100%;

    padding:14px;

    border:none;

    border-radius:12px;

    font-size:16px;

    margin-bottom:18px;

    transition:.3s;

}



.form-control:focus{

    outline:none;

    transform:scale(1.02);

    box-shadow:
    0 0 15px rgba(255,255,255,.5);

}




.form-check{

    color:white;

    margin:10px 0;

}



.form-check-input{

    margin-right:10px;

}





.btn{

    width:100%;

    padding:14px;

    border:none;

    border-radius:30px;

    cursor:pointer;

    font-size:17px;

    transition:.3s;

    text-decoration:none;

    display:block;

    text-align:center;

}



.btn-success{

    background:white;

    color:#d98686;

    font-weight:bold;

}



.btn-success:hover{

    transform:translateY(-5px);

    box-shadow:
    0 15px 25px rgba(0,0,0,.2);

}



.btn-secondary{

    margin-top:10px;

    background:#b86b6b;

    color:white;

}



.btn-secondary:hover{

    transform:translateY(-5px);

}

@media (max-width: 820px) {
    .container {
        width: 95%;
        margin: 20px auto 40px;
    }

    .row {
        flex-direction: column;
        gap: 20px;
    }

    .col-md-4,
    .col-md-8 {
        width: 100%;
    }

    .card {
        border-radius: 20px;
    }

    .card-body {
        padding: 22px 18px;
    }

    .card-header {
        padding: 16px;
        font-size: 19px;
    }

    .rounded-circle,
    .profile-placeholder-circle {
        width: 130px;
        height: 130px;
        font-size: 50px;
        border-width: 4px;
    }
}

</style>

</head>


<body>


<div class="container">


<div class="row">


<!-- Profile Display -->

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body text-center">


@php
    $pageProfileImg = $user->profile?->image ?? null;
    $pageProfileImgUrl = $pageProfileImg ? (str_starts_with($pageProfileImg, 'http') ? $pageProfileImg : '/storage/' . ltrim($pageProfileImg, '/')) : null;
@endphp

<div class="avatar-wrapper mb-3" style="display:flex; justify-content:center;">
    <img src="{{ $pageProfileImgUrl ?? '' }}"
         id="profilePreviewImg"
         class="rounded-circle"
         alt="Profile Image"
         style="{{ empty($pageProfileImgUrl) ? 'display:none;' : 'display:block;' }}"
         onerror="this.style.display='none'; document.getElementById('profileDefaultPlaceholder').style.display='flex';">

    <div id="profileDefaultPlaceholder"
         class="profile-placeholder-circle"
         style="{{ !empty($pageProfileImgUrl) ? 'display:none;' : 'display:flex;' }}">
        <i class="fa-solid fa-user"></i>
    </div>
</div>



<h3>
    {{ $user->profile?->name ?? 'No Name' }}
</h3>


<p class="text-muted">
    {{ $user->profile?->email ?? 'No Email' }}
</p>


<hr>


<p>
    <strong>Gender:</strong>

    @if($user->profile?->gender == 'M')
        Male
    @elseif($user->profile?->gender == 'F')
        Female
    @else
        Not Set
    @endif

</p>


<p>
    <strong>Description:</strong>
    <br>

    {{ $user->profile?->description ?? 'No Description' }}

</p>


</div>

</div>

</div>




<!-- Update Form -->

<div class="col-md-8">


<div class="card shadow border-0">


<div class="card-header bg-primary text-white">

<h4>
    Update Profile
</h4>

</div>




<div class="card-body">

@if(session('success'))
    <div style="background: rgba(255,255,255,0.95); color: #2e7d32; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-weight: bold; text-align: center;">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: rgba(255,255,255,0.95); color: #c62828; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('profile.update',$user->id) }}"
      method="POST"
      enctype="multipart/form-data">


@csrf

@method('PUT')



<!-- Name -->

<div class="mb-3">

<label class="form-label">
    Name
</label>


<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$user->profile?->name) }}">


</div>





<!-- Image -->

<div class="mb-3">

<label class="form-label">
    Profile Image
</label>


<input type="file"
       name="image"
       id="imageInput"
       accept="image/*"
       onchange="previewProfileImage(this)"
       class="form-control">


</div>





<!-- Gender -->

<div class="mb-3">


<label class="form-label">
    Gender
</label>


<br>


<div class="form-check">

<input class="form-check-input"
       type="radio"
       name="gender"
       value="M"
       id="male"
       {{ old('gender',$user->profile?->gender) == 'M' ? 'checked' : '' }}>


<label class="form-check-label" for="male">
    Male
</label>

</div>



<div class="form-check">


<input class="form-check-input"
       type="radio"
       name="gender"
       value="F"
       id="female"
       {{ old('gender',$user->profile?->gender) == 'F' ? 'checked' : '' }}>


<label class="form-check-label" for="female">
    Female
</label>


</div>


</div>





<!-- Description -->


<div class="mb-3">


<label class="form-label">
    Description
</label>



<textarea name="description"
          class="form-control"
          rows="4">{{ old('description',$user->profile?->description) }}</textarea>


</div>





<button type="submit"
        class="btn btn-success w-100">

Update Profile

</button>
<a href="{{ route('main') }}"
   class="btn btn-secondary w-100 mt-2">
back to main
</a>



</form>



</div>

</div>


</div>



</div>

</div>

<script>
function previewProfileImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('profilePreviewImg');
            const placeholder = document.getElementById('profileDefaultPlaceholder');
            if (img) {
                img.src = e.target.result;
                img.style.display = 'block';
            }
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>