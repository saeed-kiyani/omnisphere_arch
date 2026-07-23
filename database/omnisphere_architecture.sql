USE omnisphere_architecture;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Super Admin','Admin') DEFAULT 'Admin',
    profile_image VARCHAR(255) DEFAULT NULL,
    last_login DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(150) NOT NULL,

    slug VARCHAR(180) NOT NULL UNIQUE,

    short_description TEXT,

    description LONGTEXT,

    icon VARCHAR(255),

    cover_image VARCHAR(255),

    featured TINYINT(1) DEFAULT 0,

    status ENUM('Active','Inactive') DEFAULT 'Active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,

    service_id INT NOT NULL,

    title VARCHAR(200) NOT NULL,

    slug VARCHAR(220) NOT NULL UNIQUE,

    client_name VARCHAR(150) DEFAULT NULL,

    location VARCHAR(200) DEFAULT NULL,

    project_year YEAR DEFAULT NULL,

    project_area VARCHAR(100) DEFAULT NULL,

    project_status ENUM(
        'Concept',
        'In Progress',
        'Completed'
    ) DEFAULT 'Completed',

    thumbnail VARCHAR(255) DEFAULT NULL,

    short_description TEXT,

    description LONGTEXT,

    featured TINYINT(1) DEFAULT 0,

    status ENUM(
        'Published',
        'Draft'
    ) DEFAULT 'Published',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_portfolio_service
        FOREIGN KEY (service_id)
        REFERENCES services(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE portfolio_images (
    id INT AUTO_INCREMENT PRIMARY KEY,

    portfolio_id INT NOT NULL,

    image VARCHAR(255) NOT NULL,

    alt_text VARCHAR(255) DEFAULT NULL,

    display_order INT DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_portfolio_images
        FOREIGN KEY (portfolio_id)
        REFERENCES portfolio(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE blog (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    slug VARCHAR(255) NOT NULL UNIQUE,

    thumbnail VARCHAR(255) DEFAULT NULL,

    short_description TEXT,

    content LONGTEXT NOT NULL,

    meta_title VARCHAR(255) DEFAULT NULL,

    meta_description TEXT,

    author VARCHAR(100) DEFAULT 'Admin',

    featured TINYINT(1) DEFAULT 0,

    views INT DEFAULT 0,

    status ENUM('Published','Draft') DEFAULT 'Draft',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE team (
    id INT AUTO_INCREMENT PRIMARY KEY,

    full_name VARCHAR(150) NOT NULL,

    designation VARCHAR(150) NOT NULL,

    profile_image VARCHAR(255) DEFAULT NULL,

    bio TEXT,

    email VARCHAR(150) DEFAULT NULL,

    phone VARCHAR(20) DEFAULT NULL,

    linkedin VARCHAR(255) DEFAULT NULL,

    facebook VARCHAR(255) DEFAULT NULL,

    instagram VARCHAR(255) DEFAULT NULL,

    display_order INT DEFAULT 1,

    status ENUM('Active','Inactive') DEFAULT 'Active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,

    client_name VARCHAR(150) NOT NULL,

    designation VARCHAR(150) DEFAULT NULL,

    company_name VARCHAR(150) DEFAULT NULL,

    profile_image VARCHAR(255) DEFAULT NULL,

    rating TINYINT NOT NULL DEFAULT 5,

    review TEXT NOT NULL,

    featured TINYINT(1) DEFAULT 0,

    display_order INT DEFAULT 1,

    status ENUM('Active','Inactive') DEFAULT 'Active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CHECK (rating BETWEEN 1 AND 5)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE contact_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,

    full_name VARCHAR(150) NOT NULL,

    email VARCHAR(150) NOT NULL,

    phone VARCHAR(20) NOT NULL,

    service_id INT NOT NULL,

    subject VARCHAR(200) DEFAULT NULL,

    message TEXT NOT NULL,

    budget VARCHAR(100) DEFAULT NULL,

    project_location VARCHAR(200) DEFAULT NULL,

    status ENUM(
        'New',
        'Contacted',
        'Quotation Sent',
        'Won',
        'Lost'
    ) DEFAULT 'New',

    notes TEXT DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_contact_service
        FOREIGN KEY (service_id)
        REFERENCES services(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE website_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,

    company_name VARCHAR(200) NOT NULL,

    tagline VARCHAR(255) DEFAULT NULL,

    logo VARCHAR(255) DEFAULT NULL,

    favicon VARCHAR(255) DEFAULT NULL,

    email VARCHAR(150) DEFAULT NULL,

    phone VARCHAR(20) DEFAULT NULL,

    whatsapp VARCHAR(20) DEFAULT NULL,

    address TEXT,

    google_map_iframe LONGTEXT,

    facebook VARCHAR(255) DEFAULT NULL,

    instagram VARCHAR(255) DEFAULT NULL,

    linkedin VARCHAR(255) DEFAULT NULL,

    youtube VARCHAR(255) DEFAULT NULL,

    meta_title VARCHAR(255) DEFAULT NULL,

    meta_description TEXT,

    meta_keywords TEXT,

    google_analytics_id VARCHAR(100) DEFAULT NULL,

    meta_pixel_id VARCHAR(100) DEFAULT NULL,

    footer_text VARCHAR(255) DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;