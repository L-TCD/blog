<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
$faker = Faker\Factory::create('fr_FR');

$pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8","root","root", [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE comment');

$usersId = [];
$postsId = [];

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET email='{$faker->safeEmail()}', username='admin', password='$password', admin='1'");
$usersId[] = $pdo->lastInsertId();

$password2 = password_hash('visitor', PASSWORD_BCRYPT);
for ($i = 0; $i < 9; $i++){
	$pdo->exec("INSERT INTO user SET email='{$faker->safeEmail()}', username='{$faker->userName()}', password='$password2', admin='0'");
	$usersId[] = $pdo->lastInsertId();
}

for ($i = 0; $i < 50; $i++){
	$pdo->exec("INSERT INTO post SET title='{$faker->sentence()}', slug='{$faker->slug()}', content='{$faker->paragraphs(rand(3,15), true)}', description='{$faker->text(rand(10,30))}', created_at='{$faker->date('Y-m-d')} {$faker->time('H:i:s')}', user_id='1'");
	$postsId[] = $pdo->lastInsertId();
}

foreach($postsId as $postId){
	for ($i = 0; $i < rand(0, 20); $i++){
		$pdo->exec("INSERT INTO comment SET content='{$faker->paragraphs(rand(1,2), true)}, true)}', created_at='{$faker->date('Y-m-d')} {$faker->time('H:i:s')}', valid='1', user_id='{$faker->randomElement($usersId)}', post_id='$postId'");
	}
}