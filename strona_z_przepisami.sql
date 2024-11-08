-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 08, 2024 at 03:14 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strona z przepisami`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Desery', 'Słodka potrawa podawana jako osobne słodkie danie na koniec posiłku (obiadu, kolacji lub przyjęcia), ale także na podwieczorek albo podczas niezobowiązującego spotkania o dowolnej porze dnia.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `recipe_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 1, 'Przepyszne polecam dla osób bardzo lubiących słodkości', '2024-11-06 17:07:53');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `detailed_recipe_info`
-- (See below for the actual view)
--
CREATE TABLE `detailed_recipe_info` (
`recipe_id` int(11)
,`recipe_title` varchar(100)
,`description` text
,`instructions` text
,`author` varchar(50)
,`ingredients` mediumtext
,`ingredient_count` bigint(21)
,`categories` mediumtext
,`tags` mediumtext
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `name`, `description`) VALUES
(1, 'białka jaj (rozm. L)', NULL),
(2, 'Cukier', NULL),
(3, 'Pulpa z marakui', NULL),
(4, 'Śmietana 36%', NULL),
(5, 'Cukier puder', NULL),
(6, 'Żelatyna', NULL);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `popular_recipes`
-- (See below for the actual view)
--
CREATE TABLE `popular_recipes` (
`recipe_id` int(11)
,`recipe_title` varchar(100)
,`author` varchar(50)
,`avg_rating` decimal(7,4)
,`total_comments` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT 3 CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `recipe_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 1, 1, 5, '2024-11-06 17:08:52');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `recent_recipes`
-- (See below for the actual view)
--
CREATE TABLE `recent_recipes` (
`recipe_id` int(11)
,`title` varchar(100)
,`user_id` int(11)
,`category` varchar(50)
,`tags` mediumtext
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `instructions` text NOT NULL,
  `servings` int(11) DEFAULT 1,
  `prep_time` int(11) DEFAULT 0,
  `cook_time` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `description`, `instructions`, `servings`, `prep_time`, `cook_time`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Mini bezy pavlove z kremem z marakui', NULL, 'Przygotowanie bez:\r\n1. Piekarnik nagrzej do 180 stopni celsjusza - funkcja termoobieg\r\n2. Białka przełóż do misy miksera i zacznij ubijać na najwyższych obrotach. Gdy białka zaczną się pienić, powoli dosypuj cukier.\r\n3. Ubijaj przez ok. 10-15 minut do rozpuszczenia się cukru. Aby to sprawdzić, należy nabrać trochę masy między dwa palce i ją rozetrzeć. Jeżeli cukier nie będzie wyczuwalny - przejdź do następnego punktu, jeżeli będzie - jeszcze chwilę ubijaj.\r\n4. Gotową, ubitą masę przełóż do worka cukierniczego. Można użyć tylki.\r\n5. Po uformowaniu mini bez włóż do nagrzanego piekarnika i obniż temperaturę do 100 stopni Celsjusza. Susz bezy na funkcji termoobieg przez 1,5h.\r\nPrzygotowanie kremu z marakui:\r\n6. Żelatynę zalej łyżką letniej wody i odstaw.\r\n7. Pulpę z marakui podgrzej, doprowadź do momentu gdy będzie widoczna para. Ściągnij z palnika, odczekaj ok. 5 minut, a następnie dodaj przygotowaną wcześniej żelatynę do pulpy. Mieszaj do momentu aż się rozpuści. Odstaw do ostygnięcia, ale uważaj, żeby nie zaczęła zastygać.\r\n8. Śmietanę ubij z cukrem pudrem, pod koniec dodaj przestudzoną marakuję, wymieszaj do uzyskania jednolitej masy.\r\n9. Krem przełóż na bezy i udekoruj ulubionymi owocami, możnesz również posypać płatkami jadalnych kwiatów.', 10, 60, 80, 1, '2024-11-06 16:30:52', '2024-11-06 16:51:16');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipe_categories`
--

CREATE TABLE `recipe_categories` (
  `recipe_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_categories`
--

INSERT INTO `recipe_categories` (`recipe_id`, `category_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` decimal(5,2) DEFAULT 0.00,
  `unit` varchar(20) DEFAULT 'g'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `quantity`, `unit`) VALUES
(1, 1, 5.00, ''),
(1, 2, 300.00, 'g'),
(1, 3, 200.00, 'g'),
(1, 4, 400.00, 'g'),
(1, 5, 1.00, 'kopiasta łyżka'),
(1, 6, 1.00, 'kopiasta łyżeczka');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `recipe_overview`
-- (See below for the actual view)
--
CREATE TABLE `recipe_overview` (
`recipe_id` int(11)
,`recipe_title` varchar(100)
,`description` text
,`author` varchar(50)
,`categories` mediumtext
,`tags` mediumtext
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipe_tags`
--

CREATE TABLE `recipe_tags` (
  `recipe_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_tags`
--

INSERT INTO `recipe_tags` (`recipe_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`) VALUES
(1, 'słodkie'),
(2, 'marakuja'),
(3, 'bezy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'jan_kowalski', 'jan.kowalski@example.com', '', '2024-11-06 16:07:01');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `user_activity_summary`
-- (See below for the actual view)
--
CREATE TABLE `user_activity_summary` (
`user_id` int(11)
,`author` varchar(50)
,`total_recipes` bigint(21)
,`avg_rating` decimal(7,4)
);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `user_recipe_summary`
-- (See below for the actual view)
--
CREATE TABLE `user_recipe_summary` (
`user_id` int(11)
,`author` varchar(50)
,`total_recipes` bigint(21)
,`avg_ingredients_per_recipe` decimal(24,4)
);

-- --------------------------------------------------------

--
-- Struktura widoku `detailed_recipe_info`
--
DROP TABLE IF EXISTS `detailed_recipe_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detailed_recipe_info`  AS SELECT `r`.`recipe_id` AS `recipe_id`, `r`.`title` AS `recipe_title`, `r`.`description` AS `description`, `r`.`instructions` AS `instructions`, `u`.`username` AS `author`, `ing`.`ingredients` AS `ingredients`, `ing`.`ingredient_count` AS `ingredient_count`, group_concat(distinct `c`.`name` separator ', ') AS `categories`, group_concat(distinct `t`.`name` separator ', ') AS `tags` FROM ((((((`recipes` `r` join `users` `u` on(`r`.`user_id` = `u`.`user_id`)) left join (select `ri`.`recipe_id` AS `recipe_id`,group_concat(concat(`i`.`name`,' (',`ri`.`quantity`,' ',`ri`.`unit`,')') separator ', ') AS `ingredients`,count(`ri`.`ingredient_id`) AS `ingredient_count` from (`recipe_ingredients` `ri` join `ingredients` `i` on(`ri`.`ingredient_id` = `i`.`ingredient_id`)) group by `ri`.`recipe_id`) `ing` on(`r`.`recipe_id` = `ing`.`recipe_id`)) left join `recipe_categories` `rc` on(`r`.`recipe_id` = `rc`.`recipe_id`)) left join `categories` `c` on(`rc`.`category_id` = `c`.`category_id`)) left join `recipe_tags` `rt` on(`r`.`recipe_id` = `rt`.`recipe_id`)) left join `tags` `t` on(`rt`.`tag_id` = `t`.`tag_id`)) GROUP BY `r`.`recipe_id` ;

-- --------------------------------------------------------

--
-- Struktura widoku `popular_recipes`
--
DROP TABLE IF EXISTS `popular_recipes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `popular_recipes`  AS SELECT `r`.`recipe_id` AS `recipe_id`, `r`.`title` AS `recipe_title`, `u`.`username` AS `author`, ifnull(avg(`rt`.`rating`),0) AS `avg_rating`, ifnull(`comment_count`.`total_comments`,0) AS `total_comments` FROM (((`recipes` `r` join `users` `u` on(`r`.`user_id` = `u`.`user_id`)) left join `ratings` `rt` on(`r`.`recipe_id` = `rt`.`recipe_id`)) left join (select `comments`.`recipe_id` AS `recipe_id`,count(`comments`.`comment_id`) AS `total_comments` from `comments` group by `comments`.`recipe_id`) `comment_count` on(`r`.`recipe_id` = `comment_count`.`recipe_id`)) GROUP BY `r`.`recipe_id` ORDER BY ifnull(avg(`rt`.`rating`),0) DESC ;

-- --------------------------------------------------------

--
-- Struktura widoku `recent_recipes`
--
DROP TABLE IF EXISTS `recent_recipes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `recent_recipes`  AS SELECT `r`.`recipe_id` AS `recipe_id`, `r`.`title` AS `title`, `r`.`user_id` AS `user_id`, `c`.`name` AS `category`, group_concat(`t`.`name` separator ', ') AS `tags` FROM ((((`recipes` `r` join `recipe_categories` `rc` on(`r`.`recipe_id` = `rc`.`recipe_id`)) join `categories` `c` on(`rc`.`category_id` = `c`.`category_id`)) join `recipe_tags` `rt` on(`r`.`recipe_id` = `rt`.`recipe_id`)) join `tags` `t` on(`rt`.`tag_id` = `t`.`tag_id`)) GROUP BY `r`.`recipe_id`, `r`.`title`, `r`.`user_id`, `c`.`name` ORDER BY `r`.`created_at` DESC ;

-- --------------------------------------------------------

--
-- Struktura widoku `recipe_overview`
--
DROP TABLE IF EXISTS `recipe_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `recipe_overview`  AS SELECT `r`.`recipe_id` AS `recipe_id`, `r`.`title` AS `recipe_title`, `r`.`description` AS `description`, `u`.`username` AS `author`, group_concat(distinct `c`.`name` separator ', ') AS `categories`, group_concat(distinct `t`.`name` separator ', ') AS `tags` FROM (((((`recipes` `r` join `users` `u` on(`r`.`user_id` = `u`.`user_id`)) left join `recipe_categories` `rc` on(`r`.`recipe_id` = `rc`.`recipe_id`)) left join `categories` `c` on(`rc`.`category_id` = `c`.`category_id`)) left join `recipe_tags` `rt` on(`r`.`recipe_id` = `rt`.`recipe_id`)) left join `tags` `t` on(`rt`.`tag_id` = `t`.`tag_id`)) GROUP BY `r`.`recipe_id` ;

-- --------------------------------------------------------

--
-- Struktura widoku `user_activity_summary`
--
DROP TABLE IF EXISTS `user_activity_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_activity_summary`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`username` AS `author`, count(`r`.`recipe_id`) AS `total_recipes`, avg(`rr`.`rating`) AS `avg_rating` FROM ((`users` `u` left join `recipes` `r` on(`u`.`user_id` = `r`.`user_id`)) left join `ratings` `rr` on(`r`.`recipe_id` = `rr`.`recipe_id`)) GROUP BY `u`.`user_id`, `u`.`username` ;

-- --------------------------------------------------------

--
-- Struktura widoku `user_recipe_summary`
--
DROP TABLE IF EXISTS `user_recipe_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_recipe_summary`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`username` AS `author`, count(`r`.`recipe_id`) AS `total_recipes`, ifnull(avg(`ri`.`ingredient_count`),0) AS `avg_ingredients_per_recipe` FROM ((`users` `u` left join `recipes` `r` on(`u`.`user_id` = `r`.`user_id`)) left join (select `recipe_ingredients`.`recipe_id` AS `recipe_id`,count(`recipe_ingredients`.`ingredient_id`) AS `ingredient_count` from `recipe_ingredients` group by `recipe_ingredients`.`recipe_id`) `ri` on(`r`.`recipe_id` = `ri`.`recipe_id`)) GROUP BY `u`.`user_id` ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Indeksy dla tabeli `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `author_id` (`user_id`);

--
-- Indeksy dla tabeli `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD PRIMARY KEY (`recipe_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`recipe_id`,`ingredient_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indeksy dla tabeli `recipe_tags`
--
ALTER TABLE `recipe_tags`
  ADD PRIMARY KEY (`recipe_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indeksy dla tabeli `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD CONSTRAINT `recipe_categories_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe_ingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_tags`
--
ALTER TABLE `recipe_tags`
  ADD CONSTRAINT `recipe_tags_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
