<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../controllers/authController.php';
    $authController = new AuthController($connection);
    if ($authController->register($_POST['username'], $_POST['password'])) {
        header('Location: ../views/login.php');
        exit();
    } else {
        $error = 'Registration failed.';
    }
}
?>
<?php ob_start(); ?>
<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">Register</button>
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