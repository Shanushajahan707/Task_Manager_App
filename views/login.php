<?php
session_start(); // Start the session
require_once '../config/db.php'; // Ensure this line is at the very top
require_once '../controllers/authController.php';

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ../views/tasks.php'); // Redirect to tasks page if logged in
    exit();
}

$error = ''; // Initialize an error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($connection); // Use the $connection here
    $userId = $authController->login($_POST['username'], $_POST['password']);
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        header('Location: ../views/tasks.php'); // Redirect to tasks page
        exit();
    } else {
        $error = 'Invalid username or password.'; // Set error message
    }
}

// Only include layout if not logged in
ob_start(); // Start output buffering
?>
<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">Login</button>
        </form>
        <?php if (!empty($error)): ?>
            <p class="text-red-500 text-center mt-4"><?php echo htmlspecialchars($error); ?></p> <!-- Display error message -->
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean(); // Get content from the output buffer
include '../views/layout.php'; // Include the layout file
?>