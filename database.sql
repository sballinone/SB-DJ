CREATE TABLE `playlist` (
  `id` int(9) NOT NULL,
  `title` varchar(50) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `waswish` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `setlist` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `played` tinyint(1) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wishlist` (
  `id` int(9) NOT NULL,
  `title` varchar(50) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `declined` tinyint(1) NOT NULL,
  `votes` int(4) NOT NULL,
  `hostname` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `setlist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `playlist`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `setlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wishlist`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
