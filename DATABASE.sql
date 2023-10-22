-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Paź 2023, 16:05
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `project_pai`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_date` date NOT NULL,
  `book_start` date NOT NULL,
  `book_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(60) NOT NULL,
  `country_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_desc`) VALUES
(1, 'South Korea', 'South Korea, officially known as the Republic of Korea, is a vibrant and culturally rich nation located on the Korean Peninsula in East Asia. Its culture is a captivating blend of tradition and modernity, creating a unique and dynamic identity.'),
(2, 'Japan', 'Japan, an island nation in East Asia, boasts a culture that\'s a captivating fusion of tradition and innovation. Its unique cultural elements have had a profound influence on the world.'),
(3, 'China', 'A vast and diverse country in East Asia, is celebrated for its rich and multifaceted culture, which has evolved over thousands of years. Its cultural heritage is deeply rooted in tradition and has significantly influenced the world.'),
(4, 'Taiwan', 'An island nation in East Asia, is a place of vibrant and diverse culture deeply influenced by its unique history and geographical location. Its culture is a dynamic blend of traditional Chinese heritage and modern innovations.'),
(5, 'Vietnam', 'Located in Southeast Asia, is a nation with a rich and diverse cultural heritage deeply intertwined with its history and geography. Its culture reflects a unique blend of tradition, innovation, and resilience.'),
(6, 'Cambodia', 'ocated in Southeast Asia, is a nation with a rich cultural heritage deeply intertwined with its history, religion, and stunning architectural wonders. Its culture reflects a unique blend of ancient traditions and the enduring spirit of its people.'),
(7, 'Thailand', 'Southeast Asian nation, is renowned for its rich and vibrant culture, which seamlessly combines traditional heritage with modern influences. Its culture is characterized by a deep appreciation for spirituality, art, and hospitality.'),
(8, 'Laos', 'A landlocked country in Southeast Asia, possesses a rich and diverse culture deeply influenced by its history, religion, and breathtaking natural landscapes. Its culture is characterized by its deep spirituality, traditions, and a strong connection to the environment.'),
(9, 'Bangladesh', 'A South Asian nation, boasts a diverse and vibrant culture deeply rooted in its history, traditions, and the resilience of its people. Its culture is characterized by a rich blend of heritage, art, music, and a strong sense of community.'),
(10, 'Bhutan', 'A small Himalayan kingdom in South Asia, is celebrated for its unique and rich culture, deeply rooted in its history, Buddhism, and its commitment to preserving tradition. Bhutan\'s culture is marked by a deep sense of spirituality, reverence for nature, and a unique approach to modernization.'),
(11, 'Malaysia', 'A Southeast Asian nation, is celebrated for its diverse and multicultural society, which has created a vibrant and dynamic cultural tapestry. The country\'s culture reflects a harmonious blend of traditions, religions, and influences from various ethnic communities.'),
(12, 'Singapore', 'A city-state in Southeast Asia, is celebrated for its unique and diverse culture, a testament to its history as a melting pot of different ethnicities and traditions. The culture of Singapore is characterized by a harmonious blend of influences from its Chinese, Malay, Indian, and Western roots.'),
(13, 'Mongolia', 'A landlocked country in East Asia, is known for its unique and nomadic culture, deeply rooted in its history, vast landscapes, and the enduring spirit of its people. Mongolian culture is characterized by its strong ties to the nomadic way of life, ancient traditions, and deep respect for nature.'),
(14, 'Nepal', 'Nestled in the Himalayas in South Asia, is renowned for its rich and diverse culture deeply intertwined with its breathtaking natural landscapes and deep-rooted spiritual traditions. The culture of Nepal is characterized by its profound connection to the mountains, religious heritage, and vibrant traditions.'),
(15, 'India', 'A vast and diverse South Asian nation, is celebrated for its rich and multifaceted culture, one of the world\'s oldest and most complex. Its culture is a captivating fusion of ancient traditions, spiritual depth, and modern innovation.'),
(16, 'Myanmar', 'A diverse Southeast Asian nation, is celebrated for its rich and multifaceted culture deeply rooted in its history, spirituality, and the enduring traditions of its people. Myanmar\'s culture is characterized by its deep connection to Buddhism, a reverence for tradition, and a complex blend of ethnicities.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `places`
--

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(70) NOT NULL,
  `city_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `places`
--

INSERT INTO `places` (`place_id`, `country_id`, `city`, `city_desc`) VALUES
(1, 1, 'Seoul', 'The capital and largest city of South Korea, Seoul is a bustling metropolis with a perfect blend of modernity and tradition. You can explore ancient palaces, vibrant markets, and enjoy the thriving K-pop culture. Don\'t miss the stunning Bukchon Hanok Village and the futuristic Dongdaemun Design Plaza.'),
(2, 1, 'Busan', 'South Korea\'s second-largest city, Busan, is known for its beautiful beaches, such as Haeundae and Gwangalli. The city also offers a bustling fish market, historical temples, and the famous Busan International Film Festival. It\'s a great place to experience a more relaxed coastal lifestyle.'),
(3, 1, 'Jeju City', 'Located on Jeju Island, Jeju City is a popular destination for nature lovers. Explore the unique volcanic landscapes, stunning waterfalls, and the picturesque Hallasan National Park. The island is also famous for its lava tubes and lava caves.'),
(4, 1, 'Incheon', 'Incheon, a port city near Seoul, is renowned for its modern developments and transportation hub, including Incheon International Airport. You can visit Chinatown, Wolmido Island, and the Freedom Park, which commemorates the Incheon landing during the Korean War.'),
(5, 2, 'Tokyo', 'Japan\'s bustling capital, Tokyo is a city that seamlessly blends the ultramodern with the traditional. Explore high-tech districts like Shibuya and Akihabara, visit historic temples like Senso-ji, and savor world-class cuisine. Tokyo is a city of constant excitement and innovation.'),
(6, 2, 'Kyoto', 'Kyoto is the epitome of traditional Japan, with its historic temples, tea houses, and beautiful gardens. It\'s famous for the stunning Kinkaku-ji (Golden Pavilion) and Fushimi Inari Shrine. Don\'t miss the opportunity to experience a traditional tea ceremony in this cultural treasure.'),
(7, 2, 'Osaka', 'Osaka is known for its vibrant street food scene and lively atmosphere. Visit Osaka Castle, explore the entertainment district of Dotonbori, and try the city\'s iconic street foods like takoyaki and okonomiyaki. Osaka is often called \'Japan\'s Kitchen.\''),
(8, 2, 'Hiroshima', 'Hiroshima is a city with a poignant history, having been largely destroyed by an atomic bomb during World War II. The Hiroshima Peace Memorial, also known as the Atomic Bomb Dome, is a UNESCO World Heritage Site. The Peace Memorial Park and Museum provide a moving experience and a message of peace.'),
(9, 3, 'Beijing', 'As the capital of China, Beijing is a city steeped in history and culture. Explore the iconic Forbidden City, visit the historic Temple of Heaven, and walk along the Great Wall of China. Beijing also offers a glimpse into China\'s modernity with its skyscrapers and contemporary art scenes.'),
(10, 3, 'Shanghai', 'Shanghai is China\'s economic hub and a bustling metropolis that seamlessly combines the old and the new. Wander along the historic Bund waterfront, admire the futuristic skyline in the Pudong district, and explore the vibrant neighborhoods like Tianzifang. Shanghai offers a taste of China\'s cosmopolitan side.'),
(11, 3, 'Xi\'an', 'Xi\'an is known for its ancient history and the famous Terracotta Army. Explore the city walls, visit the Big Wild Goose Pagoda, and experience the vibrant Muslim Quarter. Xi\'an offers a journey through China\'s ancient past.'),
(12, 3, 'Chengdu', 'Chengdu, the capital of Sichuan Province, is famous for its spicy cuisine and as the home of the giant panda. Visit the Chengdu Research Base of Giant Panda Breeding, explore historic sites like Wuhou Shrine, and enjoy Sichuan hotpot.'),
(13, 4, 'Taipei', 'The capital of Taiwan, Taipei is a vibrant metropolis known for its towering skyscrapers, bustling night markets, and historic temples. Must-visit attractions include the iconic Taipei 101, the National Palace Museum, Longshan Temple, and the lively Shilin Night Market.'),
(14, 4, 'Taichung', 'Taichung is often considered the cultural capital of Taiwan, with a thriving arts and cultural scene. It\'s home to the National Taiwan Museum of Fine Arts, and the Rainbow Village, a colorful and artistic village. The city also offers beautiful parks and gardens, like Calligraphy Greenway and Taichung Park.'),
(15, 4, 'Kaohsiung', 'Kaohsiung, located in southern Taiwan, is a city known for its vibrant arts scene, beautiful parks, and scenic waterfront. Explore Lotus Pond, visit the Pier-2 Art Center, and enjoy local street food along Liuhe Night Market.'),
(16, 4, 'Tainan', 'Tainan is one of Taiwan\'s oldest cities with a rich history. Visit Chihkan Tower, Anping Fort, and Koxinga Shrine. Don\'t miss the opportunity to savor Tainan\'s famous street food and traditional snacks.'),
(17, 5, 'Hanoi', 'The capital and largest city of Vietnam, Hanoi is a blend of old-world charm and modern vitality. Explore the historic Old Quarter, visit Hoan Kiem Lake and Ngoc Son Temple, and delve into the country\'s history at the Ho Chi Minh Mausoleum. Hanoi is also famous for its street food, offering delicious and affordable culinary delights.'),
(18, 5, 'Ho Chi Minh City', 'As the largest city in Vietnam, Ho Chi Minh City is a bustling, dynamic metropolis. Explore the War Remnants Museum, visit the Cu Chi Tunnels, and take a stroll along the busy streets of District 1. The city also offers a vibrant nightlife scene and numerous shopping opportunities.'),
(19, 5, 'Hoi An', 'Hoi An is a charming and well-preserved ancient town known for its lantern-lit streets, historic architecture, and tailor shops. Explore the Old Town, visit the Japanese Covered Bridge, and enjoy the local cuisine.'),
(20, 5, 'Da Nang', 'Da Nang is a coastal city with beautiful beaches and a growing reputation as a tourist destination. Explore the Marble Mountains, visit My Khe Beach, and take a day trip to the ancient town of Hoi An.'),
(21, 6, 'Phnom Penh', 'Phnom Penh, the capital of Cambodia, is a city that has risen from a troubled history to become a vibrant and lively place. Visit the Royal Palace, the Silver Pagoda, and the Tuol Sleng Genocide Museum to learn about Cambodia\'s past. The city also offers a range of dining and entertainment options.'),
(22, 6, 'Siem Reap', 'Siem Reap is a gateway to the world-famous Angkor Wat temple complex, a UNESCO World Heritage Site. Explore the Angkor Archaeological Park with its ancient temples, including Bayon and Ta Prohm. Siem Reap also offers a lively night market and a thriving arts and culture scene.'),
(23, 6, 'Battambang', 'Battambang is a tranquil and picturesque city known for its French colonial architecture, beautiful countryside, and artistic community. Take a ride on the Bamboo Train, explore Phare Ponleu Selpak (an arts center), and visit the historic temples and museums.'),
(24, 6, 'Kampot', 'Kampot is a small, riverside town that offers a laid-back atmosphere and stunning natural surroundings. Explore the picturesque Bokor Hill Station, enjoy a boat trip along the Preaek Tuek Chhu River, and sample the local specialty, Kampot pepper. Nearby Kep is also known for its coastal beauty and crab market'),
(25, 7, 'Bangkok', 'The capital and largest city of Thailand, Bangkok is a vibrant metropolis that offers a mix of ancient temples, modern skyscrapers, and bustling markets. Visit the Grand Palace, Wat Pho, and Wat Arun, explore the historic district of Rattanakosin Island, and experience the vibrant street life of Khao San Road.'),
(26, 7, 'Chiang Mai', 'Located in the mountainous region of northern Thailand, Chiang Mai is known for its rich cultural heritage and beautiful natural surroundings. Explore historic temples like Wat Phra Singh, take part in traditional Thai cooking classes, and visit the famous Night Bazaar. The city is also a gateway to the nearby jungles and hill tribes.'),
(27, 7, 'Phuket', 'Phuket is Thailand\'s largest island and a popular beach destination. Relax on the beautiful beaches, explore Old Phuket Town, and enjoy water activities like snorkeling and diving. The island offers a vibrant nightlife scene.'),
(28, 7, 'Krabi', 'Krabi is known for its stunning limestone karsts, clear waters, and outdoor adventures. Visit Railay Beach, go rock climbing, explore the Thung Teao Forest Natural Park, and take boat trips to nearby islands like Phi Phi.'),
(29, 8, 'Vientiane', 'Vientiane is the capital and largest city of Laos. Despite its status, it maintains a laid-back atmosphere. Explore the serene Wat Pha That Luang, stroll along the Mekong River promenade, and visit the Buddha Park (Xieng Khuan). The city also offers French colonial architecture, vibrant markets, and delicious Lao cuisine.'),
(30, 8, 'Luang Prabang', 'Luang Prabang is a UNESCO World Heritage Site known for its well-preserved traditional architecture, Buddhist temples, and serene atmosphere. Explore the Royal Palace Museum, visit the sacred Kuang Si Waterfall, and witness the daily almsgiving ceremony. The town is surrounded by stunning natural beauty and the Mekong River'),
(31, 8, 'Pakse', 'Pakse is the largest city in southern Laos and serves as a gateway to the Bolaven Plateau, famous for its coffee plantations and waterfalls. Visit the Wat Luang temple, take a scenic drive through the plateau, and explore the traditional villages of the region'),
(32, 8, 'Savannakhet', 'Savannakhet is a charming town on the banks of the Mekong River, offering a glimpse into Lao culture and colonial history. Explore the historic district with well-preserved French colonial buildings, visit the Wat Sainyaphum temple, and enjoy the tranquil riverfront.'),
(33, 9, 'Dhaka', 'As the capital and largest city of Bangladesh, Dhaka is a bustling metropolis with a mix of historic landmarks and modern developments. Visit Lalbagh Fort, the Star Mosque, and Ahsan Manzil for a glimpse of the city\'s history. Explore the vibrant street markets and savor delicious Bangladeshi cuisine.'),
(34, 9, 'Chittagong', 'Chittagong is the second-largest city and the main seaport of Bangladesh. It\'s known for its beautiful coastline, rolling hills, and lush greenery. Visit Foy\'s Lake for a scenic getaway, explore the hill station of Bandarban, and experience the diverse cultures of the Chittagong Hill Tracts.'),
(35, 9, 'Sylhet', 'Sylhet is a city in the northeastern part of Bangladesh, famous for its picturesque tea gardens, rolling hills, and numerous waterfalls. Explore the Sylhet tea estates, visit Ratnodweep, and take a journey to Jaflong, a scenic area along the border with India.'),
(36, 9, 'Rajshahi', 'Located in the northwest of Bangladesh, Rajshahi is known for its silk industry and archaeological sites. Explore the historic Varendra Research Museum, visit the Paharpur Vihara (a UNESCO World Heritage Site), and take in the beauty of the Padma River.'),
(37, 10, 'Thimphu', 'Thimphu is the capital and largest city of Bhutan. It\'s a blend of modernity and tradition, where you can visit iconic sites like Tashichho Dzong, the National Memorial Chorten, and the Giant Buddha Dordenma statue. Explore the vibrant local markets, and get a sense of Bhutan\'s unique cultural heritage.'),
(38, 10, 'Paro', 'Paro is a picturesque town and the location of Bhutan\'s only international airport. It\'s surrounded by lush valleys and is famous for the stunning Taktsang Monastery, also known as the \'Tiger\'s Nest.\' You can also visit the Rinpung Dzong, National Museum, and the town\'s unique architecture.'),
(39, 10, 'Punakha', 'Punakha, the former capital of Bhutan, is known for its beautiful Punakha Dzong, a fortress at the confluence of two rivers. The city offers a glimpse into Bhutan\'s history and culture. Don\'t miss the suspension bridge and the scenic countryside.'),
(40, 10, 'Bumthang Valley', 'Bumthang Valley is a group of towns in central Bhutan, often considered the spiritual heart of the country. Explore the ancient monasteries, including Jambay Lhakhang and Kurje Lhakhang. Bumthang is also known for its beautiful landscapes and fertile valleys.'),
(41, 11, 'Kuala Lumpur', 'The capital and largest city of Malaysia, Kuala Lumpur is a bustling metropolis with a striking skyline. Visit the iconic Petronas Twin Towers, explore the Batu Caves, and experience the blend of cultures in areas like Chinatown and Little India. The city is also known for its vibrant street food scene.'),
(42, 11, 'George Town, Penang', 'Located on Penang Island, George Town is a UNESCO World Heritage Site renowned for its well-preserved colonial architecture and multicultural heritage. Explore the historic streets, visit clan houses, and savor the diverse cuisine, which includes Peranakan and Indian dishes.'),
(43, 11, 'Malacca', 'Malacca is another UNESCO World Heritage Site, known for its rich history as a trading port. Explore the historic district with its Dutch and Portuguese colonial buildings, visit St. Paul\'s Hill and A Famosa fortress, and take a river cruise to discover the city\'s charm.'),
(44, 11, 'Ipoh', 'Ipoh is a city in Peninsular Malaysia known for its colonial-era architecture and culinary scene. Explore the charming old town, visit Kek Lok Tong Cave Temple, and enjoy the city\'s famous white coffee. Ipoh also offers access to the stunning Kek Lok Tong limestone cave.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sessions`
--

CREATE TABLE `sessions` (
  `token` varchar(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `sessions`
--

INSERT INTO `sessions` (`token`, `user_id`, `expires_at`) VALUES
('0413ddcf23b63c790c5b4132be4724c4ab91fcddb150d8d44de0d6a719eab079', 9, 1698087251),
('79271cabe5c3528963222bd9c165f85bd3ad364ef8b1755e0d7eee008a9641b7', 1, 1698094040),
('9a182a3eadc8311a2f613bb8a34d2c97b4d8eaee4b8c9c7ada8e6db9df589e70', 1, 1698086206);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(70) NOT NULL,
  `dob` date NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `login`, `email`, `password`, `name`, `surname`, `dob`, `is_admin`) VALUES
(1, 'banana', 'baba@gmail.com', '$2y$10$dt2TPPMcR2nEzLkQUWswgezEeglkBC9I7EeZvN8iYnqM2dK6Sh.aa', 'jack', 'appleson', '0000-00-00', 1),
(2, 'admin', 'admin@gmail.com', '$2y$10$gBGsV23TaWxLonyYGyJLdexmvBFFZZrMVvJcF.F54Nu4Dfpfoi1Ni', 'jack', 'apple', '0000-00-00', 1),
(3, 'testaccount1', 'ggg@gmail.com', '$2y$10$KxJP5oIr943PTSkB1YiLq.55SFaXnQnYoxJOMw7mGRhl.fWBMGTpa', 'ggg', 'gaygg', '2023-10-25', NULL),
(4, 'abd', 'b@g', '$2y$10$vISnnENoDPyEswuO1zwkMuoCknmgBf4yWqeRQCLsA99fB9MWquF5O', 'ads', 'dbadbsd', '2023-10-21', NULL),
(5, 'apple', 'apple@gmail.com', '$2y$10$8LIQ0yq5sA4aBSJPM9RdXelqKrLBiZ7fMlmr.nHrTupU9ER66DJ7q', 'x', 'x', '2023-10-05', NULL),
(6, 'pear', 'pear@g', '$2y$10$/RxdatjR46wmQIL/fA46geUHi.E6heKi99RKlDndBS9eiaU82GHoy', 'pear', 'pear', '2023-10-07', NULL),
(9, 'test', 'poopy@gmail.com', '$2y$10$Ck/Z1jXjocQNufUUusy.F.y4Q3TJSrFM9EjtT6CgiysvGSKjOtUaW', 'my pass is', 'poop', '2023-10-03', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_bookings`
--

CREATE TABLE `user_bookings` (
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indeksy dla tabeli `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indeksy dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `user_bookings`
--
ALTER TABLE `user_bookings`
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`);

--
-- Ograniczenia dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `user_bookings`
--
ALTER TABLE `user_bookings`
  ADD CONSTRAINT `user_bookings_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `booking` (`book_id`),
  ADD CONSTRAINT `user_bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
