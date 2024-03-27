<section>
    <h2>List of Users</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Created</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch users from the database
            $sql = "SELECT * FROM users";
            $users = mysqli_query($conn, $sql);
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id']}</td>";
                echo "<td>{$user['firstName']}</td>";
                echo "<td>{$user['lastName']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>{$user['creation_date']}</td>";
                echo "<td>{$user['role']}</td>";
                // Display appropriate action based on user's role
                if ($user['role'] == 'banned') {
                    echo "<td><a href=\"requests/unban_user.php?id={$user['id']}\">Unban</a></td>";
                } 
                else if ($user['role'] == 'admin') {
                    echo "<td>Admin</td>";
                }
                else {
                    echo "<td><a href=\"requests/ban_user.php?id={$user['id']}\">Ban</a></td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>
