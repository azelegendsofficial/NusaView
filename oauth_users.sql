CREATE TABLE oauth_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id VARCHAR(255) NOT NULL,
    provider_name VARCHAR(50) NOT NULL,
    name VARCHAR(255),
    email VARCHAR(255),
    profile_picture VARCHAR(255),
    access_token VARCHAR(255),
    refresh_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_provider_user (provider_name, provider_id)
);
