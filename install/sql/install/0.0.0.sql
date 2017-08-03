CREATE TABLE zrcms_core_site_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, themeName VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_site_resource (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_site_resource_publish_history (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_container_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, blockVersionsData LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_container_resource (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_container_resource_publish_history (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_container_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, blockVersionsData LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_container_resource (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_container_resource_publish_history (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_layout_resource (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, themeName VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_layout_resource_publish_history (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_layout_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, html LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_country_resource (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_country_resource_publish_history (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_country_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, iso3 VARCHAR(3) NOT NULL, iso2 VARCHAR(2) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_language_resource (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_language_resource_publish_history (id INT AUTO_INCREMENT NOT NULL, contentVersionId VARCHAR(255) NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_language_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, iso639_2t VARCHAR(3) NOT NULL, iso639_2b VARCHAR(3) NOT NULL, iso639_1 VARCHAR(2) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
