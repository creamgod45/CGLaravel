-- animals: table
CREATE TABLE `animals` (
                           `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `type_id` int unsigned NOT NULL COMMENT '動物分類',
                           `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '動物的暱稱',
                           `birthday` date DEFAULT NULL COMMENT '生日',
                           `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '所在地區',
                           `fix` tinyint(1) NOT NULL DEFAULT '0' COMMENT '結紮情形',
                           `description` text COLLATE utf8mb4_unicode_ci COMMENT '簡單敘述',
                           `personality` text COLLATE utf8mb4_unicode_ci COMMENT '動物個性',
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `animals_type_id_unique` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- jobs: table
CREATE TABLE `jobs` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                        `attempts` tinyint unsigned NOT NULL,
                        `reserved_at` int unsigned DEFAULT NULL,
                        `available_at` int unsigned NOT NULL,
                        `created_at` int unsigned NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=491 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No native definition for element: jobs_queue_index (index)

-- members: table
CREATE TABLE `members` (
                           `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                           `UUID` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `email_verified_at` timestamp NULL DEFAULT NULL,
                           `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
                           `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `enable` enum('false','true') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
                           `administrator` enum('false','true') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
                           `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `members_username_unique` (`username`),
                           UNIQUE KEY `members_email_unique` (`email`),
                           UNIQUE KEY `members_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- migrations: table
CREATE TABLE `migrations` (
                              `id` int unsigned NOT NULL AUTO_INCREMENT,
                              `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `batch` int NOT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- password_reset_tokens: table
CREATE TABLE `password_reset_tokens` (
                                         `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                         `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                         `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                         `created_at` timestamp NULL DEFAULT NULL,
                                         `updated_at` timestamp NULL DEFAULT NULL,
                                         PRIMARY KEY (`id`),
                                         KEY `password_reset_tokens_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No native definition for element: password_reset_tokens_email_index (index)

-- personal_access_tokens: table
CREATE TABLE `personal_access_tokens` (
                                          `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                                          `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `tokenable_id` bigint unsigned NOT NULL,
                                          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `abilities` text COLLATE utf8mb4_unicode_ci,
                                          `last_used_at` timestamp NULL DEFAULT NULL,
                                          `expires_at` timestamp NULL DEFAULT NULL,
                                          `created_at` timestamp NULL DEFAULT NULL,
                                          `updated_at` timestamp NULL DEFAULT NULL,
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
                                          KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No native definition for element: personal_access_tokens_tokenable_type_tokenable_id_index (index)

-- sessions: table
CREATE TABLE `sessions` (
                            `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `user_id` bigint unsigned DEFAULT NULL,
                            `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `user_agent` text COLLATE utf8mb4_unicode_ci,
                            `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                            `last_activity` int NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `sessions_user_id_index` (`user_id`),
                            KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No native definition for element: sessions_user_id_index (index)

-- No native definition for element: sessions_last_activity_index (index)

