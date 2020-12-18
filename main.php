<?php

$dsn = 'mysql:host=127.0.0.1;dbname=database1;charset=utf8';
$db_user = 'root';
$db_pass = '';
$driver_options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => FALSE,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $driver_options);
} catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
}

$pdo->query("DROP TABLE IF EXISTS posts");

$pdo->query(
    "CREATE TABLE posts (
        id INT NOT NULL AUTO_INCREMENT,
        message VARCHAR(140),
        likes INT,
        PRIMARY KEY (id)
    )"
);

$pdo->query(
    "INSERT INTO posts (message, likes) VALUES
    ('thanks',12),
    ('thanks',4),
    ('ありがとう',15)"

);

$n = 10;

// $pdo->query("DELETE FROM posts WHERE likes < 10");
$pdo->query("DELETE FROM posts WHERE likes < $n");

$stmt = $pdo->query("SELECT * FROM posts");
$posts = $stmt->fetchall();
foreach($posts as $post) {
    printf(
        '%s (%d)' . PHP_EOL,
        $post['message'],
        $post['likes']
    );
}



?>
