<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <style>
        :root{--bg:#eef2ff;--card:#ffffff;--accent:#667eea;--muted:#6b7280}
        *{box-sizing:border-box}
        html,body{height:100%}
        body{
            margin:0;
            font-family: Inter, 'Segoe UI', Roboto, system-ui, -apple-system, 'Helvetica Neue', Arial;
            background: linear-gradient(180deg,#eef2ff 0%, #f8fafc 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
            color:#0f172a
        }

        .login-wrap{
            width:100%;
            max-width:420px;
            background:var(--card);
            border-radius:12px;
            box-shadow:0 12px 40px rgba(15,23,42,0.08);
            padding:28px;
        }

        .brand{
            display:flex;align-items:center;gap:12px;margin-bottom:18px
        }
        .brand .logo{width:44px;height:44px;border-radius:8px;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
        .brand h2{margin:0;font-size:18px}

        .hint{color:var(--muted);font-size:13px;margin-bottom:18px}

        .form-group{margin-bottom:14px}
        label{display:block;font-size:13px;color:var(--muted);margin-bottom:6px;font-weight:600}
        input[type="email"],input[type="password"]{width:100%;padding:12px 14px;border:1px solid #e6edf3;border-radius:8px;font-size:15px;background:#fbfdff}
        input[type="email"]:focus,input[type="password"]:focus{outline:none;box-shadow:0 6px 18px rgba(102,126,234,0.12);border-color:var(--accent)}

        .actions{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:10px}
        .btn{background:var(--accent);color:#fff;padding:10px 16px;border-radius:8px;border:none;font-weight:700;cursor:pointer}
        .btn.secondary{background:#fff;color:var(--accent);border:1px solid var(--accent)}

        .msg{font-size:14px;margin-bottom:12px}

        .footer{margin-top:18px;text-align:center;font-size:13px;color:var(--muted)}

        @media (max-width:420px){.login-wrap{padding:18px}}
    </style>
</head>
<body>
    <main class="login-wrap" role="main" aria-labelledby="loginHeading">
        <div class="brand">
            <div class="logo">A</div>
            <div>
                <h2 id="loginHeading">Welcome back</h2>
                <div class="hint">Sign in to continue to your account</div>
            </div>
        </div>

        @if(session('message'))
            <div class="msg" style="color:#b91c1c">{{ session('message') }}</div>
        @endif

        @if(isset($success))
            <div class="msg" style="color:#065f46">{{ $success }}</div>
        @endif

        <form id="loginForm" action="{{ route('user.login.submit') }}" method="POST" onsubmit="event.preventDefault(); loginUser();">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>

            <div class="actions">
                <button type="submit" class="btn">Sign in</button>
                <a href="{{ route('user.register') }}" class="btn secondary">Register</a>
            </div>
        </form>

        <div class="footer">Forgot your password? Contact support or reset it from your account settings.</div>
    </main>

    <!-- Load axios (local app may provide it; fallback to CDN) -->
    <script>
        if(typeof axios === 'undefined'){
            (function(){
                var s=document.createElement('script');
                s.src='https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
                s.defer=true;document.head.appendChild(s);
            })();
        }

        // Configure axios with Laravel CSRF token once available
        function setAxiosCsrf() {
            var tokenMeta = document.querySelector('meta[name="csrf-token"]');
            if(tokenMeta && typeof axios !== 'undefined'){
                axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
            }
        }

        // Try set it now and again shortly in case axios loaded async
        setAxiosCsrf();
        setTimeout(setAxiosCsrf, 300);

        async function loginUser(){
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            // Basic front-end validation
            if(!email || !password){
                alert('Please provide both email and password.');
                return;
            }

            // Prefer axios if available, otherwise use fetch as fallback
            try{
                if(typeof axios !== 'undefined'){
                    const res = await axios.post("{{ route('user.login.submit') }}", { email: email, password: password });
                    handleResponse(res.data);
                } else {
                    // Fetch fallback
                    const res = await fetch("{{ route('user.login.submit') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ email: email, password: password })
                    });
                    const data = await res.json();
                    handleResponse(data);
                }
            } catch(err){
                // Show friendly message
                var msg = 'Login failed. Please try again.';
                if(err && err.response && err.response.data && err.response.data.message){
                    msg = err.response.data.message;
                } else if(err && err.message){
                    msg = err.message;
                }
                alert(msg);
            }
        }

        function handleResponse(data){
            if(!data) return;
            alert(data.message || 'Response received');
            if(data.status === 'success'){
                window.location.href = '/dashboard';
            }
        }
    </script>
</body>
</html>