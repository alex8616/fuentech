<x-guest-layout>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <div id="divTitle">
                    <h1 id="title">Iniciar Sesión</h1>
                </div>

                <form class="login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="email" class="login__input" placeholder="User name / Email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input id="password" type="password" class="login__input" placeholder="Password" name="password" required autocomplete="current-password">
                    </div>
                    <button class="button login__submit">
                        <span class="button__text">Ingresar</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>

                @if ($errors->any())
                    <div class="custom-alert alert-danger" role="alert">
                        <ul class="custom-alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="social-login">
                    <div class="social-icons">
                        <a href="#" class="social-login__icon fab fa-instagram"></a>
                        <a href="#" class="social-login__icon fab fa-facebook"></a>
                        <a href="#" class="social-login__icon fab fa-twitter"></a>
                    </div>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>		
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>       
        </div>
    </div>
</x-guest-layout>

<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;    
        font-family: Raleway, sans-serif;
    }

    body {
        background: linear-gradient(90deg, #182433, #182433);        
    }

    .login__input:focus {
        box-shadow: none;
        box-shadow: white;
    }
    
    #divTitle {
        width: 100%;
        padding: 8px;
        background: rgba(255, 255, 255, 0.8);
        text-align: center;
        color: #FF731D;
        margin-bottom: 20px;
    }

    #title {
        margin: 0;
        font-size: 25px;
        font-weight: bold;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 0 20px;
    }

    .screen {        
        background: linear-gradient(90deg, #FFA41B, #FF731D);        
        position: relative;    
        height: auto;
        width: 90%;
        max-width: 360px;
        box-shadow: 0px 0px 24px #5ed1f2;
        margin: 0 auto;
        overflow: hidden;
        overflow-y: hidden;

    }

    .screen__content {
        padding: 15px;
        z-index: 1;
        position: relative;    
    }

    .screen__background {        
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);    
    }

    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #FFF;    
        top: -50px;
        right: 120px;    
        border-radius: 0 72px 0 0;
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: linear-gradient(500deg, #FF5151, #5ed1f2);    
        top: -172px;
        right: 0;    
        border-radius: 32px;
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(500deg, #5ed1f2, #5ed1f2);
        top: -24px;
        right: 0;    
        border-radius: 32px;
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #5ed1f2;    
        top: 420px;
        right: 50px;    
        border-radius: 60px;
    }

    .login {
        width: 100%;
        padding: 30px;
        padding-top: 65px;
        margin: 0 auto;
    }

    .login__field {
        padding: 20px 0px;    
        position: relative;    
    }

    .login__icon {
        position: absolute;
        top: 30px;
        color: #7875B5;
    }

    .login__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 100%;
        transition: .2s;
    }

    

    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        box-shadow: none;
        box-shadow: white;
        border-bottom-color: #FF731D;
    }

    .login__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #FF731D;
        box-shadow: 0px 2px 2px #FF731D;
        cursor: pointer;
        transition: .2s;
    }

    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #FF731D;
        outline: none;
    }

    .button__text {
        width: 100%;
    }

    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #7875B5;
    }

    .social-login {    
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 0px;
        right: 0px;
        color: #fff;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login__icon {
        padding: 20px 10px;
        color: #fff;
        text-decoration: none;    
        text-shadow: 0px 0px 8px #7875B5;
    }

    .social-login__icon:hover {
        transform: scale(1.5);    
    }

    .custom-alert {
        border-radius: 8px;
        padding: 15px 20px;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        font-family: 'Arial', sans-serif;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
        margin: 15px 0;
    }

    .custom-alert-list {
        list-style-type: none; 
        padding-left: 0;
        margin: 0;
    }

    .custom-alert-list li {
        margin-bottom: 5px;
        line-height: 1.5;
    }

    .custom-alert-list li:last-child {
        margin-bottom: 0;
    }

</style>
