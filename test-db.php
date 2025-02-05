<?php

$host = 'aws-0-ap-southeast-1.pooler.supabase.com';
$port = '5432';
$dbname = 'postgres';
$user = 'postgres.hnnwebyqrjghcagmpecn';
$password = 'B1gtim3rush.';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to PostgreSQL\n";
    
    // Test query
    $stmt = $pdo->query('SELECT current_timestamp');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Current timestamp from database: " . $result['current_timestamp'] . "\n";
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    echo "DSN: " . $dsn . "\n";
}
