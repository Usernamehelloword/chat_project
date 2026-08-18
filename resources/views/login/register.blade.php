<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Font Awesome -->
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
    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(-45deg,
    #f1d3d3,
    #d98686,
    #e7bcbc,
    #f4dddd);

    background-size:400% 400%;
    animation:bgMove 10s ease infinite;
}

@keyframes bgMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.container{
    position:relative;
    width:900px;
    height:650px;
    animation:fade .8s ease;
}

@keyframes fade{
    from{
        opacity:0;
        transform:translateY(40px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.side-text{
    position:absolute;
    left:15px;
    top:60px;
    color:white;
    font-size:44px;
    font-weight:bold;
    writing-mode:vertical-rl;
    text-orientation:upright;
    letter-spacing:8px;
}

.shadow-box{
    position:absolute;
    width:600px;
    height:420px;
    background:#d8c5c5;
    left:120px;
    top:120px;
    border-radius:25px;
}

.register-box{
    position:absolute;
    width:650px;
    background:#d98686;
    left:145px;
    top:70px;
    border-radius:25px;
    padding:45px;
    box-shadow:0 20px 40px rgba(0,0,0,.2);
    animation:float 4s ease-in-out infinite;
}

@keyframes float{

    0%,100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-10px);
    }

}

.register-box::before{

    content:"";

    position:absolute;

    width:70%;

    height:18px;

    background:#efefef;

    top:0;

    left:50%;

    transform:translateX(-50%);
}

.success{

    color:white;

    text-align:center;

    margin-bottom:20px;

}

.input-group{

    display:flex;

    align-items:center;

    margin-bottom:25px;

}

.icon{

    color:white;

    width:30px;

    font-size:22px;

}

.eye{

    color:white;

    cursor:pointer;

    margin-left:10px;

}

input{

    flex:1;

    border:none;

    border-bottom:3px solid white;

    background:transparent;

    outline:none;

    color:white;

    font-size:18px;

    padding:8px;

}

input::placeholder{

    color:white;

}

input:focus{

    box-shadow:0 8px 15px rgba(255,255,255,.25);

}

.register-btn{

    display:block;

    width:180px;

    height:50px;

    margin:35px auto;

    border:none;

    border-radius:30px;

    background:white;

    color:#d98686;

    font-size:18px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

}

.register-btn:hover{

    transform:scale(1.08);

}

.bottom{

    position:absolute;

    bottom:20px;

    width:100%;

    display:flex;

    justify-content:center;

}

.bottom a{

    text-decoration:none;

}

.bottom button{

    width:220px;

    height:50px;

    border:none;

    border-radius:30px;

    background:#d98686;

    color:white;

    font-size:18px;

    cursor:pointer;

    transition:.3s;

}

.bottom button:hover{

    transform:translateY(-5px);

}

@media(max-width:768px){

.container{

    width:95%;
    height:auto;

}

.side-text{

    display:none;

}

.shadow-box{

    display:none;

}

.register-box{

    position:relative;

    left:0;
    top:0;
    width:100%;

}

.bottom{

    position:relative;

    margin-top:20px;

}

}

</style>

</head>

<body>

<div class="container">

    <div class="side-text">
        REGISTER
    </div>

    <div class="shadow-box"></div>

    <div class="register-box">

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('registers') }}" method="POST">

            @csrf

            <div class="input-group">
                <i class="fa-solid fa-user icon"></i>
                <input
                    type="text"
                    name="name"
                    placeholder="Full Name"
                    required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-envelope icon"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required>

                <i class="fa-solid fa-eye eye" id="togglePassword"></i>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock icon"></i>
                <input
                    type="password"
                    id="confirmPassword"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required>

                <i class="fa-solid fa-eye eye" id="toggleConfirm"></i>
            </div>

            <button class="register-btn" type="submit">
                Register
            </button>

        </form>

    </div>

    <div class="bottom">

        <a href="{{ route('logins') }}">
            <button type="button">
                Already have an account?
            </button>
        </a>

    </div>

</div>

<script>

function togglePassword(inputId, iconId){

    const input=document.getElementById(inputId);
    const icon=document.getElementById(iconId);

    icon.addEventListener("click",function(){

        if(input.type==="password"){

            input.type="text";
            icon.classList.replace("fa-eye","fa-eye-slash");

        }else{

            input.type="password";
            icon.classList.replace("fa-eye-slash","fa-eye");

        }

    });

}

togglePassword("password","togglePassword");
togglePassword("confirmPassword","toggleConfirm");

</script>

</body>
</html>