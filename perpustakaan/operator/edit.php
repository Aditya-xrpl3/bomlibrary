<?php
include '../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID buku tidak valid.");
}

$bookId = $_GET['id'];

// Ambil data buku dari database
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$bookId]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Buku tidak ditemukan.");
}

// Proses pengeditan buku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $synopsis = $_POST['synopsis'];

    // Handle file upload
    $coverImage = $_FILES['cover_image']['name'];
    if ($coverImage) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($coverImage);

        // Check if the directory exists and is writable
        if (is_dir($uploadDir)) {
            if (is_writable($uploadDir)) {
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadFile)) {
                    echo "<p>Cover image successfully uploaded to $uploadFile.</p>";
                } else {
                    echo "<p>Failed to upload cover image to $uploadFile.</p>";
                }
            } else {
                echo "<p>Upload directory ($uploadDir) is not writable.</p>";
            }
        } else {
            echo "<p>Upload directory ($uploadDir) does not exist.</p>";
        }
    }

    // Update buku dalam database
    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, year = ?, synopsis = ?, cover_image = ? WHERE id = ?");
    $stmt->execute([$title, $author, $year, $synopsis, $coverImage, $bookId]);

    echo "<p>Buku berhasil diperbarui!</p>";
    echo '<a href="index.php">Kembali ke Daftar Buku</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../css/edit.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Edit Buku</h1>
        </div>
    </header>
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <label for="title">Judul Buku:</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($book['title']) ?>" required>
            
            <label for="author">Pengarang:</label>
            <input type="text" name="author" id="author" value="<?= htmlspecialchars($book['author']) ?>" required>
            
            <label for="year">Tahun Terbit:</label>
            <input type="number" name="year" id="year" value="<?= htmlspecialchars($book['year']) ?>" required>
            
            <label for="synopsis">Sinopsis:</label>
            <textarea name="synopsis" id="synopsis" required><?= htmlspecialchars($book['synopsis']) ?></textarea>
            
            <label for="cover_image">Cover Image:</label>
            <input type="file" name="cover_image" id="cover_image">
            
            <button type="submit">Perbarui Buku</button>
        </form>
        <a href="index.php">Kembali ke Daftar Buku</a>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan</p>
    </footer>
</body>
</html>
