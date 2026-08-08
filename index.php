<?php

$root = '/home/adsj3978/public_html/journal.adsii.or.id';
$source = $root . '/index.html';

if (!is_file($source)) {
    die('index.html tidak ditemukan.');
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    if (!$item->isDir()) {
        continue;
    }

    $destination = $item->getPathname() . '/index.html';

    // Jangan menimpa index.html yang sudah ada
    if (is_file($destination)) {
        echo "Sudah ada: " . htmlspecialchars($destination) . "<br>";
        continue;
    }

    if (copy($source, $destination)) {
        echo "Berhasil: " . htmlspecialchars($destination) . "<br>";
    } else {
        echo "Gagal: " . htmlspecialchars($destination) . "<br>";
    }
}

echo '<br><b>Selesai.</b>';
