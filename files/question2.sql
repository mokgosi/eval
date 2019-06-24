DROP TABLE IF EXISTS `tUSER`;

CREATE TABLE `tUSER` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE(`id_number`),
  INDEX user_id_num_ind (id_number)
);

DROP TABLE IF EXISTS `tPROFILE`;

CREATE TABLE `tPROFILE` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tUSER_id` bigint(20) NOT NULL,
  `tTYPES_id` bigint(20) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX user_id_ind (tUSER_id),
  FOREIGN KEY (tUSER_id) REFERENCES tUSER(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `tTYPES`;

CREATE TABLE `tTYPES` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX types_type_ind (type)
);