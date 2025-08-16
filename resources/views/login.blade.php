<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            margin: 0px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            vertical-align: middle;
            justify-content: center;
            height: 100vh;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        input {
            padding: 8px;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 0 0 10px 0;
        }

        .form-center {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-center">
            <h2>Login</h2>
            <form id="loginForm" style="display: flex;flex-direction: column; align-items: center;">
                <input type="text" id="username" placeholder="Username" required>
                <input type="password" id="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let username = document.getElementById('username').value.trim();
            let password = document.getElementById('password').value.trim();

            if (username && password) {
                let users = JSON.parse(localStorage.getItem('users')) || [];

                let existingUser = users.find(u => u.username === username);

                if (existingUser) {
                    if (existingUser.password === password) {
                        localStorage.setItem('currentUser', username);
                        window.location.href = '/todolist';
                    } else {
                        alert("Incorrect password!");
                    }
                } else {
                    users.push({ username, password, todos: [] });
                    localStorage.setItem('users', JSON.stringify(users));
                    localStorage.setItem('currentUser', username);
                    window.location.href = '/todolist';
                }

            } else {
                alert("Please enter username and password");
            }
        });
    </script>
</body>

</html>