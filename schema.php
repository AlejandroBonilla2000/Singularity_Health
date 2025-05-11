<?php
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
use GraphQL\Error\Error;

require 'config.php';

// Definición de tipos para GraphQL
$userType = new ObjectType([
    'name' => 'User',
    'fields' => [
        'id' => Type::int(),
        'LastName' => Type::string(),
        'Name' => Type::string(),
        'IsMilitar' => Type::boolean(),
        'IsTemporal' => Type::boolean(),
        'TimeCreate' => Type::string(),
        'username' => Type::string(),
        'email' => Type::string(),
        'emailVerified' => Type::boolean(),
        'verificationToken' => Type::string()
    ]
]);

$countryType = new ObjectType([
    'name' => 'Country',
    'fields' => [
        'id' => Type::int(),
        'CountryCode' => Type::string(),
        'CountryName' => Type::string()
    ]
]);

$contactInfoType = new ObjectType([
    'name' => 'ContactInfo',
    'fields' => [
        'id' => Type::int(),
        'UserID' => Type::int(),
        'Address' => Type::string(),
        'CountryID' => Type::int(),
        'City' => Type::string(),
        'Phone' => Type::string(),
        'CelPhone' => Type::string(),
        'EmergencyName' => Type::string(),
        'EmergencyPhone' => Type::string()
    ]
]);

$userDocumentType = new ObjectType([
    'name' => 'UserDocument',
    'fields' => [
        'id' => Type::int(),
        'UserID' => Type::int(),
        'Document' => Type::string(),
        'TypeDocumentID' => Type::int(),
        'PlaceExpedition' => Type::string(),
        'DateExpedition' => Type::string()
    ]
]);

$typeDocumentType = new ObjectType([
    'name' => 'TypeDocument',
    'fields' => [
        'id' => Type::int(),
        'NameTypeDocument' => Type::string()
    ]
]);

// Definición del esquema GraphQL
$schema = new Schema([
    'query' => new ObjectType([
        'name' => 'Query',
        'fields' => [
            'users' => [
                'type' => Type::listOf($userType),
                'resolve' => function () {
                    include 'config.php';
                    $stmt = $pdo->query("SELECT * FROM appuser_tb");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            ],
            'countries' => [
                'type' => Type::listOf($countryType),
                'resolve' => function () {
                    include 'config.php';
                    $stmt = $pdo->query("SELECT * FROM country_tb");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            ],
            'contactInfo' => [
                'type' => Type::listOf($contactInfoType),
                'resolve' => function () {
                    include 'config.php';
                    $stmt = $pdo->query("SELECT * FROM contactinfo_tb");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            ],
            'userDocuments' => [
                'type' => Type::listOf($userDocumentType),
                'resolve' => function () {
                    include 'config.php';
                    $stmt = $pdo->query("SELECT * FROM userdocument_tb");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            ],
            'typeDocuments' => [
                'type' => Type::listOf($typeDocumentType),
                'resolve' => function () {
                    include 'config.php';
                    $stmt = $pdo->query("SELECT * FROM typedocument_tb");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            ]
        ]
    ]),

    'mutation' => new ObjectType([
        'name' => 'Mutation',
        'fields' => [
            'registerUser' => [
                'type' => Type::nonNull(Type::boolean()),
                'args' => [
                    'LastName' => Type::nonNull(Type::string()),
                    'Name' => Type::nonNull(Type::string()),
                    'username' => Type::nonNull(Type::string()),
                    'password' => Type::nonNull(Type::string()),
                    'email' => Type::nonNull(Type::string()),
                    'Document' => Type::string(),
                    'TypeDocumentID' => Type::int(),
                    'Address' => Type::string(),
                    'CountryID' => Type::int(),
                    'Phone' => Type::string(),
                    'City' => Type::string(),
                    'CelPhone' => Type::string(),
                    'EmergencyName' => Type::string(),
                    'EmergencyPhone' => Type::string(),
                    'DocumentPlaceExpedition' => Type::string(),
                    'DocumentDateExpedition' => Type::string()
                ],
                'resolve' => function ($root, $args) {
                    try {
                        include 'config.php';
                        $pdo->beginTransaction();

                        // Verificar si el email ya existe
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM appuser_tb WHERE email = :email");
                        $stmt->execute(['email' => $args['email']]);
                        $emailCount = $stmt->fetchColumn();

                        // Si el email ya existe, lanzar un error
                        if ($emailCount > 0) {
                            throw new Error("El correo electrónico ya está registrado.");
                        }

                         // Verificar si el username ya existe
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM appuser_tb WHERE username = :username");
                        $stmt->execute(['username' => $args['username']]);
                        $emailCount = $stmt->fetchColumn();

                        // Si el username ya existe, lanzar un error
                        if ($emailCount > 0) {
                            throw new Error("El usuario ya está registrado.");
                        }

                        // Verificar si el documento ya existe
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM userdocument_tb WHERE Document = :document");
                        $stmt->execute(['document' => $args['Document']]);
                        $documentCount = $stmt->fetchColumn();

                        // Si el documento ya existe, lanzar un error
                        if ($documentCount > 0) {
                            throw new Error("El documento ya está registrado.");
                        }

                        // Insertar usuario
                        $stmt = $pdo->prepare("INSERT INTO appuser_tb (LastName, Name, username, password, email) VALUES (:LastName, :Name, :username, :password, :email)");
                        $stmt->execute([
                            'LastName' => $args['LastName'],
                            'Name' => $args['Name'],
                            'username' => $args['username'],
                            'password' => password_hash($args['password'], PASSWORD_BCRYPT),
                            'email' => $args['email']
                        ]);
                        $userId = $pdo->lastInsertId();

                        // Insertar información de contacto
                        $stmt = $pdo->prepare("INSERT INTO contactinfo_tb (UserID, Address, CountryID, City, Phone, CelPhone, EmergencyName, EmergencyPhone) VALUES (:UserID, :Address, :CountryID, :City, :Phone, :CelPhone, :EmergencyName, :EmergencyPhone)");
                        $stmt->execute([
                            'UserID' => $userId,
                            'Address' => $args['Address'],
                            'CountryID' => $args['CountryID'] ?? null,
                            'City' => $args['City'],
                            'Phone' => $args['Phone'],
                            'CelPhone' => $args['CelPhone'],
                            'EmergencyName' => $args['EmergencyName'],
                            'EmergencyPhone' => $args['EmergencyPhone']
                        ]);

                        // Insertar documento si se ha proporcionado
                        if (!empty($args['Document'])) {
                            $stmt = $pdo->prepare("INSERT INTO userdocument_tb (UserID, Document, TypeDocumentID, PlaceExpedition, DateExpedition) VALUES (:UserID, :Document, :TypeDocumentID, :PlaceExpedition, :DateExpedition)");
                            $stmt->execute([
                                'UserID' => $userId,
                                'Document' => $args['Document'],
                                'TypeDocumentID' => $args['TypeDocumentID'],
                                'PlaceExpedition' => $args['DocumentPlaceExpedition'],
                                'DateExpedition' => $args['DocumentDateExpedition']
                            ]);
                        }

                        $pdo->commit();
                        return true;
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        throw new Error($e->getMessage());
                    }
                }
            ]
        ]
    ])
]);
