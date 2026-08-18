<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome Icons -->
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
    height:550px;
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

/* Vertical LOGIN */

.side-text{
    position:absolute;
    left:10px;
    top:50px;
    color:white;
    font-size:48px;
    font-weight:bold;
    letter-spacing:8px;
    writing-mode:vertical-rl;
    text-orientation:upright;
}

/* Shadow */

.shadow-box{
    position:absolute;
    width:560px;
    height:290px;
    background:#d6c3c3;
    left:120px;
    top:130px;
    border-radius:25px;
}

/* Login Card */

.login-box{
    position:absolute;
    width:620px;
    background:#d98686;
    left:150px;
    top:60px;
    border-radius:25px;
    padding:50px;
    box-shadow:0 20px 40px rgba(0,0,0,.2);

    animation:float 4s ease-in-out infinite;
}

@keyframes float{

    0%,100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-12px);
    }

}

.login-box::before{

    content:"";

    position:absolute;

    width:70%;

    height:18px;

    background:#efefef;

    top:0;

    left:50%;

    transform:translateX(-50%);
}

/* Inputs */

.input-group{

    display:flex;

    align-items:center;

    margin-bottom:35px;

}

.icon{

    color:white;

    font-size:22px;

    width:30px;

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

    color:white;

    font-size:18px;

    outline:none;

    padding:8px;

}

input::placeholder{

    color:#fff;

}

input:focus{

    box-shadow:0 8px 15px rgba(255,255,255,.3);

}

/* Button */

.login-btn{

    display:block;

    margin:30px auto;

    width:180px;

    height:50px;

    border:none;

    border-radius:30px;

    background:white;

    color:#d98686;

    font-size:18px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

    box-shadow:0 10px 20px rgba(0,0,0,.2);

}

.login-btn:hover{

    transform:scale(1.08);

}

/* Bottom Buttons */

.bottom-btns{

    position:absolute;

    width:100%;

    bottom:20px;

    display:flex;

    justify-content:space-between;

    padding:0 140px;

}

.bottom-btns button{

    width:180px;

    height:50px;

    border:none;

    border-radius:30px;

    background:#d98686;

    color:white;

    font-size:17px;

    cursor:pointer;

    transition:.3s;

}

.bottom-btns button:hover{

    transform:translateY(-5px);

}

a{

    text-decoration:none;

}

/* Responsive */

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

.login-box{

    position:relative;

    left:0;

    top:0;

    width:100%;

}

.bottom-btns{

    position:relative;

    margin-top:20px;

    padding:0;

    justify-content:space-around;

}

}

</style>

</head>

<body>

<div class="container">

    <div class="side-text">
        LOGIN
    </div>

    <div class="shadow-box"></div>

    <div class="login-box">

        <form action="{{ route('login') }}" method="POST">

            @csrf

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

            <button class="login-btn" type="submit">
                Login In
            </button>

        </form>
<p>Mypass123123</p>
    </div>

    <div class="bottom-btns">

        <a href="{{ route('register') }}">
            <button type="button">
                Register
            </button>
        </a>

        <a href="#">
            <button type="button">
                Forgot Password
            </button>
        </a>

    </div>

</div>

<script>

const toggle = document.getElementById("togglePassword");
const password = document.getElementById("password");

toggle.addEventListener("click", function(){

    if(password.type==="password"){

        password.type="text";

        this.classList.replace("fa-eye","fa-eye-slash");

    }else{

        password.type="password";

        this.classList.replace("fa-eye-slash","fa-eye");

    }

});

</script>

</body>
</html>