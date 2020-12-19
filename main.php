<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
class Post {
    // public $id;
    // public $message;
    // public $likes;

    public function show() {
        echo "$this->message ($this->likes)<br />";
    }

}

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
    $pdo->rollback();
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
    ('arigato',15)"

);

$pdo->beginTransaction();
$pdo->query(
    "UPDATE posts SET likes = likes + 1 WHERE id = 1"
);
$pdo->query(
    "UPDATE posts SET likes = likes - 1 WHERE id = 2"
);
$pdo->commit();

// $label = '[Good!]';
// $n = 10;

// $pdo->query("DELETE FROM posts WHERE likes < $n");

// $stmt = $pdo->prepare(
//     "UPDATE
//         posts
//     SET
//         message = CONCAT(:label, message)
//     WHERE
//         likes > :n "
// );
// $stmt->execute(['label'=>$label, 'n'=>$n]);
// echo $stmt->rowCount() . ' records update<br />';

// $search = 't%';

// $stmt = $pdo->prepare(
//     "SELECT * FROM posts WHERE message like :search"
// );
// $stmt->execute(['search' => $search]);

// $message = 'Merci';
// $likes = 8;
// $stmt = $pdo->prepare(
//     "INSERT INTO
//         posts (message, likes)
//     VALUES (:message, :likes)"
// );
// $stmt->bindParam('message', $message, PDO::PARAM_STR);
// $stmt->bindParam('likes', $likes, PDO::PARAM_INT);
// $stmt->execute();
// echo 'ID: ' . $pdo->lastInsertId() . ' inserted<br />';

// $message = 'Gracias';
// $likes = 5;
// $stmt->execute();
// echo 'ID: ' . $pdo->lastInsertId() . ' inserted<br />';

// $message = 'Danke';
// $likes = 11;
// $stmt->execute();
// echo 'ID: ' . $pdo->lastInsertId() . ' inserted<br />';

$stmt = $pdo->query("SELECT * FROM posts");
$posts = $stmt->fetchall(PDO::FETCH_CLASS, 'Post');
foreach($posts as $post) {
    $post->show();
}



?>

    
</body>
</html>

