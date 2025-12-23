<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        :root{
            --card-bg: #ffffff;
            --muted: #6b7280;
            --accent: #667eea;
        }

        html,body{height:100%;}
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg,#eef2ff 0%, #f8fafc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            margin: 0;
        }

        .card {
            background: var(--card-bg);
            padding: 20px 22px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(17,24,39,0.06);
            max-width: 680px;
            width: 100%;
            box-sizing: border-box;
        }

        .profile-header{
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .avatar{
            width:72px;
            height:72px;
            min-width:72px;
            border-radius:50%;
            background:var(--accent);
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:28px;
            box-shadow: 0 6px 18px rgba(102,126,234,0.18);
        }

        .profile-info{flex:1}
        .name{font-size:20px;margin:0;color:#0f172a;font-weight:700}
        .email{margin:6px 0 0;color:var(--muted);font-size:14px}

        .divider{height:1px;background:#eef2f7;margin:18px 0;border-radius:2px}

        .fields{display:flex;gap:28px;flex-wrap:wrap}
        .field{flex:1;min-width:180px}
        .label{font-size:12px;color:var(--muted);font-weight:600;margin-bottom:6px}
        .value{font-size:16px;color:#111827;word-break:break-word}

        @media (max-width:520px){
            .profile-header{gap:12px}
            .avatar{width:60px;height:60px;min-width:60px;font-size:22px}
            .card{padding:16px}
        }
    </style>
</head>
<body>
    <div class="card" role="region" aria-label="User profile">
        @php
            // Resolve the profile user safely: prefer a passed $user, fallback to the authenticated user
            $profileUser = isset($user) ? $user : auth()->user();

            $displayName = optional($profileUser)->name ?? '—';
            $displayEmail = optional($profileUser)->email ?? '—';

            $initial = '';
            if(optional($profileUser)->name){
                $initial = strtoupper(mb_substr(optional($profileUser)->name, 0, 1));
            }
        @endphp

        <header class="profile-header">
            <div class="avatar" aria-hidden="true">{{ $initial }}</div>
            <div class="profile-info">
                <h1 class="name">{{ $displayName }}</h1>
                <p class="email">{{ $displayEmail }}</p>
            </div>
        </header>

        <div class="divider" aria-hidden="true"></div>

        <section class="fields" aria-label="contact information">
            <div class="field">
                <div class="label">Name</div>
                <div class="value">{{ $displayName }}</div>
            </div>

            <div class="field">
                <div class="label">Email</div>
                <div class="value">{{ $displayEmail }}</div>
            </div>
        </section>
    </div>
</body>
</html>