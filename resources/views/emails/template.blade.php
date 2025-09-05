<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email</title>
</head>
<body style="display: flex; justify-content: center !important; align-items: center; background-color: #f5f5f5; font-family: Arial, sans-serif; margin: 0; padding: 20px; border-radius: 40px;">
    <div style="background-color: #ffffff; padding: 30px 40px; border-radius: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 500px; width: 100%; text-align: center;">
        
        <!-- <img src="https://brico2000.it/logo_piccolo.png" height="50" alt="Logo"> -->

        @yield('content')
        
        <div style="height: 1px; width:100%; background-color: #888888; margin-top:20px; margin-bottom: 20px"></div>

        <!-- <div style="margin-bottom: 15px;">
            <a href="https://www.facebook.com/people/Brico-Duemila-Faro/pfbid09fkytyJGF27g4gnxZM4dQYtaUCmvcsH2xqHBTqwrQdiuuyx3ztT64wdVZkDmGpRUl" target="_blank" style="margin: 0 8px; text-decoration: none;">
                <img src="https://cdn-icons-png.flaticon.com/512/2175/2175193.png" width="24" alt="Facebook" />
            </a>

            <a href="https://www.instagram.com/brico2000_il_faro/" target="_blank" style="margin: 0 8px; text-decoration: none;">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384015.png" width="24" alt="Instagram" />
            </a>
        </div> -->

        <p style="color: #888888; font-size: 14px; margin-bottom: 5px;">
            Questa email è stata generata automaticamente da <strong>Agent Core</strong>.
        </p>

        <p style="color: #888888; font-size: 12px; margin: 0;">
            &copy; {{ date('Y') }} Agent Core - Tutti i diritti riservati.
        </p>
    </div>
</body>
</html>