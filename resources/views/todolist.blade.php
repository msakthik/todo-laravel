<!DOCTYPE html>
<html>

<head>
    <title>Todo List</title>
    <style>
        .todo-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 10px;
            font-style: italic;
        }

        h3 {
            margin: 0;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 5px;
            background: #f1f1f1;
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        }
    </style>
</head>

<body>
    <div class="todo-banner">
        <h3>Login by <span id="loggedUser"></span></h3>
        <button onclick="logout()">Logout</button>
    </div>

    <form id="addtodo" style="display: flex; justify-content: center; margin: 20px;">
        <input type="text" id="taskInput" placeholder="Enter task">
        <button type="submit">Add</button>
    </form>

    <ul id="taskList"></ul>

    <script>
        let currentUser = localStorage.getItem('currentUser');
        if (!currentUser) {
            window.location.href = '/';
        }

        document.getElementById('loggedUser').textContent = currentUser;

        function getUsers() {
            return JSON.parse(localStorage.getItem('users')) || [];
        }

        function saveUsers(users) {
            localStorage.setItem('users', JSON.stringify(users));
        }

        function loadTasks() {
            let users = getUsers();
            let user = users.find(u => u.username === currentUser);
            let list = document.getElementById('taskList');
            list.innerHTML = '';
            if (user && user.todos) {
                user.todos.forEach((task, index) => {
                    let li = document.createElement('li');
                    li.innerHTML = `
                        <span>${task}</span>
                        <div>
                            <button onclick="deleteTask(${index})">Delete</button>
                        </div>
                    `;
                    list.appendChild(li);
                });
            }
        }

        document.getElementById('addtodo').addEventListener('submit', function (e) {
            e.preventDefault();
            let taskText = document.getElementById('taskInput').value.trim();
            if (!taskText) return;

            let users = getUsers();
            let user = users.find(u => u.username === currentUser);
            console.log('user: ', user);
            if (user) {
                user.todos.push(taskText);
                saveUsers(users);
                console.log('users: ', users);
                document.getElementById('taskInput').value = '';
                loadTasks();
            }
        })

        function deleteTask(index) {
            let users = getUsers();
            let user = users.find(u => u.username === currentUser);
            if (user) {
                user.todos.splice(index, 1);
                saveUsers(users);
                loadTasks();
            }
        }

        function logout() {
            localStorage.removeItem('currentUser');
            window.location.href = '/';
        }

        loadTasks();
    </script>
</body>

</html>