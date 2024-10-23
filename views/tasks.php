<?php
session_start();
require_once '../config/db.php'; // Include your DB connection here
require_once '../controllers/taskController.php';

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

$taskController = new TaskController($connection);
$tasks = $taskController->getTasks($_SESSION['user_id']);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        if ($taskController->createTask($_SESSION['user_id'], $_POST['title'], $_POST['description'])) {
            $message = 'Task created successfully!';
        } else {
            $error = 'Failed to create task.';
        }
        header('Location: ../views/tasks.php'); // Redirect after creating
        exit();
    }

    if (isset($_POST['update'])) {
        // Update the task
        if ($taskController->updateTask($_POST['id'], $_POST['title'], $_POST['description'])) {
            $message = 'Task updated successfully!';
        } else {
            $error = 'Failed to update task.';
        }
        header('Location: ../views/tasks.php');
        exit();
    }

    if (isset($_POST['updateStatus'])) {
        // Update the task status
        $taskController->updateTaskStatus($_POST['id'], $_POST['status']);
        header('Location: ../views/tasks.php');
        exit();
    }

    if (isset($_POST['delete'])) {
        // Delete the task
        $taskController->deleteTask($_POST['id']);
        header('Location: ../views/tasks.php');
        exit();
    }
}
?>

<?php ob_start(); // Start output buffering ?>
<div class="flex flex-col md:flex-row items-start bg-gray-100 min-h-screen py-10">
    <div class="md:w-1/3 w-full p-6 bg-white rounded-lg shadow-lg mb-6 md:mb-0">
        <h2 class="text-3xl font-bold mb-6">Add Task</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Task Title" required
                class="w-full border border-gray-300 rounded-md p-2 mb-4 focus:outline-none focus:ring focus:ring-blue-500">
            <textarea name="description" placeholder="Task Description" required
                class="w-full border border-gray-300 rounded-md p-2 mb-4 focus:outline-none focus:ring focus:ring-blue-500"></textarea>
            <button type="submit" name="create"
                class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">Add Task</button>
        </form>
        <?php if (isset($message)): ?>
            <p class="text-green-600 mt-2"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mt-2"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>

    <div class="md:w-2/3 w-full p-6 overflow-auto bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold mb-6">Your Tasks</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Task Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Created At</th>
                        <!-- New column added -->
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr class="border-b border-gray-300">
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($task['title']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?php echo htmlspecialchars($task['description']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <span
                                    class="font-semibold <?php echo $task['status'] === 'Complete' ? 'text-green-600' : ($task['status'] === 'Partial' ? 'text-yellow-600' : 'text-red-600'); ?>">
                                    <?php echo htmlspecialchars($task['status']); ?>
                                </span>
                                <form method="POST" class="flex items-center">
                                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                    <select name="status"
                                        class="border border-gray-300 rounded-md p-1 mr-2 focus:outline-none focus:ring focus:ring-blue-500">
                                        <option value="Pending" <?php echo $task['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Complete" <?php echo $task['status'] === 'Complete' ? 'selected' : ''; ?>>Complete</option>
                                        <option value="Partial" <?php echo $task['status'] === 'Partial' ? 'selected' : ''; ?>>Partial</option>
                                    </select>

                                    <!-- Show the Update Status button only if the status is not Complete -->
                                    <?php if ($task['status'] !== 'Complete'): ?>
                                        <button type="submit" name="updateStatus"
                                            class="bg-blue-500 px-3 py-1 text-white font-bold text-sm rounded hover:bg-blue-600">Update
                                            Status</button>
                                    <?php endif; ?>

                                    <button type="submit" name="delete"
                                        class="bg-red-500 px-3 py-1 text-white text-sm rounded hover:bg-red-600 ml-2">Delete</button>
                                </form>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($task['created_at']))); ?>
                                <!-- Display Created At -->
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <div class="flex flex-col">
                                    <form method="POST" class="mb-2 flex">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="text" name="title"
                                            value="<?php echo htmlspecialchars($task['title']); ?>"
                                            class="border border-gray-300 rounded-md p-1 mb-1 focus:outline-none focus:ring focus:ring-blue-500"
                                            placeholder="Update Title">
                                        <textarea name="description"
                                            class="border border-gray-300 rounded-md p-1 mb-1 focus:outline-none focus:ring focus:ring-blue-500"
                                            placeholder="Update Description"><?php echo htmlspecialchars($task['description']); ?></textarea>
                                        <?php if ($task['status'] !== 'Complete'): ?>
                                            <button type="submit" name="update"
                                                class="bg-blue-500 text-white font-bold py-1 rounded hover:bg-blue-600">Update
                                                Task</button>
                                        <?php endif; ?>


                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Get content from the output buffer
include '../views/layout.php'; // Include the layout file
?>

