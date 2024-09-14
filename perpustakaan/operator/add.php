<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $synopsis = $_POST['synopsis'];

    // Cek apakah ada file gambar yang diupload
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
        $fileName = $_FILES['cover_image']['name'];
        $fileTmp = $_FILES['cover_image']['tmp_name'];
        $fileType = $_FILES['cover_image']['type'];

        // Tentukan direktori penyimpanan
        $uploadDir = '../uploads/';
        $filePath = $uploadDir . $fileName;

        // Pindahkan file yang diupload ke direktori tujuan
        if (move_uploaded_file($fileTmp, $filePath)) {
            // Menyimpan data buku ke database termasuk gambar cover
            $stmt = $pdo->prepare("INSERT INTO books (title, author, year, synopsis, cover_image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $author, $year, $synopsis, $fileName]);

            echo "<p>Buku berhasil ditambahkan!</p>";
            echo '<a href="index.php">Kembali ke Daftar Buku</a>';
            exit;
        } else {
            echo "<p>Gagal mengunggah gambar cover buku.</p>";
        }
    } else {
        echo "<p>Silakan pilih file gambar untuk cover buku.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="../css/add.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Tambah Buku</h1>
            <nav>
                <a href="index.php">Daftar Buku</a>
            </nav>
        </div>
    </header>
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <label for="title">Judul Buku:</label>
            <input type="text" name="title" id="title" required>
            
            <label for="author">Pengarang:</label>
            <input type="text" name="author" id="author" required>
            
            <label for="year">Tahun Terbit:</label>
            <input type="number" name="year" id="year" required>

            <label for="synopsis">Sinopsis:</label>
            <textarea name="synopsis" id="synopsis" rows="5" required></textarea>

            <label for="cover_image">Upload Cover Buku:</label>
            <input type="file" name="cover_image" id="cover_image" accept="image/*" required>

            <button type="submit">Tambah Buku</button>
        </form>
        <a href="index.php">Kembali ke Daftar Buku</a>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan</p>
    </footer>
</body>
</html>
