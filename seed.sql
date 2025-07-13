USE chat_web;

INSERT INTO roles (id, label) VALUES
(1, 'Admin'),
(2, 'Member');

INSERT INTO users (id, role_id, pseudo, login, password, email) VALUES
(1, 1, 'Xavier', 'Xavier', '$2y$10$bfnrHwsbPcrKWGNwdOdUTeomWN/q0O530wiADKP7oKLg410wrlQAK', 'xavier@gmail.com'),
(2, 2, 'Nathan', 'Nathan', '$2y$10$TK3VI9.QTK6xJNzQtw2cwe4nH4ivb1O0SMLuJBVm0zT7VhEc1Kg1q', 'nathan@gmail.com'),
(3, 2, 'Adam', 'Adam', '$2y$10$VqcnJFjqWyBorMy2gEjmP.r.YcdMaHtXJBJVkSCG5hnhWwZUk5aS6', 'adam@gmail.com');

INSERT INTO rooms (id, owner_id, name, is_visible, is_private, is_archived, topic) VALUES
(1, 1, 'Hello World', 1, 0, 0, 'Interesant'),
(2, 1, 'Room 2', 1, 0, 0,'Hello!');

INSERT INTO messages (id, user_id, room_id, message, timestamp) VALUES
(1, 1, 1, 'Salut', '2025-07-04 14:53:02'),
(2, 1, 1, 'Ca va?', '2025-07-04 15:06:46'),
(3, 2, 1, 'Tres bien et Toi?', '2025-07-04 15:06:51'),
(4, 1, 1, '!!!! :)', '2025-07-04 15:06:55');
