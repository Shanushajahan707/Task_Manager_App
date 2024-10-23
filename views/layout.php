<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Tailwind CSS CDN -->
</head>
<body class="bg-gray-100 text-gray-800">
<nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Task Manager</h1>
        </div>
        <div class="flex items-center space-x-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-gray-600">
                    Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User'; ?>!
                </span>
                <a href="tasks.php" class="text-blue-500 hover:underline">Tasks</a>
                <a href="../controllers/authController.php?action=logout" class="text-red-500 hover:underline">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-blue-500 hover:underline">Login</a>
                <a href="register.php" class="text-blue-500 hover:underline">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>


    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <?php echo $content; ?>
        </div>
    </div>
</body>
</html>
