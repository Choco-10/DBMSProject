<?php 
// session_start();
include("db_connection.php");

$isConsumer = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT isConsumer FROM user WHERE user_id = $user_id";
    $result_user = $conn->query($sql_user);
    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $isConsumer = $user['isConsumer'];
    }
}
?>

<header class="material-header">
    <!-- Logo Section -->
    <div class="logo" onclick="redirectToDashboard()">
        <span class="material-icons">eco</span> <span>GreenLeaf</span>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
    <div class="search-container">
            <input type="text" id="search-query" placeholder="Search for products, categories..." aria-label="Search">
        <button type="button" class="search-button" onclick="submitSearch()"><span class="material-icons">search</span></button>
    </div>
</div>

    <!-- Navigation Buttons -->
    <div class="nav-buttons">
        <button class="material-button" onclick="window.location.href='add_crop.php'">
            <span class="material-icons">shopping_cart</span>
            <span>List Crops</span>
        </button>

        <!-- User Icon with Dropdown -->
        <div class="user-dropdown">
            <?php if (isset($_SESSION['user_id'])): ?>

                <!-- If user is logged in -->
                <div class="user-icon" onclick="toggleDropdown()">
                    <img src="assets/user_icon.png" alt="User Icon" />
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <p class="user-name">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <a href="<?php echo $_SESSION['isConsumer'] ? 'c_profile.php' : 'f_profile.php'; ?>" class="dropdown-link">Profile</a>
                    <a href="logout.php" class="dropdown-link">Logout</a>
                </div>
            <?php else: ?>  
                <button class="material-button" onclick="window.location.href='login.php'">
                    <span class="material-icons">person</span>
                    <span>Login</span>
                </button>

            <?php endif; ?>
        </div>
    </div>
</header>


<script>
function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    dropdownMenu.classList.toggle("show-dropdown");
}

// Close dropdown when clicking outside
document.addEventListener("click", function (event) {
    const dropdownMenu = document.getElementById("dropdown-menu");
    const userIcon = document.querySelector(".user-icon");
    if (dropdownMenu && userIcon && !userIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.remove("show-dropdown");
    }
});

function redirectToDashboard() {
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($isConsumer): ?>
            window.location.href = 'consumer_dashboard.php';
        <?php else: ?>
            window.location.href = 'farmer_dashboard.php';
        <?php endif; ?>
    <?php else: ?>
        window.location.href = 'login.php';
    <?php endif; ?>
}
</script>

<script>
    function submitSearch() {
        const query = document.getElementById('search-query').value;
        if (query) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'farmer_dashboard.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'search_query';
            input.value = query;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<link rel="stylesheet" href="styles.css">