<?php
session_start();

include 'dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'notes';

$pdo = connectDB();

if ($pdo === null) {
    echo "Failed to connect to the database.";
    exit();
}

try {
    $sql = "SELECT * FROM notetable WHERE user_id = :user_id";
    if ($statusFilter === 'favorites') {
        $sql .= " AND note_status = 'Favorites'";
    } elseif ($statusFilter === 'archives') {
        $sql .= " AND note_status = 'Deleted'";
    } elseif ($statusFilter === 'notes') {
        $sql .= " AND note_status = 'Added'";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Notehub</title>
    <link rel="stylesheet" href="Css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="whole-container">
        <div class="main-content">
            <div class="sidebar">
                <div class="menu">
                    <div class="header">
                        <a href="dashboard.php" class="logoo">Note<span class="Orange">hub</span></a>        
                    </div>
                    <div class="togglebar">
                        <a href="dashboard.php?status=notes" class="buton"><i class='bx bxs-notepad'></i>Notes</a>
                        <a href="dashboard.php?status=favorites" class="buton" onclick="changeFilter('Favorite')"><i class='bx bxs-heart'></i>Favorites</a>
                        <a href="dashboard.php?status=archives" class="buton" onclick="changeFilter('Archive')"><i class='bx bxs-archive'></i>Archives</a>
                    </div>
                </div>
                <div class="logout">
                    <div class="profile-picture">
                        <img src="Image/Bg.avif" alt="" id="profile">
                    </div>
                    <div class="options" id="options">
                        <a href="Account.php" class="option"><i class='bx bxs-user-account'></i>Account</a>
                        <a href="logout.php" class="option"><i class='bx bxs-log-out'></i>Logout</a>
                    </div>
                </div>
            </div>
            <div class="notes-container">
                <h1><?php echo ucfirst($statusFilter); ?></h1>
                <div class="container">
                    <div class="addnote" title="Create Note" id="addNoteButton">
                        <span class="addCon"><i class='bx bx-plus'></i>Add new note</span>
                    </div>
                    <div class="overlay" id="overlay"></div>
                    <div class="modal-box" id="modalBox">
                        <form id="myForm" class="modal-form" action="addnote.php" method="POST" onsubmit="return validateNote()">
                            <div class="navigate">
                                <a href="dashboard.php"><i class='bx bx-arrow-back'></i></a>
                                <div class="nav2">
                                    <button type="submit" class="check"><i class='bx bx-save' title="Save note"></i></button>
                                </div>
                            </div>
                            <input type="text" name="formTitle" id="formTitle" placeholder="Title">
                            <textarea id="description" name="description" rows="10" cols="100" placeholder="Start typing..."></textarea><br><br>
                        </form>
                    </div>
                    <div id="whitespacePrompt" class="prompt"style="display:none;">
                    </div>
                    <?php foreach ($notes as $note): ?>
                        <div class="listnote">
                            <div class="title" onclick="showEditOverlay(<?php echo $note['note_id']; ?>)">
                                <p><?php echo $note['note_title']; ?></p>
                            </div>
                            <div class="description" onclick="showEditOverlay(<?php echo $note['note_id']; ?>)">
                                <p><?php echo $note['note_desc']; ?></p>
                            </div>
                            <div class="stat">
                                <div class="date"><?php echo $note['note_date']; ?></div>
                                <div class="sett" id="settings">
                                    <div class="opt">
                                        <div class="fav">
                                            <?php 
                                            $heartClass = ($note['note_status'] === 'Favorites') ? 'bx bxs-heart red-heart' : 'bx bxs-heart'; 
                                            ?>
                                            <i class='<?php echo $heartClass; ?>' title="Add to Favorites" onclick="showPrompt(<?php echo $note['note_id']; ?>)"></i>
                                        </div>
                                        <div id="promptOverlay" class="overlay">
                                            <div class="prompt">
                                                <p>Are you sure you want to add this note to favorites?</p>
                                                <button onclick="toggleHeartAndStatus(<?php echo $note['note_id']; ?>, true)">Yes</button>
                                                <button onclick="hidePrompt()" class="Noans">No</button>
                                            </div>
                                        </div>
                                        <div class="setts">
                                            <i class='bx bx-dots-horizontal-rounded' title="Settings" id="setts"></i>
                                        </div>
                                    </div>
                                    <div class="options-menu" id="menus">
                                        <div class="mens">
                                            <button onclick="showEditOverlay(<?php echo $note['note_id']; ?>)"><i class='bx bx-edit-alt' ></i>Edit</button>
                                            <form action="deletenote.php" method="post">
                                                <input type="hidden" name="note_id" value="<?php echo $note['note_id']; ?>">
                                                <button type="submit"><i class='bx bx-trash'></i>Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>  
            </div>
        </div>
    </div>

    <div class="overlay" id="editOverlay"></div>
    <div class="modal-box" id="editModalBox">
        <form id="editForm" class="modal-form" action="editnote.php" method="POST" onsubmit="return validateNote()">
            <div class="navigate">
                <a href="dashboard.php"><i class='bx bx-arrow-back'></i></a>
                <div class="nav2">
                    <button type="submit" class="check"><i class='bx bx-save' title="Save note"></i></button>
                </div>
            </div>
            <input type="hidden" name="note_id" id="editNoteId" value="">
            <input type="text" name="editFormTitle" id="editFormTitle" placeholder="Title">
            <textarea id="editDescription" name="editDescription" rows="10" cols="100" placeholder="Start typing..."></textarea><br><br>
        </form>
        <div id="removePromptOverlay" class="overlay" style="display: none;">
        <div class="prompt">
            <p>Do you want to remove this note from Favorites?</p>
            <button onclick="confirmRemoveFromFavorites()">Yes</button>
            <button onclick="hideRemoveFromFavoritesPrompt()" class="Noans">No</button>
        </div>
    </div>
    </div>

    <script src="Jsscript/dashboard.js"></script>
</body>
</html>