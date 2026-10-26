<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
	case '/':
	case '':
		require __DIR__ . '/../src/Views/landing.php';
		break;
	case '/login':
		require __DIR__ . '/../src/Views/login.php';
		break;
	case '/register':
		require __DIR__ . '/../src/Views/register.php';
		break;
	case '/health':
		require __DIR__ . '/../src/Views/health.php';
		break;
	case '/home':
		require __DIR__ . '/../src/Views/home.php';
		break;
	case '/create':
		require __DIR__ . '/../src/Views/createTask.php';
		break;
	case '/tasks/edit':
		require __DIR__ . '/../src/Views/editTask.php';
		break;
	case '/tasks/toggle':
		require __DIR__ . '/../src/Views/toggleTask.php';
		break;
	case '/tasks/delete':
		require __DIR__ . '/../src/Views/deleteTask.php';
		break;
	case '/logout':
		require __DIR__ . '/../src/Views/logout.php';
		break;
	default:
		http_response_code(404);
		echo "404 Not Found";
		break;
}