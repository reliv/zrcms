CREATE TABLE zrcms_core_container_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, blockVersions LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_container_resource (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, contentVersionId INT DEFAULT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX contentVersionId (contentVersionId), INDEX siteCmsResourceId (siteCmsResourceId), INDEX path (path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_container_resource_history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, cmsResourceId INT DEFAULT NULL, cmsResourceProperties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', contentVersionId INT DEFAULT NULL, createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_6BB826764D52BE11 (cmsResourceId), INDEX IDX_6BB826762B36D621 (contentVersionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, containersData LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_resource (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, contentVersionId INT DEFAULT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX contentVersionId (contentVersionId), INDEX siteCmsResourceId (siteCmsResourceId), INDEX path (path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_resource_history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, cmsResourceId INT DEFAULT NULL, cmsResourceProperties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', contentVersionId INT DEFAULT NULL, createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_158D4BD74D52BE11 (cmsResourceId), INDEX IDX_158D4BD72B36D621 (contentVersionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_template_resource (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, contentVersionId INT DEFAULT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX contentVersionId (contentVersionId), INDEX siteCmsResourceId (siteCmsResourceId), INDEX path (path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_page_template_resource_history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, cmsResourceId INT DEFAULT NULL, cmsResourceProperties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', contentVersionId INT DEFAULT NULL, createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_BF0213C54D52BE11 (cmsResourceId), INDEX IDX_BF0213C52B36D621 (contentVersionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_site_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, themeName VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_site_resource (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, contentVersionId INT DEFAULT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_76D0C290CF2713FD (host), INDEX contentVersionId (contentVersionId), INDEX host (host), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_site_resource_history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, cmsResourceId INT DEFAULT NULL, cmsResourceProperties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', contentVersionId INT DEFAULT NULL, createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL, INDEX IDX_435CA2254D52BE11 (cmsResourceId), INDEX IDX_435CA2252B36D621 (contentVersionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_layout_resource (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, contentVersionId INT DEFAULT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, themeName VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX contentVersionId (contentVersionId), INDEX themeName (themeName), INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_layout_resource_history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, cmsResourceId INT DEFAULT NULL, cmsResourceProperties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', contentVersionId INT DEFAULT NULL, createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, themeName VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_EEE165C84D52BE11 (cmsResourceId), INDEX IDX_EEE165C82B36D621 (contentVersionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_layout_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, html LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_redirect_version (id INT AUTO_INCREMENT NOT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, redirectPath VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_redirect_resource (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, contentVersionId INT DEFAULT NULL, properties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) DEFAULT NULL, requestPath VARCHAR(255) NOT NULL, INDEX IDX_49AEB5392B36D621 (contentVersionId), INDEX siteCmsResourceId (siteCmsResourceId), INDEX requestPath (requestPath), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE zrcms_core_redirect_resource_history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, cmsResourceId INT DEFAULT NULL, cmsResourceProperties LONGTEXT NOT NULL COMMENT '(DC2Type:json_array)', contentVersionId INT DEFAULT NULL, createdDate DATETIME NOT NULL, createdByUserId VARCHAR(255) NOT NULL, createdReason VARCHAR(255) NOT NULL, siteCmsResourceId VARCHAR(255) DEFAULT NULL, requestPath VARCHAR(255) NOT NULL, INDEX IDX_CDC8F3C14D52BE11 (cmsResourceId), INDEX IDX_CDC8F3C12B36D621 (contentVersionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE zrcms_core_container_resource ADD CONSTRAINT FK_4D6AE3682B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_container_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_container_resource_history ADD CONSTRAINT FK_6BB826764D52BE11 FOREIGN KEY (cmsResourceId) REFERENCES zrcms_core_container_resource (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_container_resource_history ADD CONSTRAINT FK_6BB826762B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_container_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_page_resource ADD CONSTRAINT FK_FA027A6A2B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_page_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_page_resource_history ADD CONSTRAINT FK_158D4BD74D52BE11 FOREIGN KEY (cmsResourceId) REFERENCES zrcms_core_page_resource (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_page_resource_history ADD CONSTRAINT FK_158D4BD72B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_page_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_page_template_resource ADD CONSTRAINT FK_B4C0E69C2B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_page_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_page_template_resource_history ADD CONSTRAINT FK_BF0213C54D52BE11 FOREIGN KEY (cmsResourceId) REFERENCES zrcms_core_page_template_resource (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_page_template_resource_history ADD CONSTRAINT FK_BF0213C52B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_page_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_site_resource ADD CONSTRAINT FK_76D0C2902B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_site_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_site_resource_history ADD CONSTRAINT FK_435CA2254D52BE11 FOREIGN KEY (cmsResourceId) REFERENCES zrcms_core_site_resource (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_site_resource_history ADD CONSTRAINT FK_435CA2252B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_site_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_layout_resource ADD CONSTRAINT FK_208895F12B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_layout_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_layout_resource_history ADD CONSTRAINT FK_EEE165C84D52BE11 FOREIGN KEY (cmsResourceId) REFERENCES zrcms_core_layout_resource (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_layout_resource_history ADD CONSTRAINT FK_EEE165C82B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_layout_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_redirect_resource ADD CONSTRAINT FK_49AEB5392B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_redirect_version (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_redirect_resource_history ADD CONSTRAINT FK_CDC8F3C14D52BE11 FOREIGN KEY (cmsResourceId) REFERENCES zrcms_core_redirect_resource (id) ON DELETE SET NULL;
ALTER TABLE zrcms_core_redirect_resource_history ADD CONSTRAINT FK_CDC8F3C12B36D621 FOREIGN KEY (contentVersionId) REFERENCES zrcms_core_redirect_version (id) ON DELETE SET NULL;
