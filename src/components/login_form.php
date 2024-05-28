<?php
    echo "
        <div class='rounded-2 border border-1 p-3 d-flex flex-column gap-2'>
            <span class='text-center'>DASHBOARD</span>
            <form action='./src/user_login.php' method='post' class='d-flex flex-column gap-2 mb-0'>
                <div class='input-group input-group-sm mb-1'>
                    <span class='input-group-text' id='inputGroup-sizing-sm'><i class='bi bi-person'></i></span>
                    <input type='text' name='username' class='form-control' aria-label='Username' aria-describedby='inputGroup-sizing-sm' placeholder='Username'>
                </div>
                <div class='input-group input-group-sm mb-2'>
                    <span class='input-group-text' id='inputGroup-sizing-sm'><i class='bi bi-key'></i></span>
                    <input type='password' name='password' class='form-control' aria-label='Password' aria-describedby='inputGroup-sizing-sm' placeholder='Password'>
                </div>
                <button type='submit' class='btn btn-primary w-100'>Login</button>
            </form>
        </div>
    ";
?>