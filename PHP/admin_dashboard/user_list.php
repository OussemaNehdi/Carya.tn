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
                include '../connect.php';

                // Fetch users from the database
                $sql = "SELECT * FROM users";
                $stmt = $pdo->query($sql);
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['firstName']}</td>";
                    echo "<td>{$user['lastName']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['creation_date']}</td>";
                    echo "<td>{$user['role']}</td>";

                    // Display appropriate action based on user's role
                    echo "<td>";
                    if ($user['role'] == 'banned') {
                        echo "<a href=\"requests/unban_user.php?id={$user['id']}\">Unban</a>";
                    } else if ($user['role'] == 'admin') {
                        echo "Admin";
                    } else {
                        echo "<a href=\"requests/ban_user.php?id={$user['id']}\">Ban</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>
