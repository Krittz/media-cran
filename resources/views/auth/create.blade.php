<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrAn | Sign Up</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- // Icons -->

    <style>
        footer {
            position: fixed;
            bottom: 0;
            height: 40px;
            background: var(--dark-color);
            text-align: center;
            width: 100vw;
            line-height: 40px;
            font-size: 12px;
        }
    </style>
</head>

<body class="auth-body">
    <header>

        <img src="{{ asset('assets/img/c-logo.svg') }}" alt="Logo CrAn">

    </header>
    <main class="auth">
        @if($errors->any())
        @include('logged.components.notify')
        @endif
        <div class="auth-container">
            <div class="container-header">
                <h1 class="auth-title">Create an account</h1>
                <span class="auth-subtitle">Join us and explore new possibilities!</span>
            </div>
            <form action="{{ route('signup') }}" method="POST">
                @csrf
                <div class="form-control">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required autocomplete="none" />
                </div>
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required autocomplete="none" />

                </div>
                <div class="form-control">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required />
                </div>
                <div class="form-control">
                    <button type="submit">SignUp</button>
                </div>

            </form>
            <span class="divider">or</span>
            <div class="container-footer">
                <p>Alredy account? <a href="{{ route('login') }}">Login</a></p>
            </div>

        </div>

    </main>
    <footer>
        <footer>
            <p>&copy; 2024 All rights reserved. CrAn</p>
        </footer>
    </footer>
    <script>
        const inputs = document.querySelectorAll(".form-control input");

        function checkInput() {
            if (this.value !== "") {
                this.parentNode.classList.add("input-active");
            } else {
                this.parentNode.classList.remove("input-active");
            }
        }
        inputs.forEach((input) => {
            input.addEventListener("input", checkInput);
            window.addEventListener("DOMContentLoaded", checkInput.bind(input))
        })
    </script>

</body>

</html>